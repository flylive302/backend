# Fly Live Documentation: My Income Page

---

## **1. Overview**

The **My Income Page** provides agency members with a detailed view of their monthly earnings, progress toward coin targets, and tools for converting surplus salary into in-app coins. It ensures transparency and ease of use for tracking and managing income.

---

## **2. Page Access**

- **Eligibility**: Available only to users who are members of an agency.
- **Navigation**: Accessible via the **Personal Profile Page** under the **"My Income"** link.

---

## **3. Core Features**

### **3.1 Monthly Earnings Summary**

- **Monthly Total Salary**: Displays the user’s total earnings in USD for the current month.
- **Surplus Salary**: Shows the remaining salary available for coin conversion.
- **Exchanged Amount**: Displays the total amount converted to coins within the month.

---

### **3.2 Coin Target Progress**

- Tracks user progress against three predefined monthly coin targets:
    1. **10,000 coins** → $10 reward.
    2. **20,000 coins** → $20 reward.
    3. **30,000 coins** → $30 reward.
- **Reward Mechanics**:
    - Achieved targets add their rewards to the **Monthly Total Salary**.
    - Excess coins from unachieved targets are transferred to the diamond wallet at the end of the month, multiplied by the **Income Excess Coins Percentage (IECP)**.

---

### **3.3 Dollar-to-Coin Conversion**

- **Input Field**: Allows users to specify the amount of surplus salary to exchange for coins.
- **Conversion Rate**: Displays the admin-configured exchange rate (e.g., $1 = 100 coins).
- **Equivalent Coin Display**: Dynamically updates to show the coin amount based on the entered dollar value.
- **Exchange Button**:
    - Processes the exchange.
    - Updates the **Surplus Salary** and **Exchanged Amount** upon success.

---

### **3.4 Income Breakdown Table**

- Details daily income activity with the following columns:
    - **Date**: Displays the specific day.
    - **Duration (Time Worked)**: Total hours spent occupying a mic seat in a room.
    - **Coins Earned**: Total coins received as gift income for the day.
    - **Valid Hours**: Total hours counted toward the monthly target, capped at admin-defined limits (e.g., 5 hours/day).

---

## **4. UI Design**

### **4.1 Layout**

1. **Header**:
    - Includes the page title ("My Income") and a back navigation button.
2. **Earnings Summary**:
    - Positioned prominently at the top.
    - Displays the monthly salary, surplus salary, and exchanged amount.
3. **Coin Target Section**:
    - Progress bars for the three monthly coin targets.
    - Highlights achieved targets with rewards displayed.
4. **Conversion Section**:
    - Input field and exchange details, with the "Exchange" button prominently displayed.
5. **Income Breakdown Table**:
    - Scrollable layout with clear headings for daily income details.

---

### **4.2 Visual Design**

- **Color Scheme**:
    - Use branded colors to differentiate sections (e.g., earnings, targets, conversions).
    - Highlight achieved targets with a distinct accent color.
- **Icons and Fonts**:
    - Use app-standard fonts and icons for clarity and consistency.
- **Spacing**:
    - Maintain adequate padding between sections for improved readability.

---

### **4.3 Responsiveness**

- **Mobile**:
    - Stacked vertical layout with a scrollable table.
- **Desktop**:
    - Multi-column layout to display summary and target progress side by side.

---

## **5. Backend Integration**

### **5.1 Data Fetching**

- Fetches:
    - Current month’s total earnings.
    - Surplus salary and exchanged amount.
    - Daily income breakdown.
    - Monthly coin targets and progress.

### **5.2 Dollar-to-Coin Conversion**

- **Process**:
    - Deducts the entered dollar amount from **Surplus Salary**.
    - Adds the equivalent coin amount to the user’s in-app coin balance.

### **5.3 End-of-Month Reset**

- Handles:
    - Transfer of unachieved coins to the diamond wallet using the **IECP**.
    - Resetting monthly progress for the new cycle.

---

## **6. Workflow**

### **6.1 Monthly Workflow**

1. **Start of Month**:
    - Reset all earnings metrics and coin targets.
2. **During the Month**:
    - Track progress toward targets and log daily income.
    - Allow surplus salary to be exchanged for coins.
3. **End of Month**:
    - Transfer unachieved coins to the diamond wallet.
    - Reset all metrics and carry over rewards to the next month.

---

## **7. Error Handling**

### **7.1 Conversion Errors**

- **Scenario**: User enters a value exceeding the surplus salary.
    - **Solution**: Display error: `"Insufficient surplus salary available."`
- **Scenario**: API failure during conversion.
    - **Solution**: Display error: `"Conversion failed. Please try again later."`

### **7.2 Target Calculation Errors**

- **Scenario**: Incorrect coin target progress.
    - **Solution**: Automatically recalculate on data refresh or API sync.

### **7.3 Data Fetch Errors**

- **Scenario**: API failure fetching income details.
    - **Solution**: Display cached data with a message: `"Unable to fetch data. Displaying last known values."`

---

## **8. Future Enhancements**

1. **Visualization Tools**:
    - Add graphs or charts to display monthly earnings trends.
2. **Custom Targets**:
    - Enable users to set their own monthly coin targets.
3. **Transaction History**:
    - Include a detailed breakdown of conversions and earnings in a separate tab.
4. **Automated Notifications**:
    - Notify users of target achievements and pending surplus salary at the month’s end.