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
