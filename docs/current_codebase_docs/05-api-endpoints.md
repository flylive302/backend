# API Endpoint Summaries

## Authentication & User

### `POST /api/register`
- **Registers a new user.**
- **Request:** name, phone, country, gender, dob, password
- **Response:** Auth token
- **Key Logic:**

The following code generates a unique signature for each user during registration. It uses the user's name, slugifies it, and appends a random number. It checks the database to ensure the signature is unique, retrying if necessary. This signature is used as a unique identifier and email prefix for the user.

```php
// Signature generation during registration
$validatedData['signature'] = SignatureHelper::generate($validatedData['name']);

// SignatureHelper::generate
public static function generate($name)
{
    $signature = '@'.Str::slug($name, '_').'_'.rand(2, 50);
    while (User::where('signature', $signature)->exists()) {
        $signature = '#'.Str::slug($name, '_').'_'.rand(2, 50);
    }
    return $signature;
}
```

### `POST /api/login`
- **Logs in a user.**
- **Request:** phone, password
- **Response:** Auth token

### `GET /api/user`
- **Returns the authenticated user's profile, permissions, active frame, and room.**

### `GET /api/user/{user}`
- **Returns a user by ID.**

### `POST /api/logout`
- **Logs out the user (revokes all tokens).**

### `POST /api/reset-password`
- **Updates the user's password.**
- **Request:** password (confirmed)

### `PATCH /api/update-profile`
- **Updates a single profile field.**
- **Request:** field, value

---

## File Upload

### `POST /api/signed-url`
- **Returns a signed URL and parameters for secure file upload to ImageKit.**
- **Request:** type (image, video, audio), extension (webp, jpg, etc.)
- **Response:** signature, expire, token, filename, tag
- **Key Logic:**

This code generates a secure upload signature for ImageKit. It creates a unique filename using the user ID, file type, and a UUID. It then requests authentication parameters from ImageKit, returning all necessary data for the client to upload files securely.

```php
// FileUploadController@getSignedUrl
$service = new ImageKitService();
$data = $service->generateUploadSignature($request->type, $request->extension, $request->user()->id);

// ImageKitService::generateUploadSignature
public function generateUploadSignature(string $type, string $extension, string $userId): array
{
    $fileName = "{$userId}-{$type}-" . Str::uuid() . ".{$extension}";
    $sig = $this->imageKit->getAuthenticationParameters();
    return [
        'signature' => $sig->signature,
        'expire' => $sig->expire,
        'token' => $sig->token,
        'filename' => $fileName,
        'tag' => ["{$userId}-user"]
    ];
}
```

---

## Frames

### `GET /api/frame/all`
- **Returns all available frames.**

### `GET /api/frame/my-frames`
- **Returns frames owned by the authenticated user.**

### `POST /api/frame/{frame}/purchase`
- **Purchases a frame for the user.**
- **Logic:** Checks balance, updates/attaches frame, records transaction.
- **Key Logic:**

This code checks if the user has enough coins to purchase a frame. If so, it deducts the price from the user's balance, credits the admin (user ID 1), updates or attaches the frame to the user, and records the transaction for auditing and history.

```php
// FrameController@purchase (excerpt)
if ($user->coin_balance < $frame->price) {
    return response()->json(['error' => 'Insufficient funds.'], 400);
}
// ...
$user->decrement('coin_balance', $frame->price);
User::find(1)->increment('coin_balance', $frame->price);
// ...
Transaction::create([
    'user_id' => $user->id,
    'beneficiary_id' => 1,
    'transactionable_id' => $frame->id,
    'transactionable_type' => Frame::class,
    'currency_type' => 1,
    'quantity' => 1,
    'real_value' => $frame->price,
    'change_in_value' => $frame->price,
    'before' => $user->coin_balance,
    'after' => $user->coin_balance - $frame->price,
]);
```

### `POST /api/frame/{frame}/activate`
- **Activates a frame for the user.**
- **Logic:** Deactivates other frames, updates user profile with frame sources.
- **Key Logic:**

This code deactivates any currently active frame for the user, activates the selected frame, and updates the user's profile with the new frame's image sources. This ensures only one frame is active at a time and the user's profile reflects the change.

```php
// FrameController@activate (excerpt)
DB::table('frame_user')->where('user_id', auth()->id())->where('is_active', true)->update([
    'is_active' => false,
    'updated_at' => now()
]);
auth()->user()->frames()->updateExistingPivot($frame->id, ['is_active' => true]);
auth()->user()->update([
    'animated_src' => $frame->animated_src,
    'static_src' => $frame->static_src,
]);
```

---

## Coin Requests

### `GET /api/coin-resellers`
- **Returns all users with the 'reseller' role.**

### `POST /api/coin-requests/{user}`
- **Creates a coin request to a user.**
- **Request:** amount, message, type, proofs, credit_days, etc.
- **Logic:** Handles file uploads, validates credit requests.
- **Key Logic:**

This code processes file uploads for coin requests. It stores up to three proof files, associates the request with the authenticated user and the target user, and creates the coin request record in the database.

```php
// CoinRequestController@store (excerpt)
foreach (['proof_1', 'proof_2', 'proof_3'] as $proof) {
    if ($file = $request->file($proof)) {
        $data[$proof] = $file->store('proofs', 'public');
    }
}
$data['user_id'] = auth()->id();
$data['requested_from'] = $user->id;
$coinRequest = CoinRequest::create($data);
```

### `GET /api/coin-requests/{coinRequest}/show`
- **Returns details of a specific coin request.**

---

## Rooms

### `GET /api/rooms`
- **Returns all rooms with their owners.**

### `GET /api/room/{room}/view`
- **Returns details of a specific room with its owner.**

---

## Health Check

### `GET /api/health_check`
- **Returns `{ status: 'ok' }` for monitoring.**

---

## Web Routes (Authenticated)

### `/dashboard`
- **Renders dashboard (admin or reseller view).**

### `/users`, `/users/{user}`
- **User management views.**

### `/frame` (resource)
- **Frame management views (CRUD).**

### `/coin-requests`, `/coin-requests/create`, `/coin-requests/{coinRequest}/show`, `/coin-requests/{coinRequest}/update`
- **Coin request management views.**

---

**All API endpoints (except register/login) require authentication via Sanctum.** 