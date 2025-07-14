# Data Flow & State Management

## Overview
This section explains how data moves through the system, how user and application state is managed, and how persistence is handled in both backend and frontend.

---

## Authentication & User State

### Backend (Laravel)
- **API Authentication:**
  - Uses Laravel Sanctum for API token authentication.
  - On registration or login, a token is generated and returned to the client:
    ```php
    // Registration/Login
    $token = $user->createToken('auth_token')->plainTextToken;
    ```
  - All protected API routes require this token (sent as a Bearer token).
- **Session Authentication (Web):**
  - Uses Laravel's session driver (default: database) for web routes.
  - On login, session is regenerated for security:
    ```php
    $request->session()->regenerate();
    ```
  - On logout, session is invalidated and token is regenerated.

### Frontend (Vue + Inertia)
- **User State:**
  - User info and permissions are shared via Inertia props and stored in the frontend state.
  - Auth state is checked on each page load; if not authenticated, user is redirected to login.
- **Persistence:**
  - Auth token is stored in the browser (usually in localStorage or cookies, depending on setup).
  - Appearance/theme preferences are stored in localStorage.

---

## Data Flow Examples

### 1. User Registration/Login
- User submits registration/login form.
- Backend validates and creates user, then issues a token.
- Token is stored on the client and sent with each API request.
- User state is hydrated in the frontend via Inertia.

### 2. Authenticated API Request
- Client sends API request with Bearer token.
- Backend authenticates token and retrieves user.
- Controller processes request, updates database if needed, and returns response.
- Frontend updates state/UI based on response.

### 3. State Updates (e.g., Profile Update, Frame Purchase)
- User submits update (e.g., profile field, frame purchase).
- Backend validates and updates the database.
- Updated user data is returned and replaces old state in the frontend.

---

## State Persistence
- **Database:** All core data (users, frames, transactions, coin requests, etc.) is persisted in the database.
- **Sessions:** Web sessions are stored in the database (see `config/session.php`).
- **Tokens:** API tokens are managed by Sanctum and stored in the `personal_access_tokens` table.
- **Local Storage:** Frontend stores preferences (e.g., theme) and may store tokens for API auth.

---

## Diagram: Authentication & Data Flow

```mermaid
graph TD;
  A[User] -- Registers/Logs in --> B[Backend (Laravel)]
  B -- Issues Token --> C[Frontend (Vue/Inertia)]
  C -- Sends Token --> D[API Request]
  D -- Authenticates --> B
  C -- Receives Data --> E[UI/State Update]
  E -- User Actions --> D
```

---

## Summary
- **Authentication** is handled via Sanctum tokens (API) and sessions (web).
- **User state** is shared between backend and frontend using Inertia.
- **Data updates** are reflected in both backend (database) and frontend (state/UI).
- **Persistence** is managed via database, sessions, tokens, and local storage. 