# Phase 4: Rebuild Proposal — Modular, Future-Ready Architecture

## 1. Project Folder Structure (Recommended)

```
backend/
├── app/
│   ├── Actions/           # Business actions (CQRS, use cases)
│   ├── Console/
│   ├── DTOs/              # Data Transfer Objects
│   ├── Events/
│   ├── Exceptions/
│   ├── Helpers/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   ├── Policies/
│   ├── Providers/
│   ├── Repositories/      # Data access abstraction
│   ├── Rules/
│   └── Services/          # Business logic/services
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
└── ...
frontend/
├── src/
│   ├── api/
│   ├── components/
│   ├── composables/
│   ├── layouts/
│   ├── pages/
│   ├── stores/
│   ├── styles/
│   └── utils/
├── public/
├── tests/
├── vite.config.ts
├── tailwind.config.js
└── ...
```

---

## 2. Key Tech Decisions
- **Backend:** Laravel (Octane + Swoole), modularized with services, repositories, DTOs
- **Frontend:** Vue 3 + TypeScript + Inertia.js, modular components and stores
- **API:** RESTful, single version, strict request validation, standardized error responses
- **Auth:** Sanctum for API, session for web
- **Performance:** Eager loading, DB transactions, Octane tuning, rate limiting
- **Security:** Role-based access, audit logging, GDPR compliance, secure file uploads
- **CI/CD:** Linting, formatting, tests in CI (GitHub Actions)

---

## 3. Tools, Libraries, Patterns
- **Keep:**
  - Laravel Octane, Sanctum, Spatie Permission, Inertia, Ziggy, Tailwind, Vite
  - Prettier, ESLint, Pint, Pest (for tests)
- **Add:**
  - DTOs for API input/output
  - Repositories for complex data access
  - Action classes for business logic (CQRS pattern)
  - API rate limiting middleware
  - Audit logging package (e.g., spatie/laravel-activitylog)
  - Stripe/QuickBooks integration (when needed)
- **Remove/Avoid:**
  - Hardcoded IDs (use config/roles)
  - Large controller methods (move to services/actions)

---

## 4. Performance, Security, and DX Strategies
- **Performance:**
  - Use Octane/Swoole for concurrency
  - Eager load relationships in queries
  - Use DB transactions for multi-step updates
  - Add rate limiting to login, registration, uploads
- **Security:**
  - Enforce role-based access in middleware
  - Log all sensitive actions (audit log)
  - Validate all input strictly (custom requests/DTOs)
  - Ensure GDPR compliance (user data export/delete)
- **Developer Experience:**
  - Keep docs up to date (step-by-step onboarding, env vars, tools)
  - Use CI for lint, format, and tests
  - Modularize code for easier onboarding and testing

---

## 5. Step-by-Step Developer Onboarding Flow

1. **Clone the repository:**
   ```sh
   git clone <repo-url>
   cd backend
   ```
2. **Install dependencies:**
   ```sh
   composer install
   npm install
   ```
3. **Copy and configure environment:**
   ```sh
   cp .env.example .env
   # Edit .env and set required variables (see docs/config-and-build.md)
   php artisan key:generate
   ```
4. **Set up the database:**
   ```sh
   php artisan migrate
   ```
5. **Build frontend assets:**
   ```sh
   npm run dev
   # or for production: npm run build
   ```
6. **Start Octane server:**
   ```sh
   php artisan octane:start --server=swoole --host=127.0.0.1 --port=8000
   ```
7. **(Optional) Start background jobs:**
   ```sh
   php artisan queue:listen --tries=1
   ```
8. **Run tests and linting:**
   ```sh
   npm run lint
   npm run format
   ./vendor/bin/pest
   ```
9. **Explore documentation:**
   - Read docs in this order for best onboarding:
     1. `docs/config-and-build.md`
     2. `docs/third-party-integrations.md`
     3. `docs/data-flow-and-state.md`
     4. `docs/api-endpoints.md`
     5. `docs/modules-and-functions.md`
     6. `docs/codebase-analysis-and-rebuild.md`
     7. `docs/phase3-interactive-feedback.md`
     8. `docs/rebuild-proposal.md`

---

**This plan will help you scale, maintain, and evolve your codebase with confidence and clarity.** 