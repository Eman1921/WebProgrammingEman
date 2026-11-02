CREATE DATABASE IF NOT EXISTS grbzem
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE grbzem;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NULL
);

CREATE TABLE IF NOT EXISTS kits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    team_name VARCHAR(100) NOT NULL,
    season VARCHAR(20) NOT NULL,
    kit_type VARCHAR(40) NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    size VARCHAR(10) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    image_path VARCHAR(255) NOT NULL,
    CONSTRAINT fk_kits_category FOREIGN KEY (category_id)
        REFERENCES categories(id) ON DELETE RESTRICT,
    CONSTRAINT chk_kits_price CHECK (price >= 0),
    CONSTRAINT chk_kits_stock CHECK (stock_quantity >= 0)
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    status ENUM('pending', 'paid', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
    total_amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE RESTRICT,
    CONSTRAINT chk_orders_total CHECK (total_amount >= 0)
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    kit_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id)
        REFERENCES orders(id) ON DELETE RESTRICT,
    CONSTRAINT fk_order_items_kit FOREIGN KEY (kit_id)
        REFERENCES kits(id) ON DELETE RESTRICT,
    CONSTRAINT chk_order_items_quantity CHECK (quantity > 0),
    CONSTRAINT chk_order_items_price CHECK (unit_price >= 0)
);

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    kit_id INT NOT NULL,
    rating TINYINT NOT NULL,
    comment TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reviews_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE RESTRICT,
    CONSTRAINT fk_reviews_kit FOREIGN KEY (kit_id)
        REFERENCES kits(id) ON DELETE RESTRICT,
    CONSTRAINT chk_reviews_rating CHECK (rating BETWEEN 1 AND 5)
);

INSERT INTO users (id, first_name, last_name, email, password_hash, role) VALUES
(1, 'Sample', 'Customer', 'customer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'customer'),
(2, 'Sample', 'Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'admin');

INSERT INTO categories (id, name, description) VALUES
(1, 'Premier League Home Shirts', 'Home shirts from Premier League clubs.'),
(2, 'Classic Home Shirts', 'Selected shirts from previous Premier League seasons.');

INSERT INTO kits (id, category_id, team_name, season, kit_type, name, description, size, price, stock_quantity, image_path) VALUES
(1, 1, 'Manchester City', '2026/27', 'home', 'Home Shirt', 'Manchester City home shirt.', 'M', 84.00, 12, 'frontend/assets/images/man-city-home.png'),
(2, 1, 'Arsenal', '2026/27', 'home', 'Home Shirt', 'Arsenal home shirt.', 'M', 84.00, 10, 'frontend/assets/images/arsenal-home.png'),
(3, 1, 'Chelsea', '2026/27', 'home', 'Home Shirt', 'Chelsea home shirt.', 'M', 84.00, 8, 'frontend/assets/images/chelsea-home.jpg'),
(4, 1, 'Liverpool', '2026/27', 'home', 'Home Shirt', 'Liverpool home shirt.', 'M', 84.00, 9, 'frontend/assets/images/liverpool-home.png'),
(5, 2, 'Leeds United', '2025/26', 'home', 'Home Shirt', 'Leeds United home shirt.', 'M', 79.00, 6, 'frontend/assets/images/leeds-home.jpg');

INSERT INTO orders (id, user_id, status, total_amount) VALUES
(1, 1, 'paid', 168.00),
(2, 1, 'pending', 84.00);

INSERT INTO order_items (id, order_id, kit_id, quantity, unit_price) VALUES
(1, 1, 1, 1, 84.00),
(2, 1, 2, 1, 84.00),
(3, 2, 3, 1, 84.00);

INSERT INTO reviews (id, user_id, kit_id, rating, comment) VALUES
(1, 1, 1, 5, 'Good fit and comfortable fabric.'),
(2, 1, 2, 4, 'Good quality shirt.');
