# GrbZem

GrbZem is a responsive single-page storefront concept for browsing Premier League home shirts, planning an order, and managing a customer account. This Milestone 1 version is a static frontend prototype; it does not connect to a backend or database yet.

The storefront name is **GrbZem**. The visual theme uses navy, ivory, and pitch green. The project is being developed for IT 2001 Web Programming at International Burch University by Eman Husejnovic.

## Milestone 1 scope

- Responsive static SPA with home, shop, kit details, cart, checkout, matchday, login, registration, account, and admin views. The shop preview lists home shirts for the 20 clubs in 2026/27 and the three clubs relegated after 2025/26.
- Draft ERD for the planned relational database.
- Planned public data feature: a matchday section on the home page and a dedicated Matchday view for football fixtures or league information from a relevant external API. The provider will be selected before that milestone is implemented.

## Planned entities and relationships

- `users` have a `customer` or `admin` role and may place many orders and write many reviews.
- `categories` contain many `kits`.
- `users` place many `orders`; each order contains one or more `order_items`.
- Each `order_item` refers to one kit and stores the quantity and price at the time of ordering.
- `reviews` connect a user to a kit and contain a rating and comment.

See [docs/ERD.md](docs/ERD.md) for the draft diagram and planned fields.

## Roles and test accounts

Planned roles are `customer` and `admin`. Test accounts will be documented after authentication is implemented. This static prototype has no real accounts or passwords.

## Run locally

1. Place the project folder under XAMPP `htdocs`.
2. Start Apache in the XAMPP Control Panel.
3. Open `http://localhost/WebProgrammingEman/frontend/` in a browser.

Milestone 1 does not require a database import or backend configuration file. Later milestones will add a MySQL `.sql` file with sample data and a local `backend/config/config.php`, copied from `backend/config/config.example.php`. The real configuration file, logs, and Composer `vendor` directory must stay out of Git.

## API documentation

OpenAPI and Swagger documentation will be added with the API in a later milestone.

## Deployed application

Deployment is planned for a later milestone. The live application link will be added here after deployment.
