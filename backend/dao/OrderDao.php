<?php

require_once __DIR__ . '/BaseDao.php';

class OrderDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('orders', ['user_id', 'status', 'total_amount']);
    }
}
