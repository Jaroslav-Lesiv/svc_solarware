<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StorageService
{
    public function remainingAt(string $date): Collection
    {
        return collect(DB::select(<<<'SQL'
            SELECT
                s.id AS storage_id,
                s.name AS storage_name,
                p.id AS product_id,
                p.name AS product_name,
                SUM(bp.qty - COALESCE(sold.qty, 0) - COALESCE(pref.qty, 0) + COALESCE(cret.qty, 0)) AS qty
            FROM batch_products bp
            JOIN batches b ON b.id = bp.batch_id
            JOIN products p ON p.id = bp.product_id
            JOIN storages s ON s.id = b.storage_id
            LEFT JOIN (
                SELECT oi.batch_product_id, SUM(oi.qty) AS qty
                FROM order_items oi
                JOIN orders o ON o.id = oi.order_id
                WHERE DATE(o.created_at) <= ?
                GROUP BY oi.batch_product_id
            ) sold ON sold.batch_product_id = bp.id
            LEFT JOIN (
                SELECT batch_product_id, SUM(qty) AS qty
                FROM provider_refunds
                WHERE refunded_at <= ?
                GROUP BY batch_product_id
            ) pref ON pref.batch_product_id = bp.id
            LEFT JOIN (
                SELECT oi.batch_product_id, SUM(cr.qty) AS qty
                FROM client_refunds cr
                JOIN order_items oi ON oi.id = cr.order_item_id
                WHERE cr.refunded_at <= ?
                GROUP BY oi.batch_product_id
            ) cret ON cret.batch_product_id = bp.id
            WHERE b.purchased_at <= ?
            GROUP BY s.id, s.name, p.id, p.name
            HAVING qty > 0
        SQL, [$date, $date, $date, $date]));
    }
}
