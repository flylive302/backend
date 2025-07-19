# Fly Live Documentation: Levels Page

---

## **1. Overview**

The **Levels Page** allows users to monitor their progress within the app by tracking two key metrics:

- **Wealth Level**: Reflects user spending.
- **Charm Level**: Reflects user earnings.

The page is designed for clear navigation and engagement, with dynamic progress tracking and visually appealing badges.

---

## **2. Access**

- **Entry Point**: The Levels Page is accessible via the **Level Link** on the **Personal Profile Page**.

---

## **3. Tabs and Features**

### **3.1 Wealth Level Tab (Default)**

### **Purpose**

- Tracks the coins spent by users on:
    - Gifting.
    - Purchasing items.
    - Playing games.
    - Other coin-expenditure activities.

### **Core Features**

1. **User Profile Display**:
    - **Details**:
        - Profile picture.
        - Username.
        - Current Wealth Level.
        - Assigned Wealth Badge.
    - **Progress Bar**:
        - Updates dynamically based on Wealth Experience Points (WEXP).
2. **Level Description**:
    - Explains the mechanics of WEXP:
        - Example: **"1 Coin = 1 WEXP. As you level up, the color of your Wealth Badge changes."**
3. **Level and Badge Table**:
    - Displays WEXP ranges and their corresponding badges:
        - Example Thresholds (Admin-defined):
            - **Level 1**: 0–10,855 WEXP.
            - **Level 2**: 10,856–20,000 WEXP.
        - Each level includes a unique badge, which is displayed on personal and public profiles.

### **Admin Management**

- Admins define:
    - WEXP thresholds for each level.
    - Icons/badges for all Wealth Levels.

---

### **3.2 Charm Level Tab**

### **Purpose**

- Tracks coins earned by users through:
    - Gifts received.
    - Rewards.
    - Other coin reception activities.

### **Core Features**

1. **User Profile Display**:
    - **Details**:
        - Profile picture.
        - Username.
        - Current Charm Level.
        - Assigned Charm Badge.
    - **Progress Bar**:
        - Updates dynamically based on Charm Experience Points (CEXP).
2. **Level Description**:
    - Explains the mechanics of CEXP:
        - Example: **"1 Coin = 1 CEXP. As you level up, the color of your Charm Badge changes."**
3. **Level and Badge Table**:
    - Displays CEXP ranges and their corresponding badges:
        - Example Thresholds (Admin-defined):
            - **Level 1**: 0–10,855 CEXP.
            - **Level 2**: 10,856–20,000 CEXP.
        - Each level includes a unique badge, which is displayed on personal and public profiles.

### **Admin Management**

- Admins define:
    - CEXP thresholds for each level.
    - Icons/badges for all Charm Levels.

---

## **4. User Interaction**

### **4.1 Navigation**

- Users toggle between the **Wealth Level** and **Charm Level** tabs.
- Each tab dynamically loads content, ensuring a smooth experience.

### **4.2 Progress Tracking**

- Both tabs feature:
    - A progress bar showing real-time updates toward the next level.
    - A tooltip (future enhancement) explaining badge significance.

### **4.3 Badge Display**

- Level-specific badges are prominently shown, reinforcing user achievements.

---

## **5. Design Notes**

- **Consistency**:
    - Shared UI components ensure uniformity across both tabs.
- **Dynamic Updates**:
    - Thresholds and badges are tied to Admin configurations.
- **Encouragement**:
    - Real-time progress bars and badges boost user motivation.

---

## **6. Error Handling**

1. **Failed Data Fetch**:
    - **Issue**: WEXP/CEXP data fails to load.
    - **Solution**: Display cached data with a message: **"Data may not be up to date. Please refresh."**
2. **Backend Configuration Errors**:
    - **Issue**: Missing thresholds or badge configurations.
    - **Solution**: Fallback to default badge icons and display a notice: **"Some data is temporarily unavailable."**

---

## **7. Future Enhancements**

- **Tooltips**: Add hover effects to explain badge significance.
- **Milestone Sharing**: Enable users to share level-up achievements on social media.
- **Animations**: Introduce celebratory animations for level-ups.

---