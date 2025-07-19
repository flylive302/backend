# Fly Live Documentation: Authentication System

# Fly Live Documentation: Register Page

## **1. Purpose**

- Enable new users to register securely and seamlessly by providing key details.
- Ensure a user-friendly experience with real-time validation and automated geolocation detection.
- Guarantee account security with robust password requirements, unique identifiers, and optional two-factor authentication (2FA).
- Collect device-related data post-registration to improve security and analytics.
- Built with **Laravel Jetstream (API Mode)** for scalability and modularity.

---

## **2. UI/UX Design**

### **Key Components**

1. **Profile Picture Upload**:
    - Optional field.
    - Placeholder image generated via [https://ui-avatars.com](https://ui-avatars.com/api/?background=random) if not provided.
2. **Full Name Field**:
    - Required (3-50 characters).
3. **Signature (Username) Field**:
    - Acts as a unique identifier.
    - Real-time availability check.
4. **Date of Birth Field**:
    - Dropdown selection.
    - Users must be 18 years or older.
5. **Country Field**:
    - Auto-detected via **ipstack**.
    - Manual fallback for geolocation denial.
6. **Phone Number Field**:
    - Required and validated per country with **Laravel Phone**.
    - Stored in E.164 format.
7. **Password Field**:
    - Secure input with strength validation (6-20 characters, uppercase, lowercase, numbers, special characters).
8. **Register Button**:
    - Bright, prominent button.
    - Activated upon successful validation.
9. **Login Now Link**:
    - Redirects to the Login Page.
10. **Forgot Password Link**:
    - Redirects to the Forgot Password Page.

---

## **3. Functional Requirements**

### **Validation Rules**

1. **Mandatory Fields**:
    - Full Name, Signature, Date of Birth, Country, Phone Number, Password.
2. **Profile Picture**:
    - Placeholder used if not uploaded.
3. **Specific Validations**:
    - Full Name: 3-50 valid characters.
    - Signature: Unique across the system.
    - Date of Birth: Minimum age of 18 years.
    - Phone Number: Unique and validated against country code (E.164 format).
    - Password: Must meet length and strength requirements.

### **Behavior**

1. Real-time validation feedback for each field.
2. Redirects to the authenticated **Home Page** upon successful registration.
3. Logs device-related data (e.g., device type, browser details, IP address) for security.
4. Initiates the 2FA setup flow if enabled.

---

## **4. Backend Integration**

- Registration logic is built with **Laravel Jetstream (API Mode)** and integrates **Sanctum** for token-based authentication.
- Post-registration actions include:
    1. Redirecting users to the authenticated **Home Page**.
    2. Logging device-related data (e.g., device type, IP address, geolocation).
    3. Triggering security notifications for unrecognized devices.
    4. Prompting 2FA setup for eligible accounts.

---

## **5. Database Reference**

The `users` table stores user information during registration. This table includes fields such as:

- `full_name`
- `signature`
- `dob`
- `phone_e164`
- `password`

For a detailed schema and relationships, see the **Fly Live Documentation: Database Design**.

---

## **6. Notifications**

### **Push Notifications**

- Sent to the device used during registration.

### **Unrecognized Device Alerts**

- Triggered if the user logs in from a new device.

### **2FA Notifications**

- Prompts for setup and recovery codes.

---

## **7. Security Considerations**

1. **Token Security**:
    - Tokens are issued using **Laravel Sanctum**.
2. **Data Encryption**:
    - Passwords are hashed with bcrypt.
    - Sensitive data (e.g., phone numbers, 2FA secrets) is encrypted.
3. **Route Protection**:
    - Registration routes are public.
    - Authenticated routes are Sanctum-protected.
4. **Device Logging**:
    - Logs device details post-registration for added security.
5. **Two-Factor Authentication (2FA)**:
    - Provides an additional layer of login security.

---

## **8. Testing Criteria**

1. **Validation Tests**:
    - Ensure fields meet the specified requirements.
    - Verify error handling for missing fields or invalid formats.
2. **Fallback Scenarios**:
    - Geolocation denied.
    - Missing profile picture.
    - Signature already taken.
3. **Device Data Logging**:
    - Validate correct logging of device type, IP address, and geolocation.
4. **Notifications**:
    - Verify registration and unrecognized device notifications.
5. **2FA Setup Flow**:
    - Ensure smooth setup and recovery codes functionality.

---

# **Fly Live Documentation: Login Page**

---

## **1. Purpose**

- Allow users to authenticate using their phone number and password (manual login) or third-party providers (Google, Facebook).
- Ensure secure and seamless user validation while maintaining a high-quality user experience.
- Redirect authenticated users to the **Home Page** upon successful login.
- For first-time social login users, defer profile completion (e.g., missing DOB, Country) to the **Home Page** via a popup.

---

## **2. UI/UX Design**

### **Key Components**

1. **Logo**:
    - Positioned at the top-center.
    - Displays the "Fly-Live" logo with a golden dollar sign and wings.
2. **Social Login Buttons**:
    - Google (red button) and Facebook (blue button).
    - Uses email exclusively for authentication.
3. **Phone Number Field**:
    - Includes a country code dropdown:
        - Auto-detects location using **ipstack** and pre-selects the country.
        - Users can manually override the selection.
    - Validates phone numbers dynamically using **Laravel Phone**.
    - Displays validation feedback (red border for invalid input, green border for valid input).
4. **Password Field**:
    - Secure input with hidden characters.
    - Validates length (6-20 characters).
5. **Links**:
    - **Register Now**: Redirects to the Register Page.
    - **Forgot Password**: Redirects to the Forgot Password Page.
    - Positioned below the password field.
6. **Login Button**:
    - Bright pink button labeled "Login."
    - Activates only when all inputs are valid.

### **User Feedback**

- Validation errors (e.g., invalid inputs) are displayed with a red border and error message.
- Successful validation shows a green border.

---

## **3. Functional Requirements**

### **Validation Rules**

1. **Phone Number**:
    - Dynamically validated using **Laravel Phone**.
    - Must match a valid, registered phone number in the database.
2. **Password**:
    - Required, with a length of 6-20 characters.

### **Behavior**

1. **Login Button**:
    - Submits the form only when inputs pass validation.
2. **Social Login**:
    - Redirects users to the Home Page after successful authentication.
    - Does not require phone number validation but ensures the account is active.
3. **Links**:
    - **Register Now**: Redirects to the Register Page.
    - **Forgot Password**: Redirects to the Forgot Password Page.

---

## **4. Backend Integration**

- **Session Tokens**:
    - Tokens are generated using **Laravel Sanctum** and returned to the frontend for storage in localStorage or cookies.
- **First-Time Social Logins**:
    - Flags accounts missing critical fields like DOB, Country, and Signature.
    - Redirects to the Home Page for profile completion via a popup.

---

## **5. Processes Delegated to the Home Page**

1. **Device-Related Data Logging**:
    - Logs IP address, device type, and geolocation.
    - Flags unrecognized devices for security.
2. **First-Time Profile Completion**:
    - Displays a popup prompting users to complete missing fields (e.g., DOB, Country).

---

## **6. Notifications**

1. **Login Success Notification**:
    - Sent for all successful logins, including social logins.
2. **Login Failure Notification**:
    - Triggered for invalid credentials.

---

## **7. Security Considerations**

1. **Token Security**:
    - Uses **Laravel Sanctum** for secure token-based authentication.
2. **Data Encryption**:
    - Passwords stored using bcrypt.
    - Sensitive data (e.g., phone numbers) encrypted before storage.
3. **Route Protection**:
    - Login routes are public.
    - Authenticated routes are Sanctum-protected.

---

## **8. Testing Criteria**

1. **Validation Tests**:
    - Ensure all inputs meet validation rules (e.g., phone number, password).
    - Verify proper error feedback for invalid credentials.
2. **Fallback Scenarios**:
    - Handle geolocation denial for the country code dropdown.
    - Ensure appropriate error handling for incorrect phone numbers or passwords.
3. **API Integration**:
    - Test both successful and failed login responses.
4. **Redirection**:
    - Confirm successful logins redirect users to the Home Page.
5. **Social Login Handling**:
    - Verify first-time social login users are flagged for profile completion on the Home Page.

---

# **Fly Live Documentation: Forgot Password Page**

---

## **1. Purpose**

- Provide users with a secure way to reset their passwords.
- Cater to two types of users:
    - **Social Login Users**: Reset via email.
    - **Phone-Only Users**: Reset via admin-generated tokens.

---

## **2. Workflow**

### **For Social Login Users**

1. **Request Password Reset**:
    - User enters their registered email on the Forgot Password Page.
    - Backend verifies the email and sends a password reset link.
2. **Reset Link**:
    - Contains a secure token:
        
        ```perl
        perl
        CopyEdit
        https://your-app.com/reset-password/{token}
        
        ```
        
    - Redirects the user to the Reset Password Page.
3. **Password Update**:
    - User sets a new password.
    - Backend validates the token and updates the password if valid.

### **For Phone-Only Users**

1. **Request Password Reset**:
    - User enters their registered phone number on the Forgot Password Page.
2. **Admin-Generated Token**:
    - Admin generates a temporary reset token via the admin panel.
    - Token is securely shared with the user (e.g., through support channels).
3. **Password Update**:
    - User navigates to the Reset Password Page, enters the token, and sets a new password.
    - Backend validates the token, updates the password, and invalidates the token.

---

## **3. Functional Requirements**

### **General Requirements**

1. **Validation**:
    - Verify that the provided email/phone exists in the database.
2. **Token Rules**:
    - Unique, time-limited (e.g., 15 minutes for email, 24 hours for phone users), and single-use.
3. **Security**:
    - Store passwords as hashed values (bcrypt).
    - Encrypt tokens before saving in the database.

### **Flow-Specific Requirements**

1. **Email-Based Reset**:
    - Ensure tokens are tied to a valid email and expire after use.
2. **Phone-Based Reset**:
    - Token must be linked to a user and expire after use or time limit.

---

## **4. UI/UX Design**

### **Forgot Password Page**

1. **For Social Login Users**:
    - Email input field.
    - Success message: “A reset link has been sent to your email.”
    - Error message: “No account found with this email.”
2. **For Phone-Only Users**:
    - Phone number input field.
    - Success message: “A reset token has been sent.”
    - Error message: “No account found with this phone number.”

### **Reset Password Page**

1. **Fields**:
    - New Password.
    - Confirm Password.
    - Token (required only for phone users).
2. **Feedback**:
    - Success: “Your password has been reset successfully.”
    - Failure: “Invalid or expired token.”

---

## **5. Database Reference**

### **Email-Based Reset**

- Laravel’s built-in `password_resets` table:
    - Stores email, reset token, and timestamps.

### **Phone-Based Reset**

- Custom `phone_reset_tokens` table:
    
    ```php
    php
    CopyEdit
    Schema::create('phone_reset_tokens', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('token');
        $table->timestamp('expires_at');
        $table->timestamps();
    });
    
    ```
    

For further schema details, see **Fly Live Documentation: Database Design**.

---

## **6. Backend Integration**

1. **Endpoints**:
    - `POST /forgot-password`: Initiates the password reset process (email or admin token).
    - `POST /reset-password`: Validates the token and updates the password.
2. **Token Handling**:
    - Tokens are securely stored and validated before password updates.

---

## **7. Notifications**

1. **Success Notifications**:
    - Sent when a password reset link/token is generated.
2. **Failure Notifications**:
    - Triggered for invalid email, phone number, or expired tokens.

---

## **8. Security Considerations**

1. **Token Storage**:
    - Encrypted tokens stored in the database.
    - Invalidate tokens after use or expiration.
2. **Password Security**:
    - Store passwords as bcrypt hashes.
3. **Route Protection**:
    - Forgot Password and Reset Password routes are public.
    - Authenticated routes remain Sanctum-protected.

---

## **9. Testing Criteria**

1. **Validation Tests**:
    - Verify email and phone number inputs for proper formatting and existence.
    - Ensure tokens are tied to valid users.
2. **Token Expiry**:
    - Test time limits for both email and phone-based tokens.
3. **End-to-End Flows**:
    - Test email-based and phone-based reset flows:
        - Token generation.
        - Password reset success and failure cases.
4. **Error Handling**:
    - Test invalid/expired tokens and ensure appropriate error messages are displayed.
5. **Notifications**:
    - Verify success and failure notifications for both workflows.