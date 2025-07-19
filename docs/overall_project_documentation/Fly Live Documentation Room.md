# Fly Live Documentation: Room

# **Fly Live Documentation: Room Creation Page**

---

## **1. Purpose**

- Allow users to create customized rooms with unique settings, including a name, logo, and visibility type (Public/Private).
- Ensure that each user can create only one room at a time.
- Provide an intuitive and user-friendly experience for room creation.

---

## **2. UI/UX Design**

### **Key Components**

1. **Upload Logo**:
    - Mandatory upload.
    - Supports file types: PNG, JPG, WEBP, SVG.
    - Maximum file size: 2 MB.
    - Enforced aspect ratio: 1:1 (square).
    - Features:
        - Progress bar during upload.
        - Retry option with error messages in case of failure.
2. **Room Name**:
    - Required field.
    - Maximum 40 characters.
    - Must be globally unique across the platform.
3. **Type Dropdown**:
    - Default: Public.
    - Options: Public, Private.
    - If **Private** is selected:
        - A password input field appears.
        - Password is mandatory for submission.
4. **Create Button**:
    - Activated only after all required fields are valid.
    - Submits the form to finalize room creation.
5. **Confirmation Dialog**:
    - Prompts users attempting to exit the page without completing room creation.

---

## **3. Functional Requirements**

### **Validation Rules**

1. **Logo**:
    - Mandatory upload.
    - File type: PNG, JPG, WEBP, SVG.
    - File size: Maximum 2 MB.
    - Aspect ratio: 1:1 (square).
2. **Room Name**:
    - Required and globally unique.
    - Maximum 40 characters.
3. **Type**:
    - Public (default) or Private.
    - Private rooms require a password.
4. **Password (Private Rooms Only)**:
    - Required when the room type is Private.
    - Stored as plain text.

### **Behavior**

1. **Logo Upload**:
    - Asynchronous upload with progress bar and retry options.
2. **Form Submission**:
    - Disabled until all mandatory fields are validated.
    - Redirects users to the Room Page upon successful submission.
3. **Exit Handling**:
    - Displays a confirmation dialog if the user attempts to leave the page without completing room creation.

---

## **4. Backend and Database Considerations**

### **Rooms Table**

| **Field Name** | **Data Type** | **Notes** |
| --- | --- | --- |
| `id` | BIGINT (PK) | Auto-increment, primary key. |
| `name` | VARCHAR(40) | Required, globally unique. |
| `type` | ENUM | 'public', 'private'. |
| `password` | TEXT | Nullable, required only for private rooms (stored as plain text). |
| `room_logo` | TEXT | Required, stores URL of the uploaded logo. |
| `owner_id` | BIGINT (FK) | Foreign key linking to the `users` table. |
| `theme_id` | BIGINT (FK) | Nullable, foreign key linking to the `themes` table. |
| `mic_seat_quantity` | INTEGER | Default: 5. |
| `welcome_message` | TEXT | Nullable. |
| `tourists_can_speak` | BOOLEAN | Default: `false`. |
| `tourists_can_send_text` | BOOLEAN | Default: `false`. |
| `tourists_can_send_pictures` | BOOLEAN | Default: `false`. |
| `status` | ENUM | 'active', 'inactive'. |
| `visibility` | BOOLEAN | Default: `true`. |
| `created_at` | TIMESTAMP | Auto-set upon creation. |
| `updated_at` | TIMESTAMP | Auto-updated upon modification. |

### **File Storage**

- Room logos stored in **DigitalOcean Spaces**.
- Server-side optimization:
    - Resize logos to 512x512px.
    - Compress for efficient storage and retrieval.

---

## **5. Security Considerations**

1. **File Uploads**:
    - Validate file types and size on both the client and server sides.
    - Serve files via CDN using signed URLs for security.
2. **Password Storage**:
    - Stored as plain text (intended for minimal complexity).
    - Visible only in the room settings for private rooms.

---

## **6. Testing Criteria**

### **Validation Testing**

1. Ensure all fields (logo, name, type, password) are validated properly.
2. Test error handling for:
    - Invalid file types or sizes.
    - Duplicate room names.
    - Missing passwords for private rooms.

### **Upload Testing**

1. Verify functionality of:
    - Progress bar.
    - Retry mechanism for failed uploads.

### **Behavior Testing**

1. Ensure confirmation dialog appears when attempting to leave an incomplete room creation process.
2. Confirm successful redirection to the Room Page upon submission.

### **Backend Testing**

1. Validate database constraints for:
    - Unique room names.
    - Required fields.
2. Ensure proper storage and retrieval of room logos from **DigitalOcean Spaces**.

### **Performance Testing**

1. Measure logo upload times and ensure smooth progress bar updates.
2. Verify scalability to handle multiple simultaneous room creation requests.

---

## **7. Notes**

- Room Theme functionality will be addressed in the **Room Theme Page Documentation**.
- Member and visitor privileges will be detailed in the **Room Page Documentation**.

---

# **Fly Live Documentation: Room Page**

---

## **1. Purpose**

- The Room Page serves as the central hub for real-time interaction, engagement, and monetization.
- Features include audio broadcasting, gifting, chat, and customizable settings, catering to room owners, admins, and users.
- Designed for scalability, responsiveness, and seamless user experiences.

---

## **2. Navigation**

### **Entry Points**

1. **Home Page**: Users join rooms by clicking room cards.
2. **Search Page**: Users search for and join rooms.
3. **Personal Profile Page**:
    - Room owners access their rooms via **My Room**.
    - Participants access rooms they follow in **Following Rooms**.
4. **Room Creation**: Redirects users to their newly created room.

### **Exit Points**

1. **Exit Room Button**:
    - Displays a confirmation dialog:
        - **Exit Room**: Disconnects entirely.
        - **Minimize Room**: Keeps audio broadcasting active in the background.
    - **Edge Case**: Validate room closure only when all participants exit.

---

## **3. UI/UX Design**

### **3.1. Top Section**

1. **Room Logo**:
    - Displays the room’s logo with a fallback placeholder if absent.
    - Clicking redirects admins to the **Room Settings Page**.
2. **Room Name and ID**:
    - Displays the room name and unique ID with tooltips for long names.
3. **Room Level**:
    - Displays XP progress bar, updated in real-time based on contributions.
4. **Action Buttons**:
    - **Follow**: Adds/removes the room from the user’s following list.
    - **Share**: Generates an invite link to the room.
    - **Exit**: Opens the exit confirmation dialog.

### **3.2. Mic Seats Grid**

1. **Seat Types**:
    - **Empty Seats**: Available for users.
    - **Occupied Seats**: Displays occupant’s avatar and name.
    - **Locked Seats**: Grayed-out with lock icons.
2. **Admin Controls**:
    - Mute/unmute, kick/block users, lock/unlock seats.
3. **Background Music Seat**:
    - Hidden seat for managing music playlists or tracks.
4. **Real-Time Updates**:
    - Reflects seat changes, user joins, and exits instantly.

### **3.3. Coins Activity Button**

1. Displays the total coins spent in the room.
2. Clicking navigates to the **Coins Activity Page**.
3. Updates dynamically with every transaction.

### **3.4. Active Users Button**

1. Displays the number of active participants in the room.
2. Clicking navigates to the **Active Users List Page**.
3. **Edge Case**: Ensure accuracy during rapid joins or leaves.

### **3.5. Chat Section**

1. **Messaging**:
    - Real-time chat visible to all participants.
    - Admin announcements pinned at the top.
2. **Tourist Permissions**:
    - Configurable for sending messages or images.
3. **Edge Cases**:
    - Handle reconnections and prevent duplicate messages.

### **3.6. Gift System**

1. **Gift Modal**:
    - **Recipient Selector**: Carousel for selecting recipients.
    - **Categories**: Tabs for Normal, Lucky, CP, VIP, and Country-Themed Gifts.
    - **Gift Cards**: Thumbnails, prices, and previews.
    - **Quantity Selector**: Dropdown for 1–99 quantities.
    - **Send Button**: Deducts coins and triggers animations.
2. **Gift Playback**:
    - Sequential full-screen animations for `.svga` and `.mp4` files.
3. **Backend Processing**:
    - Deducts coins, distributes percentages, and updates metrics.

---

## **4. Backend Integration**

1. **Real-Time Updates**:
    - **Socket.IO** for mic seat changes, chat, and gifting.
    - **Redis Pub/Sub** for synchronized updates across threads.
    - **Laravel Queues** for asynchronous processing (e.g., coin deductions, leaderboard updates).
2. **Gift Processing**:
    - Calculates coin deductions, XP allocation, and bank returns.
    - Ensures atomic updates across sender, recipient, room, and bank balances.

---

## **5. Calculations and Distributions**

### **Sender Deduction**

1. **Coins Deducted**:
Total Coins Deducted = Gift Price × Quantity Sent
2. **Wealth Level XP (WEXP)**:
Sender’s WEXP += Total Coins Deducted × WEXP Percentage

### **Recipient Distribution**

1. **Non-Agency Users**:
    - Recipient earns coins:
    Recipient’s Coins += Total Coins Deducted × NAMGI Percentage
    - Recipient earns Charm Level XP (CEXP):
    Recipient’s CEXP += Total Coins Deducted × CEXP Percentage
2. **Agency Users**:
    - Recipient earns diamonds:
    Recipient’s Diamonds += Total Coins Deducted × AMGI Percentage

### **Bank Returns**

1. Remaining coins are returned to the bank:
Bank Return Coins = Total Coins Deducted - Recipient’s Coins

### **Room Owner Earnings**

1. Room owner earns a percentage of the total room spend:
Room Owner’s Coins = Total Coins Spent in Room Today × RO Percentage

---

## **6. Edge Cases**

1. **Gift Playback**:
    - Fallback assets for missing/corrupted files.
2. **User Behavior**:
    - Handle rapid joins, leaves, and seat changes.
3. **Room Closure**:
    - Validate closure when all participants exit.

---

## **7. Testing Criteria**

1. **Functional Testing**:
    - Validate real-time mic seat updates, chat, gifting, and metric updates.
2. **Performance Testing**:
    - Test room scalability with 1,000+ users.
    - Benchmark API latency (<200ms for gifting/chat).
3. **Edge Case Testing**:
    - Simulate failures (e.g., network disruptions, asset errors).
    - Ensure data consistency during rapid user actions.