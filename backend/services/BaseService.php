<?php

require_once __DIR__ . '/../dao/BaseDao.php';
require_once __DIR__ . '/HttpException.php';

abstract class BaseService
{
    protected BaseDao $dao;
    protected string $entity_name;

    public function __construct(BaseDao $dao, string $entity_name)
    {
        $this->dao = $dao;
        $this->entity_name = $entity_name;
    }

    public function get_all(): array
    {
        return $this->dao->get_all();
    }

    public function get_by_id(int $id): array
    {
        $record = $id > 0 ? $this->dao->get_by_id($id) : null;
        if ($record === null) {
            throw new NotFoundException($this->entity_name . ' not found.');
        }

        return $record;
    }

    protected function update_record(array $data, int $id): array
    {
        $this->get_by_id($id);
        $this->dao->update($data, $id);
        return $this->get_by_id($id);
    }

    public function delete(int $id): bool
    {
        $this->get_by_id($id);
        return $this->dao->delete($id);
    }
}
