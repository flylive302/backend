# Fly Live Documentation: Room’s Sub Pages:

---

# **Room’s Sub Page: Room Level Reward Page**

## **1. Purpose**

- Enables room admins to view and claim rewards based on the room’s total coin spending.
- Encourages room activity and engagement by rewarding admins for achieving higher room levels.
- Rewards are categorized by levels, with specific coin thresholds and prizes.

---

## **2. Navigation**

### **Access Points**

- **Info Icon**: Accessible from the Room Page’s **Level Section**.
- Visible only to the room admin.

---

## **3. UI/UX Design**

### **3.1 Key Components**

1. **Reward Table**:
    - **Columns**:
        - **Level (LVL)**: Room levels (e.g., 1, 2, 3...).
        - **Required Coins**: Cumulative coins needed for each level (e.g., "0 > 500K").
        - **Reward**: Prize for each level (e.g., "SVIP 1 - 7D + 2K Coins").
        - **Action**:
            - Displays a **Get Button** for eligible rewards.
            - Shows **Claimed** for rewards already collected.
2. **Info Section**:
    - Brief explanatory text, e.g., "Reach higher levels by increasing coin spending in the room. Rewards can be claimed once per level."
3. **Top Bar**:
    - Displays:
        - Current Room Level.
        - XP Progress Bar (coins spent toward the next level).
        - Total room followers.
4. **Confirmation Dialog**:
    - Appears when the **Get Button** is clicked.
    - Example message: "Claim the reward for Level 5? This action cannot be undone."
    - Buttons: **Confirm** and **Cancel**.

---

## **4. Dynamic Behavior**

### **4.1 Reward Availability**

- **Get Button**:
    - Enabled only if:
        - Required coin threshold is met.
        - Reward has not yet been claimed.
    - Changes to **Claimed** after successful claiming.
- **Real-Time Updates**:
    - Progress bar and reward availability update dynamically as coins are spent.

### **4.2 Error Handling**

- Connectivity issues:
    - "Unable to claim the reward. Please check your connection."
- Reward claim attempts:
    - "Reward already claimed."

---

## **5. Edge Cases**

1. **Insufficient Coins**:
    - Tooltip on disabled **Get Button**: "Insufficient coins to unlock this reward."
2. **Already Claimed Reward**:
    - Replace **Get Button** with **Claimed**.
3. **Additional Coins After Level Reached**:
    - Rewards remain claimable even if additional coins are spent after unlocking.
4. **Concurrent Claims**:
    - Backend validation ensures a reward can only be claimed once.
    - Error message: "Reward already claimed."
5. **Missing Reward Data**:
    - Disable the row in the reward table.
    - Tooltip: "Reward details unavailable. Please contact support."

---

## **6. Error Handling**

### **Common Errors**

1. **Connectivity Issues**:
    - "Unable to load reward data. Please check your connection."
    - "Unable to claim the reward. Please try again."
2. **Validation Errors**:
    - "Reward already claimed."
    - "Insufficient coins to unlock this reward."
3. **Data Issues**:
    - "Reward details missing. Please contact support."

---

## **7. Future Considerations**

1. **Reward History Section**:
    - Display claimed rewards with timestamps.
2. **Personalized Rewards**:
    - Tailor rewards based on room activity metrics (e.g., active participants).
3. **Admin Analytics**:
    - Insights into frequently reached levels and claimed rewards.
4. **Gamification**:
    - Add badges or achievements for milestones (e.g., "First Room to Reach Level 10").

---

# **Room’s Sub Page: Room’s Coins Activity Page**

---

## **1. Purpose**

- Displays a leaderboard ranking users based on the coins they’ve spent in a room.
- Provides insights into room engagement and recognizes top contributors.
- Encourages spending by showcasing contributors across different periods (daily, weekly, monthly).

---

## **2. Navigation**

### **Access Points**

- **Coins Button**: Found on the Room Page, displaying the total coins spent in the room for the current day.
- **Dynamic Updates**: Button updates in real-time to reflect the latest totals.

---

## **3. Key Components**

### **3.1 Tabs**

1. **Daily Tab**:
    - Displays rankings for the current day.
    - Resets at midnight.
2. **Weekly Tab**:
    - Shows rankings for the current week.
    - Resets at the start of the new week.
3. **Monthly Tab**:
    - Lists rankings for the current month.
    - Resets at the start of the new month.

### **3.2 Leaderboard Entries**

Each leaderboard entry includes:

1. **Rank**: Position of the user based on total coins spent.
2. **User Avatar**: Circular image representing the user.
3. **User Name**: Display name of the user.
4. **User ID**: Unique identifier (e.g., "ID:123456").
5. **Wealth Badge**: Visual indicator of the user’s wealth level across the platform.
6. **Coins Spent**: Total coins spent by the user within the selected time frame.

---

## **4. Features**

### **4.1 Infinite Scrolling**

- Displays the top 20 users initially.
- Dynamically loads additional users as the user scrolls.

### **4.2 Real-Time Updates**

- Leaderboard updates dynamically as coins are spent in the room.
- Reflects changes without requiring a page refresh.

### **4.3 Rank 1 Notifications**

- Notifications sent when a user achieves Rank 1:
    - **Push Notification**: For offline users.
    - **System Alerts**: Displayed in the Notifications Page under System Alerts.

### **4.4 Fallback for No Spending**

- Displays a placeholder message if no spending activity is recorded:
    - Example: **"No coin activity yet. Be the first to contribute!"**

---

## **5. Edge Cases and Solutions**

1. **Leaderboard Reset Timing**:
    - Lock updates briefly during reset (e.g., 5 seconds).
    - Display: **"Leaderboard is updating. Please wait a moment."**
2. **Tied Rankings**:
    - Use secondary sorting based on the timestamp of the last coin spent (earlier spender ranks higher).
3. **Infinite Scrolling Failure**:
    - Retry mechanism with a message: **"Failed to load more entries. Tap to retry."**
4. **Real-Time Overload**:
    - Throttle updates to batch changes every 1-2 seconds.
5. **Rank 1 Notification Delivery**:
    - Retry notifications until delivery succeeds.
    - Store in **System Alerts** for later retrieval.
6. **Jump to My Rank**:
    - Add a **"Jump to My Rank"** button for users outside visible ranks.
7. **No Coin Spending**:
    - Placeholder message indicating no activity.
8. **User Removal**:
    - Retain their contribution for historical accuracy.

---

## **6. API and Backend Considerations**

### **6.1 API Endpoints**

1. **Get Leaderboard Data**:
    - Route: `/api/rooms/:roomId/leaderboard`
    - Parameters:
        - `period`: `daily`, `weekly`, `monthly`.
        - `page`: Pagination for infinite scrolling.
    - Response:
    
    ```jsx
    {
      "leaderboard": [
        {
          "id": 123,
          "name": "Hori",
          "avatar_url": "https://example.com/avatar.jpg",
          "coins_spent": 5000,
          "wealth_badge": 5
        }
      ],
      "total_users": 250
    }
    ```
    
2. **Real-Time Updates**:
    - Use **Socket.IO** for broadcasting leaderboard changes.
3. **Rank 1 Notifications**:
    - Triggers:
        - Daily: Midnight.
        - Weekly: Start of the new week.
        - Monthly: Start of the new month.

---

## **7. Testing Criteria**

### **7.1 Functional Testing**

1. Verify accurate rankings for all tabs (Daily, Weekly, Monthly).
2. Ensure tied rankings are resolved correctly.

### **7.2 Infinite Scrolling**

1. Validate smooth scrolling and data retrieval.
2. Test failure scenarios with retries for loading entries.

### **7.3 Notifications**

1. Ensure Rank 1 notifications are delivered both as push and in-app alerts.
2. Test notifications for multiple reset scenarios.

### **7.4 Edge Case Handling**

1. Simulate scenarios with no spending activity.
2. Test data retention for removed users.

### **7.5 Performance Testing**

1. Measure API response times for large datasets.
2. Optimize real-time updates for heavy activity (1,000+ participants).

---

# **Room’s Sub Page: Room’s Active Users List Page**

---

## **1. Purpose**

- Displays a detailed, real-time list of users currently active in a room.
- Provides tools for room admins and owners to efficiently manage participants.
- Allows participants to navigate to user profiles for interaction and recognition.

---

## **2. Navigation**

### **Access Points**

- **Active Users Counter Button**: Located on the Room Page, displaying the total number of active users in real time.

---

## **3. Key Components**

### **User Entries**

Each entry in the list includes:

1. **User Avatar**: Circular image of the user’s profile picture.
2. **User Name**: Display name of the user.
3. **User ID**: Globally unique identifier (e.g., "ID:123456").
4. **Wealth Badge**: Represents the user’s wealth level (based on coins spent).
5. **Charm Badge**: Reflects the user’s charm level (based on coins earned).
6. **Role Text**: Indicates the user’s role in the room (e.g., Owner, Admin, Member, Visitor).
7. **Admin Actions Button**: A menu or gear icon for admin controls.

---

## **4. Features**

### **4.1 Admin Actions**

Accessible through the **Admin Actions Button**, with the following options:

1. **Kick**:
    - Removes the user from the room.
    - Confirmation dialog: **"Are you sure you want to kick [User Name] out of the room?"**
2. **Assign Role**:
    - Assign or update the user’s role in the room.
    - Includes a dropdown for role selection.
    - Confirmation dialog: **"Are you sure you want to assign the [Role] role to [User Name]?"**
3. **Block**:
    - Prevents the user from rejoining the room.
    - Confirmation dialog: **"Are you sure you want to block [User Name] from this room?"**

### **4.2 Infinite Scrolling**

- Displays the first 20 users by default.
- Dynamically loads additional users as the list is scrolled.

### **4.3 Real-Time Updates**

- Reflects changes instantly when users:
    - Join or leave the room.
    - Have their roles updated.
    - Are kicked or blocked.

### **4.4 Filter**

- A single **Members Filter** to display users with the **Member** role only.

### **4.5 Clickable Profiles**

- Clicking on a user’s avatar or name navigates to their **Public Profile Page**.

### **4.6 Placeholder for No Active Users**

- Displays a friendly message when no users are active:
    - Example: **"No active users at the moment. Be the first to join the conversation!"**

---

## **5. Edge Cases and Solutions**

1. **Real-Time Joins/Leaves**:
    - Highlight new users briefly when they join the room.
2. **Role Assignment Conflicts**:
    - Reflect role updates dynamically and show success notifications.
3. **Simultaneous Admin Actions**:
    - Lock user entries during actions to prevent conflicts.
4. **No Active Users**:
    - Show a placeholder message when the room is empty.
5. **Large User Counts**:
    - Use virtualized rendering and infinite scrolling for efficient performance.
6. **Network or API Failures**:
    - Display error messages with retry options:
        - Example: **"Failed to load active users. Tap to retry."**
    - Cache the last successful data for temporary display.
7. **Duplicate Entries**:
    - Deduplicate by verifying user IDs before rendering.

---

## **6. API and Backend Considerations**

### **6.1 API Endpoints**

1. **Get Active Users**:
    - Route: `/api/active-users`
    - Parameters:
        - `roomId`: ID of the room.
        - `page`: Pagination for infinite scrolling.
    - Response:
    
    ```jsx
    {
      "active_users": [
        {
          "id": 123,
          "name": "Hori",
          "avatar_url": "https://example.com/avatar.jpg",
          "role": "Admin",
          "wealth_badge": 5,
          "charm_badge": 3
        }
      ],
      "total_active_users": 250
    }
    ```
    
2. **Admin Actions**:
    - **Kick User**: `POST /api/rooms/:roomId/kick-user`
    - **Block User**: `POST /api/rooms/:roomId/block-user`
    - **Assign Role**: `POST /api/rooms/:roomId/assign-role`

### **6.2 Real-Time Updates**

- **Socket.IO** or similar technology:
    - Synchronize user entries for joins, leaves, and role updates.
    - Handle admin actions and reflect changes instantly.

---

## **7. Testing Criteria**

### **7.1 Functional Testing**

1. Validate admin actions (kick, block, assign role) with confirmation dialogs.
2. Verify real-time updates for joins, leaves, and role changes.

### **7.2 Performance Testing**

1. Ensure smooth scrolling and rendering with large datasets.
2. Test responsiveness under heavy user loads (e.g., 1,000+ active users).

### **7.3 Edge Case Handling**

1. Simulate:
    - Empty rooms.
    - Network failures during data loading.
    - Simultaneous admin actions.

### **7.4 Error Handling**

1. Verify retry mechanisms for failed API calls.
2. Validate placeholder display when no active users are present.