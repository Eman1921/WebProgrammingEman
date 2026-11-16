<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/Validator.php';
require_once __DIR__ . '/OrderService.php';
require_once __DIR__ . '/KitService.php';
require_once __DIR__ . '/../dao/OrderItemDao.php';

class OrderItemService extends BaseService
{
    private OrderService $order_service;
    private KitService $kit_service;

    public function __construct()
    {
        parent::__construct(new OrderItemDao(), 'Order item');
        $this->order_service = new OrderService();
        $this->kit_service = new KitService();
    }

    public function add(array $data): array
    {
        $data = $this->validate($data);
        return $this->dao->add($data);
    }

    public function update(array $data, int $id): array
    {
        $this->get_by_id($id);
        $data = $this->validate($data);
        return $this->update_record($data, $id);
    }

    private function validate(array $data): array
    {
        Validator::required($data, ['order_id', 'kit_id', 'quantity', 'unit_price']);
        $data['order_id'] = Validator::integer($data, 'order_id', 1, PHP_INT_MAX);
        $data['kit_id'] = Validator::integer($data, 'kit_id', 1, PHP_INT_MAX);
        $data['quantity'] = Validator::integer($data, 'quantity', 1, PHP_INT_MAX);
        $data['unit_price'] = Validator::number($data, 'unit_price', 0);
        $this->order_service->get_by_id($data['order_id']);
        $this->kit_service->get_by_id($data['kit_id']);
        unset($data['id']);
        return $data;
    }
}
