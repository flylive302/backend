# Phase 3: Interactive Feedback (User Answers)

## 1. Core Business Logic
- **Most important:** User onboarding (registration, login, profile setup)
- **Critical flows:** Coin purchase (must be highly secure and reliable), frame activation
- **Note:** Many more features to come as the project evolves

## 2. Performance Goals
- **Peak load:** Up to 60,000 concurrent users per second
- **Regular load:** ~5,000 concurrent users

## 3. Domain-Specific Logic
- **Role-based access:** Only users with administrative roles (admin, reseller, manager) can access the backend dashboard; all others interact only with the client

## 4. Scaling & Modularity
- **Planned features:**
  - Group/team interactions in rooms
  - Agency system (users rewarded based on coins earned via gifts)
  - Ranking system
  - Many more features as the project is under active development

## 5. API Evolution
- **No need for multiple API versions or backward compatibility**; all clients (web, mobile) will update with the codebase

## 6. Integrations
- **Planned:** Payment gateway (e.g., Stripe, QuickBooks) in the future, but not a major concern right now

## 7. Security & Compliance
- **Requirements:**
  - GDPR compliance
  - Audit logging
  - Rate limiting

## 8. Developer Experience
- **Pain points:**
  - Developers struggle with onboarding and understanding setup
  - Need clear, step-by-step environment setup instructions (env vars, install, etc.)
  - Need documentation on tools, third-party integrations, data flow, API endpoints, modules, and functions
  - Prefer a reproducible, reliable onboarding process that works every time

---

**These answers will directly inform the rebuild proposal and documentation improvements.** 