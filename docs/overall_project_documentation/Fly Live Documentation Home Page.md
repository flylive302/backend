# Fly Live Documentation: Home Page

---

## **1. Purpose**

- The primary landing page for authenticated users, dynamically displaying rooms, events, and personalized content.
- Provides navigation to core app features such as **My Room**, **Explore**, and **Follow**.
- Personalizes content based on user geolocation or manually selected country.

---

## **2. UI/UX Design**

### **Key Components**

1. **Top Navigation Bar**:
    - Includes:
        - **Logo**: Redirects to the Home Page.
        - **Search Icon**: Links to the Search Page.
        - **Rankings Icon**: Links to the Rank Page.
2. **Category Tabs**:
    - Tabs for:
        - **My Room**: Redirects to the user’s personal room.
        - **Explore**: Links to the Explore Page.
        - **Follow**: Links to the Follow Page.
3. **Featured Banner**:
    - Horizontally scrolling banner showcasing active and upcoming events.
    - Includes **call-to-action buttons** like "Join Now" or "Learn More."
4. **Top 10 Rooms Section**:
    - Horizontally scrolling cards displaying the **Top 10 Rooms**.
    - Each card includes:
        - Room thumbnail.
        - Tags (e.g., "Live," "24 Hr").
        - Active user count.
5. **Content Grid**:
    - Infinite scroll grid displaying rooms starting from #11 onward.
    - Each card includes:
        - Room thumbnail.
        - Tags (e.g., "Live").
        - Active user count.
6. **Bottom Navigation Bar**:
    - Icons for:
        - **Home**: Links to the Home Page.
        - **Discover**: Links to the Discover Page.
        - **Cube**: Links to the user’s personal room.
        - **Bell**: Links to System Alerts.
        - **Profile**: Links to the Profile Page with customizable avatar frames.

---

## **3. Functional Requirements**

### **Dynamic Content**

1. **Featured Banner**:
    - Fetch active events using the API.
    - Filter by:
        - Event time (active/upcoming).
        - Geolocation or fallback to global content.
    - Automatically remove expired events.
2. **Top 10 Rooms Section**:
    - Dynamically updated using **Socket.IO** for real-time room changes.
    - API fallback for periodic updates every 30 seconds.
3. **Content Grid**:
    - Implements infinite scrolling:
        - Fetches rooms in batches (e.g., 10 per page).
        - Loads additional data as users scroll down.
4. **Geolocation and Country Selection**:
    - Detect user location via **ipstack**.
    - Allow manual country selection with fallback to global content.
5. **Avatar Frames**:
    - Displays static or animated frames over user avatars.
    - Caches frames locally for performance optimization.

---

## **4. Performance Optimizations**

### **Frontend**

- Use **Server-Side Rendering (SSR)** for faster page load times.
- Lazy load images and non-critical content to reduce initial load time.
- Optimize CSS with critical path extraction and inline rendering.
- Serve static assets (CSS, JS, images) via a CDN.

### **Backend**

- Cache frequently accessed data (e.g., Top 10 Rooms, events) in **Redis**.
- Optimize database queries with indexing and eager loading for faster data retrieval.
- Paginate room data for infinite scrolling.

### **Infrastructure**

- Use a **DigitalOcean Load Balancer** with path-based routing for traffic distribution.
- Enable sticky sessions for real-time features (e.g., **Socket.IO**).
- Leverage Redis for **Pub/Sub** and caching.
- Serve dynamic and static content through a global CDN.

---

## **5. Reusable Components**

### **Navigation Components**

1. **TopNavigationBar.vue**:
    - Contains the logo, search, and rankings icons.
    - Reused across pages with a consistent top navigation structure.
2. **BottomNavigationBar.vue**:
    - Contains icons for Home, Discover, Cube, Bell, and Profile.
    - Highlights the active tab via props.

### **Section Components**

1. **CategoryTabs.vue**:
    - Displays the "My Room," "Explore," and "Follow" tabs.
    - Accepts tab data via props and emits events on click.
2. **FeaturedBanner.vue**:
    - Horizontally scrolls event banners.
    - Accepts event data via props and supports buttons like "Join Now."
3. **TopRoomsScroller.vue**:
    - Horizontally scrolling section for the Top 10 Rooms.
    - Accepts room data via props and supports real-time updates.
4. **RoomGrid.vue**:
    - Implements infinite scrolling for room data beyond the Top 10.
    - Fetches paginated data from the API.

### **Shared Components**

1. **RoomCard.vue**:
    - Reused in **TopRoomsScroller.vue** and **RoomGrid.vue**.
    - Displays:
        - Room thumbnail.
        - Active user count.
        - Room tags (e.g., "Live").
2. **AvatarWithFrame.vue**:
    - Displays user avatars with optional animated or static frames.
    - Props:
        - `avatarUrl`: User’s avatar URL.
        - `frameUrl`: Frame URL.
        - `isAnimated`: Boolean for animated frames.
3. **EmptyState.vue**:
    - Fallback for no active rooms or events.

### **Utility Components**

1. **InfiniteScrollLoader.vue**:
    - Handles infinite scrolling for **RoomGrid.vue**.
    - Triggers events to fetch more data.
2. **RefreshTimer.vue**:
    - Manages periodic refreshes for dynamic sections like the Top 10 Rooms.

---

## **6. Testing Criteria**

1. **Functional Testing**:
    - Verify real-time updates for the Top 10 Rooms using **Socket.IO**.
    - Ensure smooth infinite scroll functionality.
    - Validate API responses for events and rooms.
2. **UI/UX Testing**:
    - Confirm alignment and responsiveness of avatar frames and banners.
    - Test layout responsiveness across devices.
3. **Performance Testing**:
    - Measure API response times and page load times.
    - Optimize asset delivery using CDNs and caching.
4. **Edge Case Testing**:
    - Handle geolocation denial gracefully.
    - Display appropriate fallback content when no rooms or events are available.