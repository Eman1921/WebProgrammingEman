<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/Validator.php';
require_once __DIR__ . '/UserService.php';
require_once __DIR__ . '/KitService.php';
require_once __DIR__ . '/../dao/ReviewDao.php';

class ReviewService extends BaseService
{
    private UserService $user_service;
    private KitService $kit_service;

    public function __construct()
    {
        parent::__construct(new ReviewDao(), 'Review');
        $this->user_service = new UserService();
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
        unset($data['user_id'], $data['kit_id']);
        return $this->update_record($data, $id);
    }

    private function validate(array $data): array
    {
        Validator::required($data, ['user_id', 'kit_id', 'rating']);
        $data['user_id'] = Validator::integer($data, 'user_id', 1, PHP_INT_MAX);
        $data['kit_id'] = Validator::integer($data, 'kit_id', 1, PHP_INT_MAX);
        $data['rating'] = Validator::integer($data, 'rating', 1, 5);
        $this->user_service->get_by_id($data['user_id']);
        $this->kit_service->get_by_id($data['kit_id']);
        if (array_key_exists('comment', $data)) {
            Validator::string($data, 'comment', 0, 5000, true);
        }
        unset($data['id'], $data['created_at']);
        return $data;
    }
}
