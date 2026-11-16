<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/Validator.php';
require_once __DIR__ . '/UserService.php';
require_once __DIR__ . '/../dao/OrderDao.php';
require_once __DIR__ . '/../dao/OrderItemDao.php';

class OrderService extends BaseService
{
    private UserService $user_service;
    private OrderItemDao $order_item_dao;

    public function __construct()
    {
        parent::__construct(new OrderDao(), 'Order');
        $this->user_service = new UserService();
        $this->order_item_dao = new OrderItemDao();
    }

    public function add(array $data): array
    {
        $data = $this->validate($data);
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }
        return $this->dao->add($data);
    }

    public function update(array $data, int $id): array
    {
        $this->get_by_id($id);
        $data = $this->validate($data);
        return $this->update_record($data, $id);
    }

    public function delete(int $id): bool
    {
        $this->get_by_id($id);
        if (count($this->order_item_dao->get_by_order($id)) > 0) {
            throw new ValidationException('Delete the order items before deleting the order.');
        }
        return parent::delete($id);
    }

    private function validate(array $data): array
    {
        Validator::required($data, ['user_id', 'total_amount']);
        $data['user_id'] = Validator::integer($data, 'user_id', 1, PHP_INT_MAX);
        $this->user_service->get_by_id($data['user_id']);
        $data['total_amount'] = Validator::number($data, 'total_amount', 0);
        if (array_key_exists('status', $data)) {
            $data['status'] = Validator::choice($data, 'status', ['pending', 'paid', 'shipped', 'delivered', 'cancelled']);
        }
        unset($data['id'], $data['created_at']);
        return $data;
    }
}
