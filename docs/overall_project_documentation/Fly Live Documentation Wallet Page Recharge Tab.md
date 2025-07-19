# Fly Live Documentation: Wallet Page: Recharge Tab

---

## **1. Overview**

The Wallet Recharge Tab serves as the default interface for users to purchase coins using real money. It provides a streamlined and secure experience for topping up coin balances through predefined packages tailored to the user’s location and currency.

---

## **2. Key UI Elements**

### **2.1 Header Section**

1. **Page Title**: Displays "Wallet" prominently.
2. **Navigation Buttons**:
    - **Back Arrow**: Navigates to the previous page.

### **2.2 Balance Display**

- **Current Coin Balance**:
    - Showcases the user’s current coin balance with:
        - A large coin icon for emphasis.
        - Real-time updates after successful recharges.

### **2.3 Recharge Options**

- **Recharge Packages**:
    - Displays a dynamic list of available packages.
    - Example: **"1700 coins for $0.99"**.
    - Each package includes:
        - Coin quantity.
        - Price in the user’s local currency.
        - A **Purchase Button** to initiate the transaction.

### **2.4 Action Buttons**

1. **Purchase Button**:
    - Styled, interactive button to confirm and process the recharge.
2. **Billing History Icon**:
    - Navigates to the **Billing History Page** for transaction records.

### **2.5 Loader/Spinner**

- A visual loader displayed:
    - When fetching recharge options.
    - During the purchase process.

---

## **3. Functional Requirements**

### **3.1 Recharge Functionality**

- Users can:
    - Select a package and confirm payment.
    - Purchase coins securely through integrated payment gateways.

### **3.2 Dynamic Package Updates**

- Recharge packages are fetched from the server based on:
    - User location.
    - Applicable local currency.

### **3.3 Real-Time Balance Updates**

- The coin balance updates immediately after:
    - Payment confirmation.
    - Successful coin allocation.

### **3.4 Billing History Navigation**

- Clicking the **Billing History Icon** redirects to a page displaying:
    - Recharge transaction history.
    - Date, amount, and coin details.

### **3.5 Fallback Mechanism**

- In case of errors fetching recharge options:
    - Display a friendly message: **"Unable to fetch recharge packages. Please try again later."**

---

## **4. Database Configurations**

### **4.1 Tables Involved**

1. **Users Table**:
    - Fields:
        - `id`: User identifier.
        - `coin_balance`: Current coin balance.
        - `updated_at`: Timestamp of the last update.
2. **Recharge Packages Table**:
    - Fields:
        - `id`: Package identifier.
        - `coins`: Number of coins provided.
        - `price`: Cost of the package.
        - `currency`: Local currency (e.g., USD, EUR).
        - `is_active`: Indicates availability.
3. **Transactions Table**:
    - Fields:
        - `id`: Transaction identifier.
        - `user_id`: User linked to the transaction.
        - `transaction_type`: Type (`recharge`).
        - `coins_purchased`: Number of coins bought.
        - `price_paid`: Cost of the transaction.
        - `currency`: Currency used.
        - `created_at`: Timestamp of the transaction.

### **4.2 Validation**

- Ensure:
    - Coins are atomically added to the user’s balance.
    - Selected packages are active before processing.

---

## **5. Error Handling**

### **5.1 Payment Failure**

- **Issue**: Transaction not processed by the payment gateway.
- **Solution**: Display an error:
    - **"Payment failed. Please try again."**

### **5.2 Package Unavailability**

- **Issue**: User selects an inactive or unavailable package.
- **Solution**: Display a message:
    - **"This package is no longer available. Please select another."**

### **5.3 Network Issues**

- **Issue**: Packages fail to load or purchase is interrupted.
- **Solution**: Display a retry option:
    - **"Unable to load packages. Tap to retry."**

---

## **6. Navigation Flow**

### **6.1 Default Tab**

- The Wallet Recharge Tab is displayed by default when accessing the Wallet Page.

### **6.2 Purchase Flow**

1. Select a package.
2. Confirm purchase.
3. Process payment through the gateway.
4. Update coin balance upon success.

### **6.3 Billing History Navigation**

- Clicking the **Billing History Icon** navigates to the **Billing History Page**, where users can view:
    - Recharge dates.
    - Amounts paid.
    - Coin quantities received.

---

# **Wealth Page: Recharge Tab Sub Page: Billing History Page**

---

## **1. Overview**

The Billing History Page provides users with a comprehensive log of their transactions, including coin recharges, gift spending, gift income, and other activities. With categorized tabs, real-time updates, and infinite scrolling, it ensures users can easily track and manage their coin-related activities.

---

## **2. Key UI Elements**

### **2.1 Header Section**

1. **Page Title**: Displays **"Billing Details"** prominently.
2. **Navigation Buttons**:
    - **Back Arrow**: Navigates to the previous page.
    - **Calendar Icon**: Opens a date picker for filtering transactions by specific dates.

### **2.2 Tabs for Billing Categories**

- **Gift Income**: Lists transactions where coins were received from gifts.
- **Spending Gifts**: Logs transactions for coins spent on gifts.
- **Recharge Records**: Displays all coin recharge transactions.
- **Lucky Coin Records**: Tracks rewards or bonuses from lucky features.

### **2.3 Transaction List**

Each entry includes:

1. **Transaction Type**:
    - Displays the transaction category (e.g., "Recharge," "Gift Income").
    - Includes an icon for quick visual identification.
2. **Benefactor Information**:
    - Displays the name of the benefactor or user associated with the transaction.
3. **Coins Gained/Spent**:
    - Indicates the amount of coins gained (`+`) or spent (``).
4. **Timestamp**:
    - Displays the date and time of the transaction in a readable format.
5. **Coin Balances**:
    - Shows **coins before** and **coins after** the transaction for transparency.

### **2.4 Infinite Scroll Loader**

- A spinner or loading animation appears at the bottom while fetching additional transactions.

---

## **3. Functional Requirements**

### **3.1 Infinite Scrolling**

- Automatically fetches more transactions as the user scrolls.
- Retains previously loaded data for seamless navigation.
- Displays a loading animation during data retrieval.

### **3.2 Data Presentation**

Each transaction entry must display:

1. Transaction type.
2. Benefactor name (if applicable).
3. Coins gained or spent.
4. Coin balance before and after the transaction.
5. Timestamp of the transaction.

### **3.3 Filtering and Sorting**

1. **Date Filter**:
    - Accessed via the **Calendar Icon**.
    - Allows users to filter transactions by specific date ranges.
2. **Category Tabs**:
    - Dynamically load and display content relevant to the selected tab.

### **3.4 Fallback Mechanism**

- If transaction data cannot be retrieved:
    - Show a cached version with an error message: **"Unable to fetch recent transactions. Please try again later."**
    - Provide a **Retry Button** for manual refresh.

---

## **4. Database Configurations**

### **4.1 Tables Involved**

1. **Transactions Table**:
    - Tracks all user transactions.
    - Fields:
        - `id`: Unique identifier.
        - `user_id`: User linked to the transaction.
        - `transaction_type`: Recharge, Gift Income, Spending, etc.
        - `benefactor`: Name or ID of the associated user (if applicable).
        - `coins_gained`: Coins added to the user’s account.
        - `coins_spent`: Coins deducted from the user’s account.
        - `coins_before`: Coin balance before the transaction.
        - `coins_after`: Coin balance after the transaction.
        - `created_at`: Timestamp of the transaction.
2. **Users Table**:
    - Tracks the user’s current coin balance.
    - Fields:
        - `id`: User identifier.
        - `coin_balance`: Current coin balance.
        - `updated_at`: Timestamp of the last update.

### **4.2 Relationships**

- **Users Table → Transactions Table**:
    - One-to-Many relationship for tracking user transactions.

---

## **5. Error Handling**

### **5.1 Infinite Scrolling Errors**

- **Issue**: Data fails to load while scrolling.
- **Solution**: Display a message: **"Unable to load more transactions. Pull down to retry."**

### **5.2 Empty Transaction List**

- **Issue**: No transactions available for the selected filter.
- **Solution**: Show a placeholder message: **"No transactions available for this period."**

### **5.3 Data Inconsistencies**

- **Issue**: Coin balances (`coins_before`, `coins_after`) do not match.
- **Solution**: Validate and log backend calculations. Display an alert if inconsistencies are detected.

---

## **6. Navigation Flow**

1. **Back Navigation**:
    - Clicking the **Back Arrow** returns to the Wallet Recharge Tab.
2. **Tab Navigation**:
    - Switching between tabs dynamically loads the respective transaction data.
3. **Infinite Scrolling**:
    - Fetches additional transactions as the user scrolls to the bottom.

---

## **7. Future Enhancements**

1. **Advanced Filtering Options**:
    - Add filters for transaction amounts, benefactors, and coin types.
2. **Export Feature**:
    - Allow users to export transaction histories as CSV or PDF files.
3. **Notifications**:
    - Notify users of high-value transactions (e.g., large recharges or gifts).
4. **Transaction Insights**:
    - Provide analytics, such as total spending by category over time.

---

# **Wallet Page: Exchange Tab: Diamonds Exchange Tab**

---

## **1. Overview**

The Diamonds Exchange Tab allows users affiliated with an agency to convert their diamonds into coins seamlessly. This feature ensures transparency, ease of use, and real-time updates, empowering users to manage their virtual assets effectively.

**Note**: This page is exclusively accessible to users who are current or former members of an agency.

---

## **2. Key UI Elements**

### **2.1 Header Section**

1. **Tabs**:
    - **Recharge Tab**: For recharging coin balances.
    - **Exchange Tab**: Active tab for diamond-to-coin conversions.
2. **Navigation Buttons**:
    - **Back Arrow**: Returns to the previous page.
    - **Diamond Billing History Icon**: Redirects to:
        - **Diamond Exchange History**.
        - **Incoming Diamonds History**.

### **2.2 Balances**

1. **Diamond Balance**:
    - Displays the user’s current diamond balance prominently.
2. **Coin Balance After Exchange**:
    - Reflects the user’s updated coin balance post-conversion.

### **2.3 Exchange Input Fields**

1. **Diamonds to Convert**:
    - Input field for specifying the number of diamonds to exchange.
    - Dynamically updates the following:
        - **Diamond Balance After Exchange**.
        - **Coin Balance After Exchange**.
2. **Coin Balance After Exchange**:
    - Shows the calculated coin balance after conversion.

### **2.4 Exchange Rate Display**

- Clearly states the current conversion rate: **"1 Diamond = 1 Coin"**.
- Rates are configurable and can be dynamically updated by the admin.

### **2.5 Action Button**

- **Exchange Button**:
    - Initiates the diamond-to-coin conversion.
    - Styled for visibility and disabled until the input is valid.

---

## **3. Functional Requirements**

### **3.1 Conversion Mechanics**

- Users can exchange diamonds for coins at a configurable rate.
- Validation ensures users cannot convert more diamonds than their balance allows.

### **3.2 Real-Time Balance Updates**

- As users input the diamond amount:
    - **Diamond Balance After Exchange** and **Coin Balance After Exchange** update dynamically.

### **3.3 Confirmation Process**

- Upon initiating the exchange:
    - A confirmation displays transaction details:
        - Diamonds converted.
        - Updated diamond and coin balances.

### **3.4 History Navigation**

- Clicking the **Diamond Billing History Icon** navigates to:
    - **Diamond Exchange History**: Logs past exchange transactions.
    - **Incoming Diamonds History**: Displays received diamond transactions.

### **3.5 Fallback Mechanism**

- If the exchange process fails:
    - Any partial changes are reverted.
    - An error message is displayed to the user.

---

## **4. Database Configurations**

### **4.1 Tables Involved**

1. **Users Table**:
    - Tracks current diamond and coin balances.
    - Fields:
        - `id`: User identifier.
        - `diamond_balance`: Current diamonds.
        - `coin_balance`: Current coins.
        - `updated_at`: Timestamp of the last update.
2. **Transactions Table**:
    - Logs all exchange transactions.
    - Fields:
        - `id`: Transaction identifier.
        - `user_id`: User linked to the transaction.
        - `transaction_type`: Set to `exchange`.
        - `diamonds_used`: Diamonds converted.
        - `coins_received`: Coins added to balance.
        - `created_at`: Timestamp of the transaction.

### **4.2 Validation**

- Ensure sufficient diamond balance before processing.
- Maintain atomicity to prevent inconsistencies during concurrent exchanges.

---

## **5. Error Handling**

### **5.1 Insufficient Diamonds**

- **Issue**: User tries to exchange more diamonds than they own.
- **Solution**:
    - Display: **"Insufficient diamonds. Please adjust the exchange amount."**

### **5.2 Exchange Failure**

- **Issue**: API or server failure interrupts the exchange.
- **Solution**:
    - Roll back any changes.
    - Display: **"Exchange failed. Please try again later."**

### **5.3 Invalid Input**

- **Issue**: User enters an invalid value (e.g., negative, non-numeric).
- **Solution**:
    - Disable the **Exchange Button**.
    - Display a tooltip: **"Please enter a valid number."**

---

## **6. Navigation Flow**

### **6.1 Back Navigation**

- Clicking the **Back Arrow** returns to the previous page.

### **6.2 Exchange Flow**

1. Input the desired diamond amount.
2. View dynamic updates to diamond and coin balances.
3. Confirm the exchange and receive updated balances.

### **6.3 History Navigation**

- Clicking the **Diamond Billing History Icon** redirects to:
    - **Diamond Exchange History**.
    - **Incoming Diamonds History**.

---

## **7. Future Enhancements**

### **7.1 Flexible Exchange Rates**

- Allow admins to dynamically adjust rates based on events or user tiers.

### **7.2 Enhanced Exchange History**

- Include an **Exchange History Tab** within the page for convenience.

### **7.3 Multi-Currency Support**

- Enable exchanges between other in-app virtual assets.

---

# **Wealth Page: Exchange Tab Sub Page: Diamonds Exchange & Incoming Billing History Page**

---

## **1. Overview**

The **Diamonds Exchange Billing History Page** provides users with a comprehensive log of all diamond-to-coin exchanges. Transactions are organized by date, showing key details such as diamonds exchanged, coins received, and timestamps. This page ensures transparency and accessibility, enabling users to track their financial activities seamlessly.

---

## **2. Key UI Elements**

### **2.1 Header Section**

1. **Page Title**: Displays **"Exchange"** prominently.
2. **Navigation Buttons**:
    - **Back Arrow**: Returns to the previous page.
    - **Calendar Icon**: Opens a date picker for filtering transactions by specific dates.

### **2.2 Transaction List**

Each entry includes:

1. **Date Grouping**:
    - Transactions are grouped by date (e.g., **"2025-01-19"**) for improved clarity.
2. **Transaction Details**:
    - **Type**: Labeled as **"Exchange"** for consistency.
    - **Diamonds Exchanged**:
        - Displays the number of diamonds used (e.g., **"-60 Diamonds"**).
        - Icon: Diamond symbol for visual emphasis.
    - **Coins Received**:
        - Displays the number of coins credited (e.g., **"+60 Coins"**).
        - Icon: Coin symbol for easy recognition.
    - **Timestamp**:
        - Shows the precise time of the transaction (e.g., **"2025-01-19 14:35:00"**).

### **2.3 Infinite Scroll Loader**

- Automatically fetches and loads additional transaction entries as users scroll down the page.
- Displays a spinner or loading animation while fetching data.

---

## **3. Functional Requirements**

### **3.1 Data Presentation**

- Each transaction entry must include:
    - Transaction type (e.g., "Exchange").
    - Diamonds exchanged.
    - Coins received.
    - Timestamp of the transaction.

### **3.2 Filters and Sorting**

1. **Date Filter**:
    - Accessed via the **Calendar Icon**.
    - Enables filtering transactions by specific date ranges.
2. **Infinite Scrolling**:
    - Loads and displays additional transaction entries as users scroll.

### **3.3 Real-Time Updates**

- Newly completed exchanges should appear on the page without requiring a refresh.
- Provide a manual refresh button to retrieve the latest data if needed.

### **3.4 Fallback Mechanism**

- If data retrieval fails:
    - Display cached transaction records (if available).
    - Show an error message: **"Unable to fetch records. Please try again later."**

---

## **4. Database Configurations**

### **4.1 Tables Involved**

1. **Transactions Table**:
    - Logs all exchange transactions.
    - Fields:
        - `id`: Unique transaction identifier.
        - `user_id`: User linked to the transaction.
        - `transaction_type`: Set to **"exchange"**.
        - `diamonds_used`: Diamonds converted.
        - `coins_received`: Coins credited.
        - `created_at`: Timestamp of the transaction.
2. **Users Table**:
    - Tracks user balances.
    - Fields:
        - `id`: User identifier.
        - `diamond_balance`: Current diamond balance.
        - `coin_balance`: Current coin balance.
        - `updated_at`: Timestamp of the last update.

### **4.2 Validation**

- Validate that:
    - **`diamonds_used`** and **`coins_received`** align with the configured exchange rate.
    - Duplicate transactions are prevented using unique transaction IDs.

---

## **5. Error Handling**

### **5.1 Data Fetch Failure**

- **Issue**: Unable to retrieve transaction history due to server or network issues.
- **Solution**:
    - Display cached records if available.
    - Show an error message: **"Unable to fetch records. Please try again later."**

### **5.2 Empty History**

- **Issue**: User has no exchange transactions on record.
- **Solution**:
    - Display a placeholder message: **"No exchange history available."**

---

## **6. Navigation Flow**

### **6.1 Back Navigation**

- Clicking the **Back Arrow** returns users to the previous page.

### **6.2 Calendar Filter**

- Clicking the **Calendar Icon** opens a date picker.
- Users can select specific date ranges to filter transactions.

### **6.3 Scroll Navigation**

- Infinite scrolling automatically fetches and appends additional transactions as users scroll.

---

## **7. Future Enhancements**

### **7.1 Export Option**

- Allow users to export their exchange history in formats like **CSV** or **PDF**.

### **7.2 Detailed Transaction Insights**

- Include additional details such as:
    - Exchange rate applied.
    - User roles during transactions (e.g., agency member status).

### **7.3 Search Functionality**

- Enable keyword-based searches to quickly locate specific transactions.