<?php

require_once __DIR__ . '/BaseDao.php';

class ReviewDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('reviews', [
            'user_id',
            'kit_id',
            'rating',
            'comment'
        ]);
    }

    public function get_by_user(int $user_id): array
    {
        return $this->query(
            'SELECT * FROM reviews WHERE user_id = :user_id ORDER BY id',
            ['user_id' => $user_id]
        );
    }

    public function get_by_kit(int $kit_id): array
    {
        return $this->query(
            'SELECT * FROM reviews WHERE kit_id = :kit_id ORDER BY id',
            ['kit_id' => $kit_id]
        );
    }
}
