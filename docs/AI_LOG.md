# AI Log

## Milestone 1

### Tools and tasks

- I contributed approximately 30% by defining the project requirements, writing some of the code myself, creating the first database schema draft, choosing the clubs and branding, and reviewing the work.
- ChatGPT contributed approximately 50% by helping organize the course materials, create the initial SPA structure and views, draft the ERD and README, and test the result locally. Main prompt: “Start doing it,” after I specified the local project path, ass1 branch, Milestone 1 scope, XAMPP testing, no GitHub operations, no source-code comments or AI references, and use of the supplied course files.
- OpenAI Codex desktop assistant contributed approximately 20% by updating the catalogue from nine to 23 clubs, adding detail routes for the additional teams, replacing the Nottingham Forest image with a shirt-only product photo on a white background, changing Sunderland to a front view, and replacing West Ham with a shirt image on a white background. It also checked the updated pages and image requests locally.
- These percentages are estimates. I reviewed the work and am responsible for understanding and explaining the final project.

### Where the AI was wrong

1. The initial structure placed CSS and JavaScript below `frontend/assets/`, following one course diagram. The Milestone 1 folder list calls for `frontend/css/` and `frontend/js/` directly. I noticed the mismatch while checking the required folders, moved the files to the direct folders, and updated the stylesheet and script paths in `index.html`.
2. The first cart page had a checkout control without a destination view. I noticed this while tracing the customer path through the SPA. I changed it to a view link, added `frontend/views/checkout.html`, and added `checkout` to the SPA routes.
3. The first static account and checkout forms used required fields and email input types. A milestone-scope review showed those browser checks belong to the later frontend-validation milestone. I removed the required attributes and changed those email fields to plain text inputs, keeping the forms as static layout previews.



## Milestone 2

### Tools and tasks

- I completed approximately 50% of the work. I reviewed the Milestone 2 requirements and course materials, finalized the six-table schema and relationships, decided which sample data to include, and reviewed and tested the finished project locally with XAMPP.
- ChatGPT assisted with approximately 50% of the work by drafting the SQL schema and sample data, implementing the PDO BaseDao and six DAO classes, setting up the configuration files and DAO test script, and updating the README and project instructions. Main prompt: “Using only uploaded material, help me complete Milestone 2 for GrbZem. Create the MySQL schema with sample data and a PDO BaseDao and DAO class for each table. Follow the course examples, keep the work local on `ass2`, and help me test it with XAMPP.”
- These percentages are estimates. I reviewed the changes and can explain the final code.

### Where the AI was wrong

1. ChatGPT’s first DAO test script claimed to test delete operations, but it did not actually call each DAO’s delete method. I noticed the mismatch while reviewing the script and added delete checks for all six DAOs. The corrected test passed.
2. ChatGPT initially treated the lab example’s `backend/rest/dao/` path as mandatory. I noticed the project structure uses `backend/dao/` and corrected the file placement before testing.

## Milestone 3

### Tools and tasks

- I set the scope to Milestone 3, required the work to use only the files in `C:\Users\saraj\Desktop\Assignment 3`, and requested local testing with XAMPP on `ass3`.
- OpenAI Codex desktop assistant read the supplied Milestone 3 requirements and course files, he helped me to add validation services and CRUD routes for the six database entities, added shared JSON error handling, documented the API with OpenAPI attributes and Swagger UI, and connected the Matchday weather panel to an Open-Meteo endpoint. It installed the course dependencies and exercised the API through XAMPP.
- Half of the things for this milestone was done by me and half with OpenAI Codex

### Where the assistant was wrong

1. The first Composer install failed because the XAMPP command-line PHP had its ZIP extension disabled. I noticed Composer’s error, enabled the ZIP extension for that install command, and reran it successfully.
2. The first user update validation compared the submitted email with existing users without excluding the user being updated. I noticed that an unchanged email would be rejected, changed the validation to ignore the current user id, and verified that a user update with the same email succeeds.
3. The first weather form handler looked for its status message inside the form, while the page markup places the message next to the form. I noticed the mismatch while reviewing the page and script, then changed the handler to find the message in the surrounding panel.
