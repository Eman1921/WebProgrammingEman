# GrbZem

GrbZem is a responsive single-page storefront concept for Premier League home shirts. Milestone 3 adds a PHP REST API with business services, FlightPHP routes, OpenAPI documentation, and a Matchday weather feature powered by Open-Meteo.

## Database

Import `database/grbzem.sql` to create the MySQL database and six related tables:

- `users` can place many `orders` and write many `reviews`.
- `categories` can contain many `kits`.
- `orders` contain many `order_items`.
- Each `order_item` refers to one `kit` and stores its quantity and purchase price.
- Each `review` belongs to one `user` and one `kit`.

The schema uses primary and foreign keys, unique values, and data constraints. DAO classes are in `backend/dao/`; entity services in `backend/services/` validate input and apply relationship rules before calling DAOs.

## Run locally with XAMPP

1. Start Apache and MySQL in the XAMPP Control Panel.
2. Import `database/grbzem.sql` with phpMyAdmin, or run `C:\xampp\mysql\bin\mysql.exe -u root < database\grbzem.sql` from the project folder.
3. Copy `backend/config/config.example.php` to `backend/config/config.php`. The example settings use the default local XAMPP database. Keep `config.php` local.
4. In the `backend` folder, run `composer install` to install FlightPHP and swagger-php from `composer.lock`.
5. Open the storefront at `http://localhost/WebProgrammingEman/frontend/`.
6. Open the API at `http://localhost/WebProgrammingEman/backend/` and the interactive API documentation at `http://localhost/WebProgrammingEman/backend/public/v1/docs/`.

The API supports list, read-by-id, create, update, and delete routes for users, categories, kits, orders, order items, and reviews. Requests and responses use JSON. Successful creation returns 201; validation failures return 400; missing records or routes return 404; unexpected server errors return 500.

## Matchday weather

The Matchday view requests a city forecast from the GrbZem backend. The backend calls the Open-Meteo geocoding and forecast services with connection and total timeouts, checks the HTTP response and JSON data, and returns a friendly error if the service is unavailable. Open-Meteo does not require an API key. Its endpoint URLs and timeout are in the configuration class; no external key or secret is committed.

Try the endpoint with `http://localhost/WebProgrammingEman/backend/weather/forecast?city=Sarajevo&days=5`. The `city` parameter accepts 2–50 characters; `days` is optional and accepts 1–16.

## Roles and test data

The planned roles are `customer` and `admin`. The SQL file includes sample users, but they are database records rather than login accounts. Authentication and role-based access are scheduled for Milestone 4.

The Matchday weather feature is connected to the backend. Connecting entity management throughout the storefront is planned for Milestone 4. Deployment and a live link are planned for Milestone 5.
