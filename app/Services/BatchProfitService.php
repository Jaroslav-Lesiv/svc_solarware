<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BatchProfitService
{
    public function calculate(): Collection
    {
        return collect(DB::select(<<<'SQL'
            SELECT
                b.id           AS batch_id,
                b.purchased_at,
                p.name         AS provider,
                ROUND(COALESCE(rev.gross,  0) - COALESCE(cref.total, 0), 2) AS net_revenue,
                ROUND(COALESCE(cost.gross, 0) - COALESCE(pref.total, 0), 2) AS net_cost,
                ROUND(
                    (COALESCE(rev.gross,  0) - COALESCE(cref.total, 0)) -
                    (COALESCE(cost.gross, 0) - COALESCE(pref.total, 0)),
                    2
                ) AS profit
            FROM batches b
            JOIN providers p ON p.id = b.provider_id
            LEFT JOIN (
                SELECT bp.batch_id, SUM(oi.qty * oi.unit_price) AS gross
                FROM batch_products bp
                JOIN order_items oi ON oi.batch_product_id = bp.id
                GROUP BY bp.batch_id
            ) rev  ON rev.batch_id  = b.id
            LEFT JOIN (
                SELECT bp.batch_id, SUM(cr.qty * oi.unit_price) AS total
                FROM batch_products bp
                JOIN order_items oi ON oi.batch_product_id = bp.id
                JOIN client_refunds cr ON cr.order_item_id = oi.id
                GROUP BY bp.batch_id
            ) cref ON cref.batch_id = b.id
            LEFT JOIN (
                SELECT batch_id, SUM(qty * unit_cost) AS gross
                FROM batch_products
                GROUP BY batch_id
            ) cost ON cost.batch_id = b.id
            LEFT JOIN (
                SELECT bp.batch_id, SUM(pr.qty * bp.unit_cost) AS total
                FROM batch_products bp
                JOIN provider_refunds pr ON pr.batch_product_id = bp.id
                GROUP BY bp.batch_id
            ) pref ON pref.batch_id = b.id
        SQL));
    }
}
