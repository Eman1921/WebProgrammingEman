<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/Validator.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/OrderDao.php';
require_once __DIR__ . '/../dao/ReviewDao.php';

class UserService extends BaseService
{
    private OrderDao $order_dao;
    private ReviewDao $review_dao;

    public function __construct()
    {
        parent::__construct(new UserDao(), 'User');
        $this->order_dao = new OrderDao();
        $this->review_dao = new ReviewDao();
    }

    public function get_all(): array
    {
        return array_map([$this, 'without_password_hash'], parent::get_all());
    }

    public function get_by_id(int $id): array
    {
        return $this->without_password_hash(parent::get_by_id($id));
    }

    public function add(array $data): array
    {
        $data = $this->validate($data);
        return $this->without_password_hash($this->dao->add($data));
    }

    public function update(array $data, int $id): array
    {
        $this->get_by_id($id);
        $data = $this->validate($data, $id);
        return $this->without_password_hash($this->update_record($data, $id));
    }

    public function delete(int $id): bool
    {
        $this->get_by_id($id);
        if (count($this->order_dao->get_by_user($id)) > 0 || count($this->review_dao->get_by_user($id)) > 0) {
            throw new ValidationException('Delete the user orders and reviews before deleting the user.');
        }
        return parent::delete($id);
    }

    private function validate(array $data, int $id = 0): array
    {
        Validator::required($data, ['first_name', 'last_name', 'email', 'password_hash', 'role']);
        Validator::string($data, 'first_name', 1, 100);
        Validator::string($data, 'last_name', 1, 100);
        Validator::string($data, 'email', 3, 150);
        Validator::string($data, 'password_hash', 1, 255);
        Validator::choice($data, 'role', ['customer', 'admin']);

        $data['first_name'] = trim($data['first_name']);
        $data['last_name'] = trim($data['last_name']);
        $data['email'] = strtolower(trim($data['email']));
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            throw new ValidationException("Field 'email' must be a valid email address.");
        }

        foreach ($this->dao->get_all() as $user) {
            if (strtolower($user['email']) === $data['email'] && (int) $user['id'] !== $id) {
                throw new ValidationException('A user with this email address already exists.');
            }
        }

        unset($data['id']);
        return $data;
    }

    private function without_password_hash(array $user): array
    {
        unset($user['password_hash']);
        return $user;
    }
}
