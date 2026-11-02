# GrbZem

GrbZem is a responsive single-page storefront concept for Premier League home shirts. Milestone 2 adds a MySQL database and a PDO DAO layer to the static frontend.

The project is for IT 2001 Web Programming at International Burch University. The frontend remains a static prototype; it is not connected to the backend yet.

## Milestone 2 database

The schema is in `database/grbzem.sql`. It creates the `grbzem` database, six related tables, and sample rows:

- `users` can place many `orders` and write many `reviews`.
- `categories` can contain many `kits`.
- `orders` contain many `order_items`.
- Each `order_item` refers to one `kit` and stores its quantity and purchase price.
- Each `review` belongs to one `user` and one `kit`.

The database uses primary keys, foreign keys, unique values, and data constraints. `backend/dao/BaseDao.php` provides shared PDO CRUD methods. Each table has a DAO class in `backend/dao/`.

## Roles and test data

The planned roles are `customer` and `admin`. The SQL file includes sample rows for both roles; these rows are for database testing and are not login accounts. Authentication and usable test accounts are planned for a later milestone.

## Run locally

1. Start Apache and MySQL in the XAMPP Control Panel.
2. Import `database/grbzem.sql` with phpMyAdmin, or run `C:\xampp\mysql\bin\mysql.exe -u root < database\grbzem.sql` from the project folder.
3. Copy `backend/config/config.example.php` to `backend/config/config.php`. The example settings match a default local XAMPP MySQL installation. Change the local values if your database uses different credentials.
4. Open `http://localhost/WebProgrammingEman/frontend/` to view the static storefront.
5. Run `C:\xampp\php\php.exe backend\dao\test.php` from the project folder to test the DAO classes. The test uses a transaction and rolls back its changes.

The local `backend/config/config.php`, logs, and Composer `vendor` directory are excluded from Git. Keep real database credentials out of `config.example.php`.

## Matchday feature

The home page and Matchday view show where football fixtures or league information from an external API are planned. The API provider and backend connection will be selected and implemented in a later milestone.

## API documentation and deployment

OpenAPI/Swagger documentation, deployed application links, and working login test accounts will be added in later milestones.
