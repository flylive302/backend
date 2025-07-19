# Fly Live Documentation: Main Page

### **Introduction**

Fly Live is a scalable and interactive social platform enabling real-time audio communication, gifting, and community engagement. Core features include:

- Dynamic rooms
- Real-time messaging
- Wallet system
- User profiles
- Leaderboards
- Agency system (akin to clans/teams)
- Moderation tools

### **Purpose**

This document outlines Fly Live’s features and functional requirements to ensure clarity, alignment, and readiness for development.

---

### **Final Tech Stack**

### **Backend**

- **Laravel**: Version 11.0 (Server 1)
    - PHP: Version 8.4
    - Composer: v2.8.4
    - Octane: v2.6.0 (with Swoole)
    - JetStream API Mode: v5.3.4
    - Socialite: v5.16.1
    - PhpRedis: Latest version
    - Horizon: v5.30.1
    - Telescope: Latest version
- **Mediasoup**: v3 (Server 2)
- **Socket.IO**: Version 4 (Server 3)

### **Database**

- **MySQL**: Version 8.0 (Server 4)
- **Redis**: Version 7.4 (Server 5)

### **Frontend**

- **Nuxt 3** (Server 6)
    - Modules:
        - @pinia/nuxt
        - @nuxt/image
        - @nuxt/fonts
        - @nuxt/icon
        - @vite-pwa/nuxt
        - vueuse
        - shadcn-nuxt
        - Tailwind CSS
        - mediasoup-client
        - socket.io-client

### **Infrastructure**

- **DigitalOcean Cloud**
    - Docker (Containerization)
    - Kubernetes (Orchestration)
    - DigitalOcean Spaces (File Storage)
    - Nginx (Load Balancer)
    - Cloudflare (Edge Caching & DDoS Protection)

### **CI/CD**

- GitHub Actions (Automated Pipelines)

### **Monitoring & Logging**

- Prometheus & Grafana (Monitoring)
- Sentry (Error Tracking)

---

### **Fly Live Coin System**

### **1. Admin Wallet (Bank)**

- **Purpose**: Acts as a central repository for app coins.
- **Initial Capital**: Starts with 1 billion coins (or as required).
- **Functions**:
    - Distributes coins to resellers and via in-app purchases.
    - Collects spent coins from user activities (gifting, purchases).
    - Processes user coin redemption requests.

### **2. Coin Distribution Channels**

1. **In-App Purchases**:
    - Direct purchase by users using traditional digital methods.
    - Coins are deducted from the admin wallet.
2. **Authorized Resellers**:
    - Serve users unable to make in-app purchases (e.g., due to regional restrictions).
    - Buy coins in bulk from the admin wallet and resell at a markup.
    - Manage user redemption processes.

### **3. User Transactions**

- **Earning Coins**:
    - Participating in events, rewards, and promotions.
- **Spending Coins**:
    - **Gifting**: To room hosts or participants.
    - **Leaderboards**: Boost ranking through spending.
    - **Mall Purchases**: For items like avatar frames, room themes, or unique IDs.
- **Redemption**:
    - Users redeem coins for real dollars via authorized resellers.

### **4. Revenue Model**

- **Admin Revenue**:
    - Coin sales (via in-app purchases and reseller purchases).
- **Reseller Revenue**:
    - Profit margin between coins purchased and resold.
- **Agency Revenue**:
    - Commissions on host earnings.
- **Host Revenue**:
    - Dollar earnings based on performance.

### **5. Fraud Prevention**

- Use transaction IDs for coin-related activities.
- Maintain a ledger system to track coin flow.
- Conduct regular audits of reseller transactions.

### **6. Transparency Tools**

- **Reseller Dashboard**:
    - Manage coin inventory and track transactions.
- **Host Dashboard**:
    - Track earnings and performance.
- **Agency Dashboard**:
    - Aggregate earnings and commissions for hosts under the agency.

### **7. Key Features for Scaling**

- **Global Coin Balance**:
    - Unified balance across all rooms and activities.
- **Direct & Indirect Channels**:
    - **In-App Purchases**: Direct and instant distribution.
    - **Resellers**: Regional scalability.

---

# **Fly Live Documentation: User Pages Overview**

### **High-Level Overview**

This section outlines the key user-facing pages and their sub-pages or tabs. The admin pages are yet to be decided.

---

### **1. Authentication Pages**

1. **Login Page**:
    - Default landing page for unauthenticated users.
    - Links:
        - Register Page
        - Forgot Password Page
2. **Register Page**:
    - Allows new users to create an account.
    - Links:
        - Login Page
        - Forgot Password Page
3. **Forgot Password Page**:
    - Assists users in recovering their accounts.
    - Links:
        - Login Page

---

### **2. Core User Pages**

1. **Home Page**:
    - Default landing page for authenticated users.
    - Data is customized based on the user's selected country.
    - Links:
        - Home, Search, Rank, Explore, Follow, Discover
        - System Alerts, Personal Profile, Active Event
        - Available Rooms, Personal Room
2. **Create Room Page**:
    - Guides users visiting rooms for the first time.
3. **Room Page**:
    - Central feature of the app.
    - Sub-Pages:
        - Level Rewards, Coins Activity
        - Active Users List, Theme, Settings
        - Blocked Users List
4. **Personal Profile Page**:
    - Displays user-specific data.
    - Links:
        - Public Profile Page
5. **Profile Settings Page**:
    - Tabbed Structure:
        - Recharge Page (Billing History)
        - Exchange Page (Exchange History)
6. **Mall Page**:
    - Tabs:
        - Props (Frames, Entry, Chat Bubble, Unique IDs, Room Themes)
        - My Props (Similar breakdown as above)
7. **Level Page**:
    - Wealth and Charm levels.
8. **VIP Page**:
    - Tabs for VIP levels: VIP 1 to VIP 6, FLSVIP.
9. **Badge Page**:
    - Achievement and Activity badges.
    - Personal and Room Badges.
10. **Agency Pages**:
    - All Agencies, Create New Agency, My Agency
    - Members Management, New Member Requests
    - Members Income, Invite, Active Days
    - Data Query, Salary Exchange Requests
    - Leave Requests
11. **My Income Page**:
    - Summarized income-related data.
12. **Feedback Page**:
    - Allows users to submit feedback.
13. **Account Settings Page**:
    - Includes account authentication, blacklist, and about us links.
14. **Public Profile Page**:
    - Public-facing user profiles.

---

### **3. Discovery and Engagement Pages**

1. **Explore Page**:
    - Interactive home page variation with country-based data.
2. **Follow Page**:
    - Tabs:
        - Fans, Followed, Followed Rooms
3. **Discover Page**:
    - List of all active app events.
4. **System Alerts Page**:
    - Notifications, alerts, and app messages.
5. **Rank Page**:
    - Ranks for users, rooms, and agencies.
    - Tabs:
        - Wealth, Charm, Room, Agency, Game
        - Game-specific ranks: Teen Patti, Fruit Loop
        - Timeframes: Daily, Weekly, Monthly
6. **Search Page**:
    - Allows users to search for others or rooms.

---

### **4. Page Statistics**

- **Main Pages**: 14
- **Sub-Pages and Tabs**: 97
- **Grand Total**: 111 Unique Pages (subject to growth).