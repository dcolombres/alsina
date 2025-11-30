# CHANGELOG

## 1.0.0 - 2025-11-30

### Added

-   **User, Roles, and Permissions Management:**
    -   Implemented a robust role and permission system using `spatie/laravel-permission`.
    -   Integrated `spatie/laravel-permission` package, including publishing assets and running migrations.
    -   Extended the `User` model with the `HasRoles` trait for role assignment.
    -   Created a `RolesAndPermissionsSeeder` to define 'admin' and 'user' roles.
    -   Configured `DatabaseSeeder` to assign the 'admin' role to the default `admin@admin.com` user upon seeding.
    -   Restricted user registration routes (`/register`) to only be accessible by users with the 'admin' role.
    -   Registered `spatie/laravel-permission` middleware aliases (`role`, `permission`, `role_or_permission`) in `app/Http/Kernel.php`.
    -   **User Administration (ABM) Section:**
        -   Developed a `UserController` with full CRUD (Create, Read, Update, Delete) functionality for managing users.
        -   Defined resourceful routes for `/users`, protected by `auth` and `role:admin` middleware.
        -   Created Inertia.js (Vue) components for user listing (`resources/js/Pages/Users/Index.vue`), creation (`resources/js/Pages/Users/Create.vue`), and editing (`resources/js/Pages/Users/Edit.vue`).
        -   Modified `app/Http/Middleware/HandleInertiaRequests.php` to share authenticated user's roles with the frontend for conditional rendering.
        -   Added a conditional "Usuarios" link in `resources/js/Layouts/AuthenticatedLayout.vue` (for both desktop and mobile navigation) visible only to administrators.

### Fixed

-   Resolved `TypeError: Cannot read properties of undefined (reading 'success')` in `resources/js/Pages/Users/Index.vue`.
    -   Applied optional chaining (`?.`) to `page.props.flash.success` and `page.props.flash.error` to gracefully handle cases where flash messages are not present on initial page load.