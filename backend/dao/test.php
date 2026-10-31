<?php

require_once __DIR__ . '/UserDao.php';
require_once __DIR__ . '/CategoryDao.php';
require_once __DIR__ . '/KitDao.php';
require_once __DIR__ . '/OrderDao.php';
require_once __DIR__ . '/OrderItemDao.php';
require_once __DIR__ . '/ReviewDao.php';

$userDao = new UserDao();
$categoryDao = new CategoryDao();
$kitDao = new KitDao();
$orderDao = new OrderDao();
$orderItemDao = new OrderItemDao();
$reviewDao = new ReviewDao();

$categoryDao->begin_transaction();

try {
    $category = $categoryDao->add([
        'name' => 'DAO test ' . date('His'),
        'description' => 'Temporary DAO test category'
    ]);
    $categoryId = $category['id'];

    $user = $userDao->add([
        'first_name' => 'DAO',
        'last_name' => 'Test',
        'email' => 'dao-test-' . date('YmdHis') . '@example.com',
        'password_hash' => password_hash('TestPassword123', PASSWORD_DEFAULT),
        'role' => 'customer'
    ]);
    $userId = $user['id'];

    $kit = $kitDao->add([
        'category_id' => $categoryId,
        'team_name' => 'DAO Test Club',
        'season' => '2026/27',
        'kit_type' => 'home',
        'name' => 'DAO Test Shirt',
        'description' => 'Temporary DAO test kit',
        'size' => 'M',
        'price' => 10.00,
        'stock_quantity' => 2,
        'image_path' => 'test-image.png',
        'hacker_column' => 'not saved'
    ]);
    $kitId = $kit['id'];

    $order = $orderDao->add([
        'user_id' => $userId,
        'status' => 'pending',
        'total_amount' => 10.00
    ]);
    $orderId = $order['id'];

    $orderItem = $orderItemDao->add([
        'order_id' => $orderId,
        'kit_id' => $kitId,
        'quantity' => 1,
        'unit_price' => 10.00
    ]);
    $orderItemId = $orderItem['id'];

    $review = $reviewDao->add([
        'user_id' => $userId,
        'kit_id' => $kitId,
        'rating' => 5,
        'comment' => 'Temporary DAO test review'
    ]);
    $reviewId = $review['id'];

    if ($categoryDao->get_by_id($categoryId) === null) {
        throw new RuntimeException('Category read failed.');
    }
    if ($userDao->get_by_id($userId) === null) {
        throw new RuntimeException('User read failed.');
    }
    if ($kitDao->get_by_id($kitId) === null) {
        throw new RuntimeException('Kit read failed.');
    }
    if ($orderDao->get_by_id($orderId) === null) {
        throw new RuntimeException('Order read failed.');
    }
    if ($orderItemDao->get_by_id($orderItemId) === null) {
        throw new RuntimeException('Order item read failed.');
    }
    if ($reviewDao->get_by_id($reviewId) === null) {
        throw new RuntimeException('Review read failed.');
    }
    if (!$categoryDao->update(['description' => 'Updated DAO test category'], $categoryId)) {
        throw new RuntimeException('Category update failed.');
    }
    if (!$userDao->update(['role' => 'admin'], $userId)) {
        throw new RuntimeException('User update failed.');
    }
    if (!$kitDao->update(['stock_quantity' => 3], $kitId)) {
        throw new RuntimeException('Kit update failed.');
    }
    if (!$orderDao->update(['total_amount' => 11.00], $orderId)) {
        throw new RuntimeException('Order update failed.');
    }
    if (!$orderItemDao->update(['quantity' => 2], $orderItemId)) {
        throw new RuntimeException('Order item update failed.');
    }
    if (!$reviewDao->update(['rating' => 4], $reviewId)) {
        throw new RuntimeException('Review update failed.');
    }
    if ($kitDao->get_by_id($kitId)['hacker_column'] ?? false) {
        throw new RuntimeException('Column whitelist failed.');
    }
    if (isset($userDao->get_all()[0]['password_hash'])) {
        throw new RuntimeException('User list exposed a password hash.');
    }

    try {
        $reviewDao->add([
            'user_id' => $userId,
            'kit_id' => $kitId,
            'rating' => 6,
            'comment' => 'Invalid test rating'
        ]);
        throw new RuntimeException('Review rating constraint was not enforced.');
    } catch (PDOException $error) {
    }

    try {
        $kitDao->add([
            'category_id' => 999999,
            'team_name' => 'Invalid test club',
            'season' => '2026/27',
            'kit_type' => 'home',
            'name' => 'Invalid test shirt',
            'size' => 'M',
            'price' => 10.00,
            'stock_quantity' => 1,
            'image_path' => 'test-image.png'
        ]);
        throw new RuntimeException('Kit category foreign key was not enforced.');
    } catch (PDOException $error) {
    }

    if (
        $userDao->count_all() < 1
        || $categoryDao->count_all() < 1
        || $kitDao->count_all() < 1
        || $orderDao->count_all() < 1
        || $orderItemDao->count_all() < 1
        || $reviewDao->count_all() < 1
    ) {
        throw new RuntimeException('DAO count failed.');
    }

    if (!$reviewDao->delete($reviewId)) {
        throw new RuntimeException('Review delete failed.');
    }
    if (!$orderItemDao->delete($orderItemId)) {
        throw new RuntimeException('Order item delete failed.');
    }
    if (!$orderDao->delete($orderId)) {
        throw new RuntimeException('Order delete failed.');
    }
    if (!$kitDao->delete($kitId)) {
        throw new RuntimeException('Kit delete failed.');
    }
    if (!$userDao->delete($userId)) {
        throw new RuntimeException('User delete failed.');
    }
    if (!$categoryDao->delete($categoryId)) {
        throw new RuntimeException('Category delete failed.');
    }

    echo "All six DAOs passed create, read, update, delete, and count checks.\n";
    echo "The writable-column check passed and user lists omit password hashes.\n";
    echo "Review rating and kit category database constraints passed.\n";
    echo "Test changes were rolled back.\n";
    $categoryDao->rollback();
} catch (Throwable $error) {
    $categoryDao->rollback();
    fwrite(STDERR, $error->getMessage() . "\n");
    exit(1);
}
