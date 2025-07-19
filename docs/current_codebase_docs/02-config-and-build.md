# Config, Setup & Build Process

This section explains how the project is configured, built, and run, including key tools and configuration files.

---

## Project Structure Overview
- **Backend:** Laravel (PHP, running with Octane + Swoole)
- **Frontend:** Vue 3 (TypeScript) with Inertia.js
- **Build Tool:** Vite
- **Styling:** Tailwind CSS
- **SSR:** Inertia SSR (optional)

---

## Key Configuration Files
- `vite.config.ts`: Vite build and dev server config (frontend entry, plugins, SSR)
- `tsconfig.json`: TypeScript configuration (paths, types, strictness)
- `tailwind.config.js`: Tailwind CSS config (theme, plugins)
- `package.json`: Frontend dependencies and scripts
- `composer.json`: Backend dependencies and scripts
- `config/inertia.php`: Inertia SSR and testing config
- `config/services.php`: Third-party service credentials
- `config/session.php`, `config/sanctum.php`: Session and API auth config
- `config/octane.php`: Octane/Swoole server config

---

## Setup & Build Steps

### 1. **Install Dependencies**
- **Backend:**
  ```sh
  composer install
  ```
- **Frontend:**
  ```sh
  npm install
  ```

### 2. **Environment Setup**
- Copy `.env.example` to `.env` and set environment variables (see below for required variables and sample values)
- Generate Laravel app key:
  ```sh
  php artisan key:generate
  ```

### 3. **Database Setup**
- Run migrations:
  ```sh
  php artisan migrate
  ```

### 4. **Build Frontend Assets**
- For development (with hot reload):
  ```sh
  npm run dev
  ```
- For production build:
  ```sh
  npm run build
  ```

### 5. **Run the Application (Octane + Swoole)**
- Start the Octane server with Swoole:
  ```sh
  php artisan octane:start --server=swoole --host=127.0.0.1 --port=8000
  ```
- (Optional) Start queue and logs for background jobs:
  ```sh
  php artisan queue:listen --tries=1
  php artisan pail --timeout=0
  ```
- (Optional) Run all together (see `composer.json` dev script):
  ```sh
  npx concurrently ...
  ```

---

## Required .env Variables (with Sample Values)

```env
# Application
APP_NAME=FlyLive
APP_ENV=local
APP_KEY=base64:YOUR_GENERATED_KEY
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flylive
DB_USERNAME=root
DB_PASSWORD=secret

# Cache & Queue
CACHE_STORE=database
QUEUE_CONNECTION=database
SESSION_DRIVER=database

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1

# Octane
OCTANE_SERVER=swoole
OCTANE_HTTPS=false

# ImageKit
IMAGEKIT_PUBLIC_KEY=your_public_key
IMAGEKIT_PRIVATE_KEY=your_private_key
IMAGEKIT_URL_ENDPOINT=https://ik.imagekit.io/your_imagekit_id

# Mail (example for log driver)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="FlyLive"

# Other third-party services (optional)
POSTMARK_TOKEN=your_postmark_token
AWS_ACCESS_KEY_ID=your_aws_key
AWS_SECRET_ACCESS_KEY=your_aws_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket

# Any other required service keys...
```

---

## SSR (Server-Side Rendering)
- Inertia SSR can be enabled via `config/inertia.php`.
- Requires a Node SSR server (see Inertia docs for setup).
- SSR bundle path: `bootstrap/ssr/app.js`

---

## Linting & Formatting
- **Lint JS/TS:**
  ```sh
  npm run lint
  ```
- **Format code:**
  ```sh
  npm run format
  ```

---

## Example: Vite Config (`vite.config.ts`)
```ts
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': resolve(__dirname, 'resources/js'),
    },
  },
  // ...other options
});
```

---

## Example: Tailwind Config (`tailwind.config.js`)
```js
module.exports = {
  content: [
    './resources/**/*.vue',
    './resources/**/*.js',
    // ...
  ],
  theme: {
    extend: {},
  },
  plugins: [require('tailwindcss-animate')],
};
```

---

## Summary
- **Backend:** Laravel (Octane + Swoole), configured via `.env` and `config/` files
- **Frontend:** Vue 3 + Vite + Tailwind, configured via `vite.config.ts`, `tailwind.config.js`, `tsconfig.json`
- **Build:** Use npm scripts for dev/prod, composer for backend
- **SSR:** Optional, via Inertia SSR
- **Lint/Format:** Prettier and ESLint for code quality 