# Fly Live Documentation: All Agencies Page

---

## **1. Overview**

The **All Agencies Page** provides users with a comprehensive list of all registered agencies within the app. It features a searchable, infinitely scrollable interface, enabling users to explore and navigate to individual agency profiles easily.

---

## **2. Access**

- **Entry Point**: The page is accessible via the **All Agencies Link** located on the **Personal Profile Page**.
- **Availability**: Open to all users.

---

## **3. Purpose**

- Display all agencies registered on the platform.
- Enable users to:
    - Search for specific agencies by name.
    - View agency details at a glance.
    - Navigate to the **Agency Public View Page** for more information.

---

## **4. Key Features**

### **4.1 Infinite Scroll**

- Dynamically loads additional agency data as the user scrolls.
- **Performance Optimization**:
    - Loads data in manageable chunks to ensure smooth scrolling.
    - Minimizes initial page load time.

---

### **4.2 Search Bar**

- **Real-Time Search**:
    - Filters agencies by name as the user types.
- **Validation**:
    - Requires a minimum of 3 characters for search initiation.
- **Error Handling**:
    - Displays a friendly "No results found" message for unmatched queries.

---

### **4.3 Agency Cards**

- **Details Displayed**:
    - **Logo**: Positioned prominently for branding recognition.
    - **Name**: Highlighted for easy identification.
    - **Country**: Denoted with a flag or text indicator.
    - **Member Count**: Shows the current number of active members in the agency.
- **Interactive Navigation**:
    - Clicking or tapping on a card redirects the user to the **Agency Public View Page**.

---

### **4.4 Floating Action Button (FAB)**

- **Purpose**: Quick access to the **Create Agency Page**.
- **Placement**:
    - Fixed at the bottom-right corner for easy reach.
    - Icon aligns with the app’s design language.

---

## **5. UI/UX Design**

### **5.1 Layout**

1. **Header**:
    - Page Title: "All Agencies."
    - Search Bar: Positioned directly below the title.
2. **Main Content**:
    - List of agency cards displayed in an infinite scroll.
3. **Floating Action Button**:
    - Persistent at the bottom-right of the screen.

---

### **5.2 Visual Design**

- **Agency Cards**:
    - Modern card design with rounded edges and subtle shadows for depth.
    - Uniform size for consistency.
    - Left-aligned logos, with text content neatly arranged.
- **Search Bar**:
    - Clean design with a bordered input field and placeholder text: **"Search Agencies"**.
    - Adaptive width for responsive design.
- **FAB**:
    - Circular button with an intuitive "+" icon, standing out visually.

---

### **5.3 Responsive Design**

- **Mobile**:
    - Single-column layout for a streamlined vertical scrolling experience.
    - Full-width search bar.
- **Desktop**:
    - Grid-based layout for displaying multiple cards per row (e.g., 2–3 cards).
    - Center-aligned search bar above the grid.

---

### **5.4 Interactions**

- **Search Bar**:
    - Real-time filtering as users type.
    - Displays a "No results found" placeholder for unmatched queries.
- **Agency Cards**:
    - Desktop: Highlight the card on hover for better focus.
    - Mobile: Single tap or click opens the **Agency Public View Page**.

---

## **6. Backend Integration**

### **6.1 Data Loading**

- **API Endpoint**:
    - Fetch paginated agency data to support infinite scrolling.
- **Pagination**:
    - Includes query parameters for `page` and `limit` to fetch data in chunks.

### **6.2 Search Functionality**

- **API Query**:
    - Accepts a `search` parameter to filter agencies by name.
    - Returns a filtered list based on the user’s input.

### **6.3 Navigation**

- Each agency card links to the respective **Agency Public View Page** via its unique identifier.

---

## **7. Notifications and Error Handling**

1. **Loading Errors**:
    - **Issue**: API failure or network issues.
    - **Solution**: Display a fallback message: **"Unable to load agencies. Please try again later."**
2. **Search Errors**:
    - **Issue**: No matches for the query.
    - **Solution**: Show a placeholder: **"No results found. Try another search term."**
3. **Floating Action Button Visibility**:
    - **Issue**: FAB not visible after extensive scrolling.
    - **Solution**: Ensure FAB remains fixed regardless of scroll position.

---

## **8. Future Enhancements**

1. **Advanced Filters**:
    - Add options for filtering agencies by country, size, or activity level.
2. **Featured Agencies**:
    - Highlight trending or recommended agencies at the top of the list.
3. **Sorting Options**:
    - Allow users to sort agencies by name, member count, or recent activity.
4. **Animations**:
    - Introduce smooth transitions when loading or refreshing cards for a polished experience.

---

# **All Agencies Page: Sub Page: Create New Agency Page**

---

## **1. Overview**

The **Create New Agency Page** allows users to submit a request for creating an agency by providing required details and documents. This page ensures secure data handling and seamless user experience while maintaining compliance with single-agency limitations.

---

## **2. Access**

- **Entry Point**: Accessed via the floating **+** button on the **All Agencies Page**.
- **Eligibility**:
    - Only available to users who do not currently own or belong to an agency.

---

## **3. Form Fields and Functionality**

### **3.1 Agency Logo Upload**

- **Input Type**: Image upload.
- **Behavior**:
    - Users upload a logo file.
    - Displays a preview of the selected image.
- **Validation**:
    - Supported formats: JPEG, PNG.
    - Maximum size: 2 MB.
    - Aspect ratio: 1:1 (square).

---

### **3.2 Agency Name**

- **Input Type**: Text field.
- **Validation**:
    - Maximum 20 characters.
    - Must be globally unique.
    - Non-editable after creation.
- **Behavior**:
    - Real-time validation ensures no duplicate names.

---

### **3.3 Country Selection**

- **Input Type**: Dropdown.
- **Behavior**:
    - Auto-detects the user’s country if permissions are granted.
    - Manual selection available as a fallback.
- **Validation**:
    - Country must be selected before submission.

---

### **3.4 ID Information Upload**

- **Fields**:
    - **ID Front Image**.
    - **ID Back Image**.
- **Input Type**: Image upload (two separate fields).
- **Validation**:
    - Supported formats: JPEG, PNG.
    - Maximum size: 2 MB per file.
    - Ensure clarity and visibility of legal documents.
- **Behavior**:
    - Displays previews of uploaded images.
    - Encrypts and securely stores uploaded files.

---

### **3.5 Phone Number**

- **Input Type**: Text field.
- **Validation**:
    - Matches valid phone number formats (e.g., `(03-XXXXXXX)`).
- **Behavior**:
    - Provides real-time feedback for invalid formats.

---

### **3.6 Address**

- **Input Type**: Text field.
- **Validation**:
    - No strict formatting but required for submission.

---

### **3.7 Admin ID**

- **Input Type**: Text field.
- **Definition**:
    - Refers to the profile ID of the requesting user or a referee.
- **Validation**:
    - Must match a valid user ID.

---

## **4. Submit Button**

- **Label**: "Submit Review."
- **Behavior**:
    - Ensures all fields are validated.
    - Displays error messages for missing or invalid inputs.
    - Sends the request to the App Admin dashboard for review.

---

## **5. Submission Process**

### **5.1 Admin Review Workflow**

1. **Details Reviewed by Admin**:
    - Agency logo.
    - Agency name.
    - Country.
    - ID information (front and back).
    - Phone number and address.
    - Admin ID.
2. **Approval or Rejection**:
    - Admin approves or disapproves the request.
    - Rejection includes a required reason visible to the user.

### **5.2 Notifications**

- **Approval**:
    - Push notification and **System Alerts** notification.
- **Rejection**:
    - Push notification and **System Alerts** notification with a detailed reason.

### **5.3 Single Agency Restriction**

- A user may only create and manage **one agency** if approved.

---

## **6. UI Design Guidelines**

### **6.1 Layout**

1. **Header**:
    - Page title: "Create Agency."
    - Back navigation icon.
2. **Form Sections**:
    - **Logo Upload**: Positioned at the top.
    - **Agency Details**: Name and Country Selection.
    - **ID Information Upload**: Front and back image uploads.
    - **Contact Information**: Phone number and address.
    - **Admin ID**: Positioned at the end.
3. **Submit Button**:
    - Fixed at the bottom of the page.

---

### **6.2 Visual Design**

- **Form Fields**:
    - Clean and minimalistic design.
    - Highlight active fields.
    - Error messages displayed below invalid inputs.
- **Submit Button**:
    - Prominently styled to encourage submission.
    - Disabled until all validations pass.

---

### **6.3 Responsiveness**

- **Mobile**:
    - Stacked form fields for better readability.
    - Collapsible sections for ID information.
- **Desktop**:
    - Two-column layout for enhanced space utilization.

---

## **7. Error Handling**

### **7.1 Field-Level Errors**

- **Logo Upload**:
    - "File exceeds the 2 MB size limit."
    - "Unsupported format. Please upload a JPEG or PNG."
- **Agency Name**:
    - "Agency name must be unique."
    - "Agency name cannot exceed 20 characters."
- **ID Upload**:
    - "Please upload a valid image of your ID."
- **Phone Number**:
    - "Invalid phone number format. Please try again."

### **7.2 Submission Errors**

- **API Error**:
    - "Unable to process your request at this time. Please try again later."
- **Validation Failure**:
    - "Please complete all required fields before submission."

---

## **8. Security Considerations**

1. **Data Encryption**:
    - Encrypt all ID images and personal data during transmission and storage.
2. **Access Control**:
    - Limit access to sensitive data to verified personnel.
3. **Compliance**:
    - Adhere to local and international data protection laws (e.g., GDPR).

---

## **9. Future Enhancements**

- Add support for multiple languages in form validation and error messages.
- Provide real-time validation for agency name uniqueness during typing.
- Implement a preview of the complete form before submission.