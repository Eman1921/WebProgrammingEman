# GrbZem Database Schema

This document describes the Milestone 2 MySQL schema. The executable schema and sample rows are in `database/grbzem.sql`.

## Entities and fields

### `users`

| Field | Type | Rules |
| --- | --- | --- |
| `id` | INT | Primary key, auto-increment |
| `first_name` | VARCHAR(100) | Required |
| `last_name` | VARCHAR(100) | Required |
| `email` | VARCHAR(150) | Required, unique |
| `password_hash` | VARCHAR(255) | Required; stores a password hash |
| `role` | ENUM('customer', 'admin') | Required, defaults to `customer` |
| `created_at` | TIMESTAMP | Defaults to the current time |

### `categories`

| Field | Type | Rules |
| --- | --- | --- |
| `id` | INT | Primary key, auto-increment |
| `name` | VARCHAR(100) | Required, unique |
| `description` | TEXT | Optional |

### `kits`

| Field | Type | Rules |
| --- | --- | --- |
| `id` | INT | Primary key, auto-increment |
| `category_id` | INT | Required foreign key to `categories.id` |
| `team_name` | VARCHAR(100) | Required |
| `season` | VARCHAR(20) | Required |
| `kit_type` | VARCHAR(40) | Required |
| `name` | VARCHAR(150) | Required |
| `description` | TEXT | Optional |
| `size` | VARCHAR(10) | Required |
| `price` | DECIMAL(10,2) | Required; zero or greater |
| `stock_quantity` | INT | Required; defaults to 0 and cannot be negative |
| `image_path` | VARCHAR(255) | Required |

### `orders`

| Field | Type | Rules |
| --- | --- | --- |
| `id` | INT | Primary key, auto-increment |
| `user_id` | INT | Required foreign key to `users.id` |
| `status` | ENUM('pending', 'paid', 'shipped', 'delivered', 'cancelled') | Required, defaults to `pending` |
| `total_amount` | DECIMAL(10,2) | Required; zero or greater |
| `created_at` | TIMESTAMP | Defaults to the current time |

### `order_items`

| Field | Type | Rules |
| --- | --- | --- |
| `id` | INT | Primary key, auto-increment |
| `order_id` | INT | Required foreign key to `orders.id` |
| `kit_id` | INT | Required foreign key to `kits.id` |
| `quantity` | INT | Required; greater than zero |
| `unit_price` | DECIMAL(10,2) | Required; zero or greater |

### `reviews`

| Field | Type | Rules |
| --- | --- | --- |
| `id` | INT | Primary key, auto-increment |
| `user_id` | INT | Required foreign key to `users.id` |
| `kit_id` | INT | Required foreign key to `kits.id` |
| `rating` | TINYINT | Required; between 1 and 5 |
| `comment` | TEXT | Optional |
| `created_at` | TIMESTAMP | Defaults to the current time |

## Relationships

- One category can have many kits; each kit belongs to one category.
- One user can have many orders; each order belongs to one user.
- One order can have many order items; each order item belongs to one order.
- One kit can appear in many order items; each order item refers to one kit.
- One user can write many reviews; each review belongs to one user.
- One kit can have many reviews; each review belongs to one kit.

Foreign keys use `ON DELETE RESTRICT` so a referenced row cannot be deleted while related records exist. The schema also enforces unique user emails and category names, allowed role and order-status values, and numeric checks for kit stock, prices, order totals, quantities, and review ratings.
