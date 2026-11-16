<?php

require_once __DIR__ . '/BaseDao.php';

class OrderItemDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('order_items', [
            'order_id',
            'kit_id',
            'quantity',
            'unit_price'
        ]);
    }

    public function get_by_order(int $order_id): array
    {
        return $this->query(
            'SELECT * FROM order_items WHERE order_id = :order_id ORDER BY id',
            ['order_id' => $order_id]
        );
    }

    public function get_by_kit(int $kit_id): array
    {
        return $this->query(
            'SELECT * FROM order_items WHERE kit_id = :kit_id ORDER BY id',
            ['kit_id' => $kit_id]
        );
    }
}
