<?php

require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('users', [
            'first_name',
            'last_name',
            'email',
            'password_hash',
            'role'
        ]);
    }

    public function get_all(): array
    {
        return $this->query(
            'SELECT id, first_name, last_name, email, role, created_at FROM users ORDER BY id'
        );
    }
}
