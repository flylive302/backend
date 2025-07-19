# Third-Party Integrations

This section documents the key third-party libraries and services integrated into the codebase, their roles, and where they are used.

---

## Backend Integrations (PHP/Laravel)

### **Inertia.js (inertiajs/inertia-laravel)**
- **Role:** Bridges Laravel backend with Vue frontend for single-page app experience.
- **Usage:**
  - Controllers return Inertia responses (e.g., `Inertia::render(...)`).
  - Shared props and user state are passed via Inertia middleware.
  - Configured in `config/inertia.php`.

### **Sanctum (laravel/sanctum)**
- **Role:** API token authentication for SPA/mobile clients.
- **Usage:**
  - Protects API routes with `auth:sanctum` middleware.
  - Issues and validates tokens for users.
  - Configured in `config/sanctum.php`.

### **Spatie Laravel Permission (spatie/laravel-permission)**
- **Role:** Role and permission management for users.
- **Usage:**
  - User model uses `HasRoles` trait.
  - Permissions checked in controllers and middleware.

### **ImageKit (imagekit/imagekit)**
- **Role:** Media storage and CDN for user-uploaded files.
- **Usage:**
  - `ImageKitService` handles signature generation and file verification.
  - Configured in `config/services.php`.

### **Tighten Ziggy (tightenco/ziggy)**
- **Role:** Exposes Laravel routes to JavaScript for frontend routing.
- **Usage:**
  - Generates route definitions for use in Vue via ZiggyJS.
  - Published via `php artisan ziggy:generate`.

---

## Frontend Integrations (Vue/JS)

### **Vue 3**
- **Role:** Main frontend framework.
- **Usage:**
  - All UI components and pages are built with Vue 3.

### **Inertia.js (@inertiajs/vue3)**
- **Role:** SPA routing and state management.
- **Usage:**
  - Handles page navigation, props, and server-driven state.

### **Ziggy (ziggy-js)**
- **Role:** Accesses Laravel routes in JavaScript.
- **Usage:**
  - Used in `resources/js/app.ts` and throughout Vue components for route generation.

### **Tailwind CSS (tailwindcss, tailwindcss-animate, prettier-plugin-tailwindcss)**
- **Role:** Utility-first CSS framework for styling.
- **Usage:**
  - All styles and layouts use Tailwind classes.
  - Configured in `tailwind.config.js`.

### **ImageKit (imagekitio-vue)**
- **Role:** Vue components for displaying and uploading images via ImageKit.
- **Usage:**
  - Used in components like `Avatar.vue`, `UserInfo.vue`, and frame-related pages.

### **Vite**
- **Role:** Frontend build tool and dev server.
- **Usage:**
  - Handles hot module reloading, TypeScript, and asset bundling.
  - Configured in `vite.config.ts`.

### **Other Notable Packages**
- **@headlessui/vue:** Accessible UI primitives.
- **lucide-vue-next:** Icon library.
- **@vueuse/core:** Vue composition utilities.
- **radix-vue:** UI components.
- **svga:** Animation support.
- **prettier, eslint:** Code formatting and linting.

---

## Configuration References
- **Backend:**
  - `config/services.php` (third-party credentials)
  - `config/inertia.php`, `config/sanctum.php`, `config/session.php`
- **Frontend:**
  - `vite.config.ts`, `tailwind.config.js`, `tsconfig.json`, `.prettierrc`, `.eslintrc.js`

---

## Summary Table

| Integration         | Backend | Frontend | Purpose/Role                        |
|---------------------|---------|----------|-------------------------------------|
| Inertia.js          |   ✓     |    ✓     | SPA routing, state, SSR             |
| Sanctum             |   ✓     |          | API authentication                  |
| Spatie Permission   |   ✓     |          | Roles/permissions                   |
| ImageKit            |   ✓     |    ✓     | Media storage, CDN, image display   |
| Ziggy               |   ✓     |    ✓     | Route generation (JS)               |
| Tailwind CSS        |         |    ✓     | Styling                             |
| Vite                |         |    ✓     | Build tool                          |
| Headless UI, Lucide |         |    ✓     | UI components/icons                  |

---

For more details, see the respective config files and package manifests. 