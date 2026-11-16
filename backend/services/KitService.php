<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/Validator.php';
require_once __DIR__ . '/CategoryService.php';
require_once __DIR__ . '/../dao/KitDao.php';
require_once __DIR__ . '/../dao/OrderItemDao.php';
require_once __DIR__ . '/../dao/ReviewDao.php';

class KitService extends BaseService
{
    private CategoryService $category_service;
    private OrderItemDao $order_item_dao;
    private ReviewDao $review_dao;

    public function __construct()
    {
        parent::__construct(new KitDao(), 'Kit');
        $this->category_service = new CategoryService();
        $this->order_item_dao = new OrderItemDao();
        $this->review_dao = new ReviewDao();
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

    public function delete(int $id): bool
    {
        $this->get_by_id($id);
        if (count($this->order_item_dao->get_by_kit($id)) > 0 || count($this->review_dao->get_by_kit($id)) > 0) {
            throw new ValidationException('Delete the kit order items and reviews before deleting the kit.');
        }
        return parent::delete($id);
    }

    private function validate(array $data): array
    {
        Validator::required($data, ['category_id', 'team_name', 'season', 'kit_type', 'name', 'size', 'price', 'stock_quantity', 'image_path']);
        $data['category_id'] = Validator::integer($data, 'category_id', 1, PHP_INT_MAX);
        $this->category_service->get_by_id($data['category_id']);
        Validator::string($data, 'team_name', 1, 100);
        Validator::string($data, 'season', 1, 20);
        Validator::string($data, 'kit_type', 1, 40);
        Validator::string($data, 'name', 1, 150);
        Validator::string($data, 'size', 1, 10);
        Validator::string($data, 'image_path', 1, 255);
        if (array_key_exists('description', $data)) {
            Validator::string($data, 'description', 0, 5000, true);
        }
        $data['price'] = Validator::number($data, 'price', 0);
        $data['stock_quantity'] = Validator::integer($data, 'stock_quantity', 0, PHP_INT_MAX);
        foreach (['team_name', 'season', 'kit_type', 'name', 'size', 'image_path'] as $field) {
            $data[$field] = trim($data[$field]);
        }
        unset($data['id']);
        return $data;
    }
}
