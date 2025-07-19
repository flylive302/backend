# Fly Live Documentation: 2nd Sub Page Collection:

---

# **Room’s Sub Page: Room Settings Page**

## **1. Purpose**

- Provides room admins with tools to customize and manage their rooms, including appearance, permissions, and participant settings.
- Ensures a seamless and efficient room management experience.

---

## **2. Navigation**

### **Access Points**

- **Three Cubes Icon**: Available on the Room Page toolbar.
- Visible exclusively to room admins.

---

## **3. Key Features and Components**

### **3.1 Room Picture**

- **Purpose**: Upload or update the room’s logo.
- **Specifications**:
    - Supported Formats: PNG, JPG, WEBP, SVG.
    - Max File Size: 2 MB.
    - Aspect Ratio: 1:1 (square).
- **Behavior**: Updates the room’s logo immediately upon upload.

### **3.2 Room Name**

- **Purpose**: Edit the room’s name.
- **Character Limit**: 40 characters.
- **Validation**: Must be unique across all rooms.
- **Behavior**: Updates in real-time across listings and search results.

### **3.3 Announcement**

- **Purpose**: Edit the room’s announcement message.
- **Character Limit**: 800 characters.
- **Behavior**: Updates immediately in the room’s announcement banner.

### **3.4 Room Theme**

- **Purpose**: Navigate to the **Room Theme Page** for theme management.
- **Behavior**: Displays the current theme status (e.g., Free, Premium).

### **3.5 Room Password**

- **Purpose**: Enable or edit the room password for private rooms.
- **Behavior**:
    - Available only for private rooms.
    - Changes take effect immediately.

### **3.6 Members**

- **Purpose**: Navigate to the **Members Management Page**.
- **Features**:
    - View, add, or remove members.
    - Assign privileges to members.

### **3.7 Mic Seat Quantity**

- **Purpose**: Adjust the number of mic seats.
- **Range**: 1 to 15.
- **Behavior**: Updates dynamically in the room layout.

### **3.8 Blocked List**

- **Purpose**: Manage blocked users.
- **Behavior**: Allows unblocking via a navigable link.

### **3.9 Seat Apply Mode**

- **Purpose**: Toggle the mic seat application process.
- **Behavior**:
    - Enabled: Users must apply for mic seats.
    - Disabled: Users can occupy seats freely.

### **3.10 Tourist Permissions**

1. **Tourists on Mic**: Allow/restrict tourists from taking mic seats.
2. **Tourists Send Text**: Control text message permissions for tourists.
3. **Tourists Send Pictures**: Control image-sharing permissions for tourists.
- **Behavior**: Controlled via toggle switches.

### **3.11 Hidden Room**

- **Purpose**: Toggle room visibility in search results.
- **Behavior**: Controlled via toggle switch.

### **3.12 Greetings**

- **Purpose**: Set a welcome message for new users.
- **Character Limit**: 255 characters.
- **Behavior**: Editable via the **Greetings Settings Page**.

---

## **4. Dynamic Behavior**

1. **Real-Time Updates**:
    - Settings changes are applied instantly (e.g., themes, mic seat adjustments).
2. **Toggle Buttons**:
    - Instant updates for features like **Hidden Room** and **Tourist Permissions**.

---

## **5. Edge Cases and Solutions**

### **5.1 Room Name**

- **Scenario**: Exceeds character limit.
    - **Solution**: Show error: "Room name cannot exceed 40 characters."
- **Scenario**: Duplicate name.
    - **Solution**: Show error: "Room name must be unique."

### **5.2 Mic Seat Quantity**

- **Scenario**: Out of range value.
    - **Solution**: Show error: "Mic seat quantity must be between 1 and 15."

### **5.3 Password Setting**

- **Scenario**: Admin sets a password for a public room.
    - **Solution**: Prompt: "Switch to private mode to set a room password."

### **5.4 Image Upload**

- **Scenario**: File exceeds size limit.
    - **Solution**: Show error: "File size exceeds the limit. Please upload an image under 2 MB."

### **5.5 Tourist Permissions**

- **Scenario**: All tourist permissions disabled.
    - **Solution**: Show warning: "Disabling all tourist permissions may reduce room engagement."

---

## **6. Error Handling**

1. **Invalid Inputs**:
    - Inline error messages for incorrect values (e.g., invalid file format for room picture).
2. **Connectivity Issues**:
    - Retry option: "Unable to save changes. Please check your connection and try again."
3. **Backend Validation**:
    - Generic error message: "An error occurred while saving settings. Please try again later."

---

## **7. Open Questions and Future Considerations**

1. **Preview Changes**:
    - Should admins preview updates (e.g., themes, announcements) before saving?
2. **Bulk Member Actions**:
    - Would bulk actions (e.g., block/unblock multiple users) improve efficiency?
3. **Advanced Visibility Settings**:
    - Should the **Hidden Room** feature allow visibility to specific user groups (e.g., followers)?

---

# **Room’s Sub Page: Room Theme Page**

---

## **1. Purpose**

- Allows room admins to customize the room’s appearance using free, custom, and premium themes.
- Supports uploading, managing, and renewing themes, promoting personalized branding and room engagement.

---

## **2. Navigation**

### **Access Points**

- **Three Cubes Icon**: Found on the Room Page toolbar.
- Accessible to room admins for theme management.

---

## **3. Theme Categories and Tabs**

### **3.1 Free Tab**

- **Purpose**: Displays pre-designed themes provided by the app admin.
- **Features**:
    - **Theme Grid**:
        - Previews all free themes with:
            - Theme image.
            - Status:
                - **Expired**: Requires renewal using coins.
                - **Active**: The currently applied theme.
                - **Available**: Ready-to-use, unexpired themes.
            - **Renew Button**: Allows renewal for expired themes.
        - **No Deletion**: Free themes cannot be deleted.

### **3.2 Custom Tab**

- **Purpose**: Enables room owners to upload and manage custom themes.
- **Features**:
    - **Theme Upload Section**:
        - **Requirements**:
            - **Name**: Must be unique.
            - **Thumbnail**:
                - File types: SVG, PNG, JPG, WEBP.
                - Max size: 2 MB.
                - Aspect ratio: 3:4.
            - **Background**:
                - File types: SVG, PNG, JPG, WEBP, GIF.
                - Max size: 4 MB.
                - Aspect ratio: 3:4.
            - **Colors**:
                - Theme, Icon, and Text colors selected via a color picker.
            - Auto-filled fields: **Uploaded By** (room owner’s ID) and **Status** (default: `expired`).
        - **Submission Behavior**:
            - Uploaded themes are added to the **Expired Themes** list.
            - Activation requires coin payment.
            - Admins and owners can preview themes before activation.
    - **Theme Grid**:
        - Displays all uploaded custom themes with:
            - Theme image.
            - Status (Expired, Active, Available).
            - **Renew Button**: Extends duration using coins.
            - **Delete Icon**: Allows deletion with a confirmation dialog:
                - Example: **"Coins spent on the theme will not be refunded. Are you sure you want to delete it?"**

### **3.3 Premium Tab**

- **Purpose**: Showcases premium themes available for purchase.
- **Features**:
    - **Theme Grid**:
        - Displays premium themes with:
            - Theme image.
            - Status (Expired, Active, Available).
            - **Renew Button**: Renews expired themes using coins.
        - **No Deletion**: Premium themes cannot be deleted.
    - **Coin Value**: Displayed as the purchase price.

---

## **4. Theme Statuses**

### **4.1 Expired**

- Indicates the theme has reached its duration limit.
- Requires renewal to reactivate.

### **4.2 Active**

- The currently applied theme.
- Only one theme can be active at a time.

### **4.3 Available**

- Indicates themes that are ready for activation or renewal.

---

## **5. Coins and Duration**

### **5.1 Free Themes**

- Provided by the app admin.
- Require coins to renew upon expiry.
- Cannot be deleted.

### **5.2 Custom Themes**

- Uploaded by room owners.
- Default status: `expired`.
- Cost: **2000 coins for 15 days** to activate or renew.
- Can be deleted by owners with confirmation.

### **5.3 Premium Themes**

- Provided by the app admin.
- Price varies by theme.
- Require coins for renewal upon expiry.
- Cannot be deleted.

---

## **6. Interactions and Workflow**

### **6.1 Uploading a Custom Theme**

1. Navigate to the **Custom Tab**.
2. Click the **+ Icon** to upload a new theme.
3. Provide required fields (name, thumbnail, background, colors).
4. Preview the theme and submit.
5. Theme is added to the Expired Themes list; activate using coins.

### **6.2 Applying or Renewing a Theme**

1. Select a theme from any tab.
2. If expired, click **Renew** and confirm coin deduction.
3. The selected theme becomes active, replacing the previous theme.

### **6.3 Deleting Custom Themes**

1. Click the **Delete Icon** on a theme card.
2. Confirm deletion via the dialog box:
    - Example: **"Coins spent will not be refunded. Confirm deletion?"**
3. Theme is permanently removed.

### **6.4 Reverting to Default Theme**

- If all themes are expired or deleted, the default theme is applied automatically.
- Notification: **"The active theme has been deleted. Your room is now using the default theme."**

---

## **7. Error Handling**

### **7.1 Common Errors**

1. **Invalid File Type**:
    - "Invalid file type. Supported formats: SVG, PNG, JPG, WEBP, GIF."
2. **File Size Exceeded**:
    - "Thumbnail: Max 2 MB. Background: Max 4 MB."
3. **Incorrect Aspect Ratio**:
    - "Invalid aspect ratio. Required: 3:4."
4. **Duplicate Theme Name**:
    - "Theme name already exists. Please choose another."
5. **Insufficient Coins**:
    - "Insufficient coins. Please recharge to activate or renew your theme."
6. **Network Issues**:
    - "Connection lost. Retry uploading your theme."

---

## **8. Room Theme Integration with Other Features**

1. **Room Thumbnail**:
    - The theme’s thumbnail is displayed in the room grid on the homepage.
2. **Room Background**:
    - Applies as the background image on the Room Page.
3. **Theme Colors**:
    - **Theme Color**: Primary UI elements.
    - **Icon Color**: Room-related icons.
    - **Text Color**: All room text elements.

---

## **9. Open Questions and Future Considerations**

1. **Admin Overrides**:
    - Should app admins be able to manually set themes as active for specific rooms? **(Yes)**
2. **Theme Previews**:
    - Should admins and owners preview themes before activation? **(Yes)**
3. **Analytics**:
    - Should premium theme purchase and usage trends be tracked for insights? **(Yes)**

---

### **Final Notes**

This documentation provides:

- Comprehensive details on managing themes for rooms.
- Robust workflows for uploading, renewing, and applying themes.
- Flexibility for scaling with premium and custom options.