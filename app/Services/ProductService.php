<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function available(): Collection
    {
        return collect(DB::select(<<<'SQL'
            SELECT
                p.id,
                p.name,
                c.name AS category_name,
                p.price,
                COALESCE(purchased.qty, 0)
                    - COALESCE(sold.qty, 0)
                    - COALESCE(pref.qty,  0)
                    + COALESCE(cret.qty,  0) AS qty
            FROM products p
            JOIN categories c ON c.id = p.category_id
            LEFT JOIN (
                SELECT product_id, SUM(qty) AS qty
                FROM batch_products
                GROUP BY product_id
            ) purchased ON purchased.product_id = p.id
            LEFT JOIN (
                SELECT bp.product_id, SUM(oi.qty) AS qty
                FROM batch_products bp
                JOIN order_items oi ON oi.batch_product_id = bp.id
                GROUP BY bp.product_id
            ) sold ON sold.product_id = p.id
            LEFT JOIN (
                SELECT bp.product_id, SUM(pr.qty) AS qty
                FROM batch_products bp
                JOIN provider_refunds pr ON pr.batch_product_id = bp.id
                GROUP BY bp.product_id
            ) pref ON pref.product_id = p.id
            LEFT JOIN (
                SELECT bp.product_id, SUM(cr.qty) AS qty
                FROM batch_products bp
                JOIN order_items oi ON oi.batch_product_id = bp.id
                JOIN client_refunds cr ON cr.order_item_id = oi.id
                GROUP BY bp.product_id
            ) cret ON cret.product_id = p.id
            HAVING qty > 0
        SQL));
    }
}
