# Football Kits Shop Draft ERD

This is the Milestone 1 database plan. The schema, keys, constraints, sample rows, and SQL export are planned for Milestone 2.

```text
users 1 ───────< orders 1 ───────< order_items >─────── 1 kits >─────── 1 categories
  │                                      │                  │
  └────────────< reviews >───────────────┴──────────────────┘
```

## Planned entities

| Entity | Planned fields | Relationships |
| --- | --- | --- |
| `users` | id, first_name, last_name, email, password_hash, role, created_at | One user can place many orders and write many reviews. `role` is planned as `customer` or `admin`. |
| `categories` | id, name, description | One category can contain many kits. |
| `kits` | id, category_id, team_name, season, kit_type, name, description, size, price, stock_quantity, image_path | Each kit belongs to one category and can appear in many order items and reviews. |
| `orders` | id, user_id, status, total_amount, created_at | Each order belongs to one user and contains many order items. |
| `order_items` | id, order_id, kit_id, quantity, unit_price | Each order item belongs to one order and one kit. `unit_price` preserves the price at purchase time. |
| `reviews` | id, user_id, kit_id, rating, comment, created_at | Each review belongs to one user and one kit. |

## Relationship summary

- `categories.id` → `kits.category_id` is one-to-many.
- `users.id` → `orders.user_id` is one-to-many.
- `orders.id` → `order_items.order_id` is one-to-many.
- `kits.id` → `order_items.kit_id` is one-to-many.
- `users.id` → `reviews.user_id` and `kits.id` → `reviews.kit_id` are each one-to-many.

All entities are planned to have an integer `id` primary key. Foreign keys and suitable constraints will be finalized with the Milestone 2 schema.
