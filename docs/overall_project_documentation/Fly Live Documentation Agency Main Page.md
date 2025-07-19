# Fly Live Documentation: Agency Main Page

---

## **1. Overview**

The **Agency Main Page** serves as the central dashboard for agency owners. It provides access to critical performance metrics, tools for member management, and operational controls through dedicated sub-pages.

---

## **2. Access**

- **Eligibility**:
    - Only visible to approved agency owners.
- **Navigation**:
    - Accessed via the **Personal Profile Page** for eligible users.

---

## **3. Page Layout**

### **3.1 Header Section**

- **Content**:
    - Agency owner's profile picture.
    - Agency name.
    - Unique agency ID (e.g., `ID: 123456`).
- **Navigation**:
    - A back button for returning to the previous page.

---

### **3.2 Performance Metrics**

- **Metrics Displayed**:
    1. **Balance (USD)**:
        - Total available balance for the agency owner.
    2. **Total Coins**:
        - Cumulative coins earned by the agency in the current month.
    3. **Member Count**:
        - Total number of active members in the agency.
- **Design**:
    - Metrics are grouped and displayed prominently at the top of the page for quick access.

---

### **3.3 Management Options**

A vertical list of tools and sub-pages for managing agency operations. Each option includes:

- An icon for visual clarity.
- A title describing the function.
- A forward arrow indicating navigation.

---

### **Management Tools and Sub-Pages**

1. **Member Request**:
    - **Description**: View and process pending membership requests.
    - **Navigation**: Opens the **Member Requests Page**.
2. **Member Income**:
    - **Description**: Review detailed income reports for each member.
    - **Navigation**: Opens the **Members Income Page**.
3. **Member Invite**:
    - **Description**: Send and track invitations for new members.
    - **Navigation**: Opens the **Member Invite Page**.
4. **Member Active Days**:
    - **Description**: Track and validate active hours contributed by members.
    - **Navigation**: Opens the **Member Active Days Page**.
5. **Agency Data Query**:
    - **Description**: Access analytics and reports for agency performance.
    - **Navigation**: Opens the **Agency Data Query Page**.
6. **Salary Exchange Request**:
    - **Description**: Request salary conversion from coins to USD.
    - **Navigation**: Opens the **Salary Exchange Request Page**.
7. **Agency Leave Request**:
    - **Description**: Submit a request to resign as an agency owner.
    - **Navigation**: Opens the **Agency Leave Request Page**.

---

## **4. UI Design**

### **4.1 Layout**

1. **Header**:
    - Displays agency details prominently with back navigation.
2. **Performance Metrics**:
    - Positioned at the top for easy visibility.
3. **Management Options**:
    - Organized vertically for intuitive navigation.

---

### **4.2 Visual Design**

- **Colors**:
    - Consistent with the app’s branding.
    - Distinct color codes for metrics (e.g., balance, coins, members).
- **Icons**:
    - Unique icons for each management option.
- **Spacing**:
    - Generous padding between sections to ensure clarity.

---

### **4.3 Responsiveness**

- **Mobile**:
    - Single-column layout with stacked sections.
- **Desktop**:
    - Two-column layout where metrics appear alongside management options.

---

## **5. Backend Integration**

### **5.1 Data Retrieval**

- Fetch agency-specific details, including:
    - Agency name, ID, and profile picture.
    - Performance metrics (balance, total coins, member count).

### **5.2 Real-Time Updates**

- Automatically update metrics as:
    - Members contribute earnings.
    - Agency owners process requests or make withdrawals.

---

## **6. User Workflow**

1. **View Overview**:
    - Owners land on this page to see metrics and basic details.
2. **Navigate to Sub-Pages**:
    - Access detailed functionalities like member management or data queries.
3. **Monitor Updates**:
    - Metrics dynamically update in real-time as the agency operates.

---

## **7. Error Handling**

- **Data Loading Issues**:
    - Show a placeholder or cached data if metrics fail to load.
    - Display a message: "Unable to fetch data. Please try again later."
- **Navigation Failures**:
    - Redirect users to a fallback page with troubleshooting instructions.

---

## **8. Future Enhancements**

- Add visual analytics (e.g., graphs) for agency growth and performance trends.
- Enable multi-agency management for users handling multiple agencies.
- Provide notifications for critical updates, such as pending member requests or income milestones.

---

# **Agency Main Page: Sub Page: Member Management Page**

---

## **1. Overview**

The **Member Management Page** provides agency admins with tools to view, search, and manage their agency members effectively. It ensures real-time updates, detailed member insights, and a seamless interface for navigating large member lists.

---

## **2. Access**

- **Eligibility**:
    - Available exclusively to agency admins.
- **Navigation**:
    - Accessed via the **Member Count Button** on the **My Agency Page**.

---

## **3. Core Features**

### **3.1 Member Count Display**

- **Location**: Positioned at the top of the page.
- **Content**: Displays the current number of members and the agency’s total member capacity.
    - Example: `"4/54 Members"`.

---

### **3.2 Search Functionality**

- **Input Field**:
    - Allows admins to search members by:
        - **Nickname**.
        - **Unique ID**.
    - Real-time filtering dynamically displays matching results as the admin types.
- **Search Button**:
    - Executes a search query and displays precise results.

---

### **3.3 Member List**

- **Content**: A scrollable list of members with details for each entry:
    1. **Profile Picture**:
        - Displays the member’s avatar or image.
    2. **Name and ID**:
        - Highlights the member’s nickname and unique ID.
    3. **Monthly Income**:
        - Shows the total income generated by the member for the current month.
    4. **Join Date**:
        - Indicates the date the member joined the agency.
- **Dynamic Updates**:
    - The list updates automatically based on:
        - Search results.
        - Changes in member data or count.

---

## **4. UI/UX Design**

### **4.1 Layout**

1. **Header Section**:
    - Page title: `"Member Management"`.
    - **Back Button**:
        - Top-left navigation icon for returning to the **My Agency Page**.
2. **Search Bar**:
    - Positioned directly below the header.
    - Includes:
        - Text input field.
        - Search button.
3. **Member List**:
    - A vertical, scrollable layout displaying member rows.

---

### **4.2 Visual Design**

- **Color Scheme**:
    - Use the app’s branding colors for headers and buttons.
    - Highlight search results with a subtle background color.
- **Fonts & Icons**:
    - Follow app-standard fonts and include relevant icons for better clarity.
- **Spacing**:
    - Maintain consistent spacing between elements for readability.

---

### **4.3 Responsiveness**

- **Mobile**:
    - Single-column layout with vertically stacked rows for easy scrolling.
- **Desktop**:
    - Option for a grid layout to show multiple rows and columns for efficient use of space.

---

## **5. Backend Integration**

### **5.1 Data Fetching**

- **Initial Load**:
    - Fetches the complete list of current members from the server.
- **Pagination**:
    - Implements infinite scrolling or paginated requests for large datasets.

---

### **5.2 Search Functionality**

- **API Integration**:
    - Supports query-based filtering by:
        - Nickname.
        - Unique ID.
- **Response**:
    - Returns results dynamically as the admin types or executes a search query.

---

### **5.3 Member Details**

- **API Data**:
    - The member list includes:
        - Profile picture URL.
        - Nickname and unique ID.
        - Monthly income.
        - Join date.

---

## **6. Workflow**

1. **Navigation**:
    - Admin clicks the **Member Count Button** on the **My Agency Page**.
2. **Member Insights**:
    - The page loads with the current list of members and their details.
3. **Search**:
    - Admin uses the search bar to locate specific members.
4. **Updates**:
    - The list dynamically reflects:
        - Search results.
        - Changes in member count or data.

---

## **7. Error Handling**

### **7.1 Data Fetching Errors**

- **Issue**: Member data fails to load.
- **Solution**:
    - Display cached data if available.
    - Show an error message: `"Unable to load member data. Please try again later."`

### **7.2 Search Issues**

- **Issue**: No results match the search query.
- **Solution**:
    - Display a placeholder message: `"No members found matching your search criteria."`

---

## **8. Future Enhancements**

1. **Sorting Options**:
    - Add filters to sort by:
        - Income.
        - Join date.
        - Name or ID.
2. **Bulk Actions**:
    - Allow admins to:
        - Remove multiple members.
        - Send notifications to selected members.
3. **Activity Tracking**:
    - Include:
        - Online status.
        - Last login timestamp.

---

# **Agency Main Page: Sub Page: New Member Requests Page**

---

## **1. Overview**

The **New Member Requests Page** provides agency admins with tools to manage and respond to requests from users who wish to join their agency. The page ensures a seamless workflow for viewing, approving, or rejecting membership requests, with real-time updates and notifications.

---

## **2. Access**

- **Eligibility**:
    - Available exclusively to agency admins.
- **Navigation**:
    - Accessible via the **My Agency Page** under the "Member Request" option.

---

## **3. Core Features**

### **3.1 Request List**

- **Content**:
    - Displays all pending membership requests in a scrollable list.
- **Details per Request**:
    1. **Profile Picture**:
        - User’s avatar for easy identification.
    2. **Name and ID**:
        - The user’s display name and unique identifier.
    3. **Level or Badge**:
        - Indicates the user’s current level or most significant achievement badge.

---

### **3.2 Action Buttons**

- **Agree Button**:
    - Approves the user’s request and adds them to the agency.
    - Automatically updates the agency’s member count.
- **Reject Button**:
    - Declines the user’s request and removes it from the list.
    - **Future Option**: Allow admins to include a rejection reason.

---

### **3.3 Dynamic Updates**

- **Real-Time Refresh**:
    - When an action is performed (Agree/Reject), the list dynamically updates.
- **Notifications**:
    - Users are informed of the decision via:
        - **Push Notifications**.
        - **Notifications Page** under "System Alerts."

---

## **4. UI/UX Design**

### **4.1 Layout**

1. **Header**:
    - Page title: `"Member Requests"`.
    - **Back Button**:
        - Top-left navigation icon for returning to the **My Agency Page**.
2. **Request List**:
    - A vertical, scrollable layout displaying pending requests.
3. **Action Buttons**:
    - "Agree" (green) and "Reject" (red) buttons are positioned to the right of each request.

---

### **4.2 Visual Design**

- **Color Scheme**:
    - Branding-aligned colors for buttons and headers.
    - Action buttons use distinct colors for clarity:
        - Green for "Agree."
        - Red for "Reject."
- **Fonts & Icons**:
    - Standard app fonts and icons for a consistent experience.
- **Spacing**:
    - Adequate padding between requests for better readability.

---

### **4.3 Responsiveness**

- **Mobile**:
    - Single-column layout with vertically stacked request items.
- **Desktop**:
    - Multi-column grid layout to display multiple requests side-by-side.

---

## **5. Backend Integration**

### **5.1 Data Fetching**

- **API Endpoint**:
    - Retrieves all pending membership requests.
- **Pagination**:
    - Supports infinite scrolling or paginated requests for handling large datasets.

---

### **5.2 Actions**

1. **Approve Request**:
    - **API Endpoint**: Sends a request to approve the user.
    - **Behavior**:
        - Adds the user to the agency member list.
        - Increases the agency’s member count.
2. **Reject Request**:
    - **API Endpoint**: Sends a request to reject the user.
    - **Behavior**:
        - Removes the user from the pending list.
        - Does not affect the agency’s member count.

---

### **5.3 Notifications**

- **Approval**:
    - `"Your request to join [Agency Name] has been approved."`
- **Rejection**:
    - `"Your request to join [Agency Name] was not approved."`

---

## **6. Workflow**

1. **User Request Submission**:
    - A user submits a join request via the **Agencies Public View Page**.
2. **Request Review**:
    - The request appears on the **Member Requests Page** for the agency admin.
3. **Admin Actions**:
    - The admin either:
        - **Approves** the request using the "Agree" button.
        - **Rejects** the request using the "Reject" button.
4. **Real-Time Updates**:
    - The page dynamically reflects the admin’s action, removing the processed request from the list.
5. **User Notification**:
    - The requesting user receives a notification about the admin’s decision.

---

## **7. Error Handling**

### **7.1 API Errors**

- **Issue**: Failure to load requests or process actions.
- **Solution**:
    - Display an error message:
        - `"Unable to load requests. Please try again later."`
        - `"Failed to process the request. Please refresh and try again."`

### **7.2 Empty List**

- **Issue**: No pending requests.
- **Solution**:
    - Show a placeholder message:
        - `"No pending requests at this time."`

---

## **8. Future Enhancements**

1. **Rejection Reasons**:
    - Allow admins to provide specific reasons when rejecting requests.
2. **Bulk Actions**:
    - Enable batch processing for approving or rejecting multiple requests simultaneously.
3. **Filters**:
    - Add filtering options (e.g., by date, user level, or badges).
4. **Request Notifications**:
    - Notify admins of new membership requests in real time.

---

# **Agency Main Page: Sub Page: Members Income Page**

---

## **1. Overview**

The **Members Income Page** provides agency owners with a comprehensive view of their members' earnings for each month, including coin totals, estimated salaries, and the agency's share. This page serves as a critical tool for income tracking and performance analysis.

---

## **2. Access**

- **Eligibility**: Available exclusively to agency owners.
- **Navigation**:
    - Accessed via the **My Agency Page** by selecting the **"Member Income"** option.

---

## **3. Core Features**

### **3.1 Month Selector**

- **Purpose**:
    - Allows users to view income data for any specific month.
- **Behavior**:
    - Defaults to the current month upon page load.
    - Users can select previous months using a dropdown.
- **Dynamic Updates**:
    - Switching months automatically refreshes all displayed metrics and data.

---

### **3.2 Summary Section**

Displays key metrics for the selected month:

1. **Monthly Coins**:
    - Total coins earned by all agency members.
2. **Estimated Salary**:
    - USD equivalent of the total coins earned.
3. **Salary in Advance**:
    - The amount already advanced to the agency or members.
4. **Balance**:
    - The remaining salary (after deductions).

---

### **3.3 Income Breakdown Table**

- **Columns**:
    - **Host**:
        - Displays the member’s name, profile picture, and unique ID.
    - **Total Coins**:
        - Total coins earned by the member during the selected month.
    - **Agency Share (ASP)**:
        - Dollar equivalent of the agency’s earnings from the member’s income.
        - Calculated based on the **Agency Share Percentage (ASP)**.

---

### **3.4 Real-Time Updates**

- **Triggers**:
    - Changes to ASP or salary advances update all metrics and the income table dynamically.
    - Data refreshes when a different month is selected.

---

## **4. UI Design Guidelines**

### **4.1 Layout**

1. **Header**:
    - Page title: `"Members Income"`.
    - Back navigation button and month selector dropdown.
2. **Summary Section**:
    - Positioned at the top for quick visibility.
    - Highlights monthly totals and balances.
3. **Income Breakdown Table**:
    - Scrollable table for detailed income data of all members.

---

### **4.2 Visual Design**

- **Colors**:
    - Use branding colors for headers and highlights.
    - Differentiate columns with soft background shading.
- **Icons**:
    - Use icons for currencies and profile images to enhance readability.
- **Spacing**:
    - Maintain clear spacing between sections for a clean interface.

---

### **4.3 Responsiveness**

- **Mobile**:
    - Stacked layout with scrollable tables.
- **Desktop**:
    - Side-by-side or multi-column layout for displaying more data.

---

## **5. Backend Integration**

### **5.1 Data Fetching**

- **API Requests**:
    - Retrieves income data for the selected month.
    - Fetches ASP and advance details.

---

### **5.2 ASP and Agency Share**

- **Logic**:
    - **Agency Share** = `Member Coins × ASP`
    - Example: If ASP is 2% and the member earned 10,000 coins, the agency share = **200 coins**.

---

### **5.3 Updates and Adjustments**

- Real-time changes for:
    - Month selection.
    - ASP modifications.
    - Salary advance deductions.

---

## **6. Workflow**

1. **Select Month**:
    - Users select a month to view corresponding data.
2. **Review Summary**:
    - Agency owners see overall metrics for coins earned, salary, advances, and balance.
3. **Analyze Member Income**:
    - Check individual member performance and contributions.
4. **Adjust Settings**:
    - Modify ASP or advance amounts as needed (if permitted).

---

## **7. Error Handling**

### **7.1 API Errors**

- **Issue**: Data fails to load.
- **Solution**:
    - Display error: `"Unable to fetch income data. Please try again later."`

### **7.2 Empty Data**

- **Issue**: No income data available for the selected month.
- **Solution**:
    - Show placeholder message: `"No income data available for this period."`

---

## **8. Future Enhancements**

1. **Filters and Sorting**:
    - Add options to sort members by income, agency share, or name.
2. **Reporting Tools**:
    - Allow export of data as PDF or CSV reports.
3. **Visualizations**:
    - Introduce graphs or charts for agency income trends.
4. **Notifications**:
    - Notify agency owners of high-performing members or milestones.