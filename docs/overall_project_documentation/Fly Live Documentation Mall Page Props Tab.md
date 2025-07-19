# Fly Live Documentation: Mall Page: Props Tab

---

## **1. Overview**

The **Props Tab** on the Mall Page is a dynamic marketplace for users to purchase or gift various virtual items, enhancing their experience in the app. Props include frames, entry effects, chat bubbles, and unique IDs. All content is dynamically managed via the admin panel, ensuring scalability and freshness.

---

## **2. Key Features**

### **2.1 Props Tab (Default Tab)**

- **Purpose**: Display available props for purchase or gifting.
- **Item Details**:
    - **Thumbnail**: Preview image or animation.
    - **Price**: Cost in coins, prominently displayed.
    - **Expiration**: Duration of the item's validity after purchase (e.g., **"100 Days"**).
- **Actions**:
    - **Buy**: Purchase the item for personal use.
    - **Send**: Gift the item to another user.

### **2.2 Tab Navigation**

- Categorized tabs at the top:
    - **Frame**: Decorative elements for user profiles.
    - **Entry**: Special visual effects displayed when users join rooms.
    - **Chat Bubble**: Unique chat bubble designs for messaging.
    - **Unique ID**: Custom identifiers or unique in-app assets.

### **2.3 Dynamic Content**

- Props are dynamically fetched from the database.
- Admin-controlled configurations:
    - **Visual Assets**: Thumbnails and animations.
    - **Pricing**: Coin costs for each prop.
    - **Expiration Durations**: Defined periods of item validity.
    - **Category Assignments**: Placement in specific tabs.

---

## **3. User Workflow**

### **Step 1: Navigation**

- Users access the Mall via their Personal Profile.
- By default, the **Props Tab** is displayed.

### **Step 2: Browsing Props**

- Users can browse items by switching between categorized tabs.
- Each item displays its thumbnail, price, and expiration duration.

### **Step 3: Purchasing Items**

1. **Buy**:
    - Click the **Buy** button.
    - The item is added to the user’s inventory.
    - If the item is already owned:
        - The expiration duration is extended by adding the new time to the remaining time.
    - Confirmation displays:
        - **"Item added to your inventory."**
2. **Send**:
    - Click the **Send** button.
    - Select a recipient from the list.
    - If the recipient owns the item:
        - The remaining duration is updated to include the new gifted time.
    - **Edge Case**: If the recipient is inactive or suspended:
        - Display:
        The recipient is currently inactive or suspended. They will not be able to use the item until reactivation, but the duration will start counting from the gifting time. Are you sure you want to proceed?
        - Require confirmation to proceed.

---

## **4. Technical Details**

### **4.1 Admin Panel Integration**

- Props are uploaded and managed via the admin panel:
    - Add new categories.
    - Update prices and expiration durations.
    - Upload visual assets.

### **4.2 Database Structure**

- **Props Table**:
    - `id`: Unique identifier for each prop.
    - `name`: Name of the prop.
    - `category`: Frame, Entry, Chat Bubble, or Unique ID.
    - `thumbnail`: URL of the thumbnail.
    - `animation_asset`: URL of the animation file.
    - `price`: Cost in coins.
    - `expiration_duration`: Validity period after purchase.
- **User Inventory Table**:
    - `user_id`: Links to the user.
    - `prop_id`: Links to the prop.
    - `expiration_date`: Tracks when the prop expires.

### **4.3 Dynamic Data Loading**

- Props are fetched via API for dynamic population.
- Versioning ensures consistency:
    - **Version Check**: Validates item details before purchase.
    - **Mismatch Handling**: Prompts the user to refresh if details are outdated.

---

## **5. Error Handling**

### **5.1 Purchase Errors**

- **Insufficient Coins**:
    - Display: **"You do not have enough coins to purchase this item."**
- **Outdated Item Data**:
    - Display: **"Item details have changed. Please refresh the page and try again."**

### **5.2 Gifting Errors**

- **Inactive Recipient**:
    - Display: **"Recipient is inactive or suspended. Confirm to proceed."**
- **Invalid Recipient Selection**:
    - Display: **"Please select a valid recipient."**

### **5.3 Loading Failures**

- If props fail to load:
    - Display: **"Unable to load props. Please try again later."**
    - Provide a **Retry Button** for manual refresh.

---

## **6. Future Enhancements**

1. **Filtering and Sorting**:
    - Add filters for price, popularity, and expiration duration.
2. **Search Functionality**:
    - Enable keyword search for specific props.
3. **Animated Previews**:
    - Allow users to preview animations or effects before purchasing.
4. **Personalization Features**:
    - Highlight recommended props based on user activity.

---

# **Mall Page: My Props Tab**

---

## **1. Overview**

The **My Props Tab** serves as the user’s personal inventory, showcasing all purchased or earned props and their remaining durations. It enables users to manage, gift, or activate their items for various use cases such as profile customization, chat enhancements, or room personalization.

---

## **2. Key Features**

### **2.1 Inventory Display**

- **Item Details**:
    - **Thumbnail**: Visual preview of the item.
    - **Remaining Duration**: Displayed dynamically (e.g., **"100 Days Remaining"**).
    - **Date Acquired**: Visible for user reference.
- **Categories**:
    - **Frame**: Avatar decorations.
    - **Entry**: Special effects for entering rooms.
    - **Chat Bubble**: Customized chat bubble designs.
    - **Unique ID**: Personalized identifiers.
    - **Room Themes**: Available only for room owners to manage their room’s appearance.

### **2.2 Gifting Items**

- **Workflow**:
    - Users select an item and click the **Send** button.
    - The recipient is selected from the user’s followers or contacts.
    - **Transfer Mechanics**:
        - The remaining duration of the item is gifted to the recipient.
        - The sender loses ownership of the item.
    - **Edge Case**: If the recipient is inactive or suspended:
    - Confirmation is required before completing the transaction.
    
    The recipient is currently inactive or suspended. They will not be able to use the item until reactivation, but the duration will start counting from the gifting time. Are you sure you want to proceed?

### **2.3 Activating Items**

- **Activation Workflow**:
    - Each item has an **Activate** button.
    - Activation applies the item to its relevant category:
        - **Frames**: Applied to the user’s profile avatar.
        - **Chat Bubbles**: Applied to chat interactions.
        - **Entry Effects**: Used during room entry.
        - **Room Themes**: Personalizes the user’s room (if applicable).
- **Restrictions**:
    - Only one item per category can be active at a time.
    - Activation immediately overrides any previously active item in the same category.

---

## **3. Technical Details**

### **3.1 Dynamic Remaining Duration**

- The system calculates remaining duration using:
Remaining Duration = Total Validity - (Current Date - Purchase Date)
- Example:
    - A 100-day item purchased 10 days ago will display **"90 Days Remaining."**

### **3.2 Gifting and Activation**

- **Gifting**:
    - Backend validations ensure:
        - Recipient is active or confirms suspension notification.
        - Transaction is atomic to avoid partial transfers.
- **Activation**:
    - Backend checks ensure:
        - Only one item per category is active.
        - Newly activated items overwrite existing active items.

### **3.3 Room Themes**

- **Exclusive Tab**:
    - Visible only if the user owns a room.
    - Displays all owned themes, with options for activation.
- **Theme Updates**:
    - Activation applies the theme immediately, updating the room’s appearance in real-time.

---

## **4. Error Handling**

1. **Gifting Errors**:
    - **Insufficient Permissions**: Display **"You do not have permission to gift this item."**
    - **Recipient Inactivity**: Display a confirmation: **"The recipient is inactive. Do you want to proceed?"**
2. **Activation Failures**:
    - **Backend Conflict**: Display **"Unable to activate this item. Please try again."**
    - **Expired Item**: Display **"This item has expired and cannot be activated."**
3. **Loading Issues**:
    - Display **"Unable to load your props. Please refresh and try again."**
    - Provide a **Retry Button** for manual refresh.

---

## **5. User Workflow**

1. **Navigating to My Props Tab**:
    - Access the **Mall Page** via the Personal Profile.
    - The default tab displayed is **My Props**.
2. **Browsing Inventory**:
    - Switch between tabs to view categorized items.
    - Dynamic thumbnails and durations help users track their inventory.
3. **Managing Items**:
    - **Activate**: Applies the item to its respective context.
    - **Send**: Transfers the item to another user with confirmation.

---

## **6. Future Enhancements**

1. **Sorting and Filtering**:
    - Add options to sort by **remaining duration** or **acquisition date**.
2. **Expiration Notifications**:
    - Notify users of items nearing expiration.
3. **Item Previews**:
    - Allow users to preview items before activation or gifting.