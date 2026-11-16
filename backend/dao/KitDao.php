<?php

require_once __DIR__ . '/BaseDao.php';

class KitDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('kits', [
            'category_id',
            'team_name',
            'season',
            'kit_type',
            'name',
            'description',
            'size',
            'price',
            'stock_quantity',
            'image_path'
        ]);
    }

    public function get_by_category(int $category_id): array
    {
        return $this->query(
            'SELECT * FROM kits WHERE category_id = :category_id ORDER BY id',
            ['category_id' => $category_id]
        );
    }
}
