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
}
