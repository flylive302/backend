# Fly Live Documentation: Personal Profile Page

---

## **1. Overview**

The Personal Profile Page serves as a central hub for users to:

- View and manage their profile information.
- Navigate to essential features like wallet, levels, and badges.
- Track real-time engagement metrics such as followers, gifts, and room visits.

---

## **2. Key UI Elements**

### **2.1 User Information Section**

1. **Profile Picture**:
    - Displays the user’s avatar or image.
2. **User Name**:
    - Prominently displayed below the profile picture.
3. **ID Number**:
    - Unique identifier shown beneath the user name.

### **2.2 Stats Section**

1. **Follow**: Number of users the profile owner is following.
2. **Fans**: Total number of followers (fans).
3. **Gifts Received**: Total gifts received by the user.
4. **Gifts Sent**: Total gifts sent by the user.
5. **Visits**: Number of rooms or events visited by the user.

### **2.3 Navigation Menu**

Each menu item provides access to specific sections or features:

1. **Wallet**:
    - Includes tabs for Recharge, Exchange, and Billing History.
2. **Mall**:
    - Allows purchases for Avatars, Frames, Room Themes, and more.
3. **Level**:
    - Tabs for Wealth Level and Charm Level.
4. **VIP**:
    - Displays VIP levels (VIP 1 to FLSVIP).
5. **Badge**:
    - Includes Achievement Badges, Activity Badges, and Personal/Room Badges.
6. **My Agency**:
    - Links to Members Management, Income, New Member Requests, and more.
7. **My Income**:
    - Displays user earnings, salary target progress, and transaction history.
8. **Feedback**:
    - Submit queries or feedback to the app admins.
9. **Settings**:
    - Options for account authentication, privacy, and blacklist management.
10. **Modify Information**:
    - Accessed via the three-bar menu.
    - Navigates to the **Personal Profile Settings Page** for updating:
        - Name, gender, birthday, country, phone number, password, and signature.

---

## **3. Functional Requirements**

### **3.1 Dynamic Data Updates**

- Real-time updates for:
    - Follow/Fan counts.
    - Gifts sent/received.
    - Visits and other engagement metrics.

### **3.2 Fallback Behavior**

- Display cached data during network issues or API failures.
- Notify users with: **"Data may not be up to date."**

### **3.3 Seamless Navigation**

- Each menu item directly navigates to its respective page without interruptions or pop-ups.

---

## **4. Error Handling**

1. **API Failures**:
    - Display cached data with a subtle message: **"Data may not be up to date."**
2. **Page Not Found**:
    - Redirect to the Home Page or display a friendly error message.

---

## **5. Future Enhancements**

1. **Role-Based Restrictions**:
    - Implement access controls for sections like VIP or My Agency based on user permissions or roles.
2. **Gamification Features**:
    - Add progress bars, achievements, or gamified elements to boost user engagement.
3. **Localization**:
    - Provide multi-language support for global users.

---