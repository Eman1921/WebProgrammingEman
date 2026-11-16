# AGENTS.md

## Project

GrbZem is a responsive single-page storefront concept for Premier League home shirts. The current milestone provides a PHP REST API, six entity services and DAOs, OpenAPI documentation, and an Open-Meteo weather endpoint used by the Matchday view. Planned roles are customer and admin. Entities are users, categories, kits, orders, order items, and reviews.

## Technology stack

- Frontend: HTML, CSS, JavaScript, Bootstrap 5, and single-page navigation.
- Backend: PHP, FlightPHP 3, and PDO for MySQL access.
- API documentation: swagger-php 6 and Swagger UI.
- Local environment: XAMPP.
- Database: MySQL or the MariaDB server included with XAMPP.
- External API: Open-Meteo geocoding and forecast services; they do not require an API key.

## Folder structure

- `frontend/index.html`: the SPA entry page.
- `frontend/css/`: shared and view-specific stylesheets.
- `frontend/js/`: SPA navigation and frontend behavior.
- `frontend/views/`: one HTML view per page.
- `frontend/assets/`: static images and other assets.
- `backend/index.php`: FlightPHP entry point and shared JSON error handlers.
- `backend/routes/`: FlightPHP route handlers.
- `backend/services/`: application rules, validation, and external API calls.
- `backend/dao/`: database access classes.
- `backend/middleware/`: later milestone authentication, authorization, request logging, and error middleware.
- `backend/config/`: configuration template and local configuration.
- `backend/logs/`: local logs; log files are excluded from Git.
- `backend/public/v1/docs/`: OpenAPI generation and Swagger UI.
- `database/grbzem.sql`: database schema and sample data.
- `docs/`: ERD, AI usage log, and project documentation.

## Architecture rules

- Keep frontend files separate from backend PHP files.
- Keep the frontend as a single-page app; navigation between views must not reload the page.
- Backend requests follow routes to services to DAOs to the database. Results return through the same layers.
- Routes handle HTTP input, JSON output, and status codes. They do not access the database directly.
- Services contain business rules and validation. They are the only layer that calls DAOs.
- DAOs contain SQL and use PDO prepared statements for values.
- Store database credentials and any future API secrets in local `backend/config/config.php`; update `config.example.php` when configuration fields change.
- Open-Meteo does not require an API key. Keep its base URLs and request timeout in the configuration class.
- Do not add libraries or frameworks beyond the project requirements and the course materials without asking first.
- Do not implement authentication, authorization middleware, request logging, or full entity management in the frontend until Milestone 4 is requested.
- Do not implement later-milestone work until asked.
- Do not run Git or GitHub operations. Eman manages branches, commits, pushes, pull requests, reviewers, and merges.

## Naming conventions

- PHP classes use PascalCase and class-named files, such as `KitService.php` and `KitDao.php`.
- JavaScript and PHP variables use camelCase.
- Database tables and columns use snake_case.
- Use singular entity class names and plural table names.

## Source code rules

- Keep source code free of comments and AI references.
- Keep each change within the requested milestone.
- Use only concepts and techniques from the course materials supplied for the current milestone.
- Make sure the project owner can understand and explain every part of the code.
- Keep `docs/AI_LOG.md` accurate about tools, prompts, tasks, outcomes, and mistakes that were actually observed.
