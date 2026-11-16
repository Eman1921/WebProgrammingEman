<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/Validator.php';
require_once __DIR__ . '/../dao/CategoryDao.php';
require_once __DIR__ . '/../dao/KitDao.php';

class CategoryService extends BaseService
{
    private KitDao $kit_dao;

    public function __construct()
    {
        parent::__construct(new CategoryDao(), 'Category');
        $this->kit_dao = new KitDao();
    }

    public function add(array $data): array
    {
        $data = $this->validate($data);
        return $this->dao->add($data);
    }

    public function update(array $data, int $id): array
    {
        $this->get_by_id($id);
        $data = $this->validate($data, $id);
        return $this->update_record($data, $id);
    }

    public function delete(int $id): bool
    {
        $this->get_by_id($id);
        if (count($this->kit_dao->get_by_category($id)) > 0) {
            throw new ValidationException('Delete the kits in this category before deleting the category.');
        }
        return parent::delete($id);
    }

    private function validate(array $data, int $id = 0): array
    {
        Validator::required($data, ['name']);
        Validator::string($data, 'name', 2, 100);
        if (array_key_exists('description', $data)) {
            Validator::string($data, 'description', 0, 5000, true);
        }

        $data['name'] = trim($data['name']);
        foreach ($this->dao->get_all() as $category) {
            if (strtolower($category['name']) === strtolower($data['name']) && (int) $category['id'] !== $id) {
                throw new ValidationException('A category with this name already exists.');
            }
        }

        unset($data['id']);
        return $data;
    }
}
