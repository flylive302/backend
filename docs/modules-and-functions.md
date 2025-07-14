# Module & Function Descriptions

## Services

### ImageKitService
Handles integration with ImageKit for file uploads. Provides methods to:
- Generate upload signatures for secure client-side uploads.
- Verify uploads by checking file details with ImageKit.

**Key Methods:**
- `generateUploadSignature(type, extension, userId)`: Returns a signature, expiry, token, filename, and tag for uploading.
- `verifyUpload(fileId)`: Returns true if the file exists in ImageKit.

---

## Helpers

### SignatureHelper
Generates unique user signatures based on a name, ensuring no duplicates in the users table.

**Key Methods:**
- `generate(name)`: Returns a unique signature string for a user.

---

## Models

### User
Central user model with authentication, roles, and relationships to:
- Frames (many-to-many, with pivot data for expiration, quantity, and active status)
- Transactions (initiated and received)
- Coin requests (sent and received)
- Room (one-to-one)

**Key Features:**
- Mass assignable fields for profile, balances, and social info
- Gender and date-of-birth mutators/casts
- Soft deletes and role management

### Room
Represents a user’s room, with properties for access, privacy, and relationships to:
- User (owner)
- Seats (has many)

**Key Features:**
- Mass assignable fields for privacy, country, and type
- Password is hashed and hidden

### Transaction
Handles all value transfers (coins/diamonds), supports polymorphic relations, and tracks:
- Initiator (user)
- Beneficiary (user)
- Transactionable (morph to any model)

**Key Features:**
- Currency type mutators/casts
- Soft deletes

### CoinRequest
Represents requests for coins between users, with proof attachments and status tracking.
- User (requester)
- RequestedFrom (target user)
- Updater (user who last updated the request)

**Key Features:**
- Mass assignable fields for amount, message, proofs, and status
- Amount is cast to float

### Frame
Represents visual frames users can own, with pricing, duration, and user relationships.
- Users (many-to-many, with pivot data for expiration, quantity, and active status)

**Key Features:**
- Mass assignable fields for name, price, sources, duration, and status
- Expires_at is cast to datetime 