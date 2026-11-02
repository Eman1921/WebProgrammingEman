# AGENTS.md

## Project

GrbZem is a responsive single-page storefront concept for browsing Premier League home shirts and planning customer orders. The current milestone adds a MySQL database and PDO DAO layer to the static frontend. Planned roles are customer and admin. The database has users, categories, kits, orders, order items, and reviews.

## Technology stack

- Frontend: HTML, CSS, JavaScript, Bootstrap 5, and a single-page navigation flow.
- Backend: PHP with FlightPHP for the REST API, PDO for MySQL access.
- Local environment: XAMPP.
- Database: MySQL or the MariaDB server included with XAMPP.

## Folder structure

- `frontend/index.html`: the SPA entry page.
- `frontend/css/`: shared and view-specific stylesheets.
- `frontend/js/`: SPA navigation and later frontend behavior.
- `frontend/views/`: one HTML view per page.
- `frontend/assets/`: static images and other assets.
- `backend/routes/`: FlightPHP route handlers.
- `backend/services/`: application rules and validation.
- `backend/dao/`: database access classes.
- `backend/middleware/`: reusable request, authentication, authorization, and error middleware.
- `backend/config/`: configuration template and local secret configuration.
- `backend/logs/`: local logs; log files are excluded from Git.
- `database/grbzem.sql`: database schema and sample data.
- `docs/`: ERD, AI usage log, and project documentation.

## Architecture rules

- Keep frontend files separate from backend PHP files.
- Keep the frontend as a single-page app; navigation between views must not reload the page.
- During Milestones 1 and 2, frontend views remain static and are not connected to the backend.
- DAOs use PDO and prepared statements. Shared CRUD methods belong in `backend/dao/BaseDao.php`; each table has one DAO class in `backend/dao/`.
- Database credentials are read from `backend/config/config.php`; keep this local file out of Git and maintain `config.example.php` as the settings template.
- Backend requests follow routes to services to DAOs to the database. Results return through the same layers.
- Routes handle HTTP input, JSON output, and status codes. They do not access the database directly.
- Services contain business rules and validation. They are the only layer that calls DAOs.
- DAOs contain SQL and use PDO prepared statements for values.
- Do not put database credentials, JWT secrets, or API keys in committed files. Update the example configuration when configuration fields change.
- Do not add libraries or frameworks beyond the project requirements and the course materials without asking me first.
- Do not run Git or GitHub operations. I manage branches, commits, pushes, pull requests, reviewers, and merges.

## Naming conventions

- PHP classes use PascalCase and class-named files, such as `KitService.php` and `KitDao.php`.
- JavaScript and PHP variables use camelCase.
- Database tables and columns use snake_case.
- Use singular entity class names and plural table names.

## Source code rules

- I make the project decisions and review the code.
- Use ChatGPT for implementation help when I ask.
- Keep each change within the requested milestone.
- Use only concepts and techniques from the course materials.
- Make sure I can understand and explain every part of the code.
- Do not implement services, API routes, or later-milestone features until I ask.
