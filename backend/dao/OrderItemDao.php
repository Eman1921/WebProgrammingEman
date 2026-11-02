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
}
