# Database Schema Documentation (Updated)

## Tables

### users
| Field             | Type      | Notes                        |
|-------------------|-----------|------------------------------|
| id                | BIGINT    | PK                           |
| name              | STRING    |                              |
| email             | STRING    | unique                       |
| phone             | STRING    | nullable, unique             |
| signature         | STRING    | unique                       |
| password          | STRING    |                              |
| country           | CHAR(2)   | nullable                     |
| gender            | TINYINT   | nullable                     |
| dob               | DATE      | nullable                     |
| avatar_image      | STRING    | nullable                     |
| animated_src      | STRING    | nullable                     |
| static_src        | STRING    | nullable                     |
| is_blocked        | BOOLEAN   | default false                |
| blocked_at        | TIMESTAMP | nullable                     |
| block_reason      | STRING    | nullable                     |
| social_provider   | STRING    | nullable                     |
| social_provider_id| STRING    | nullable                     |
| coin_balance      | DECIMAL   | default 0                    |
| diamond_balance   | DECIMAL   | default 0                    |
| wealth_xp         | DECIMAL   | default 0                    |
| charm_xp          | DECIMAL   | default 0                    |
| room_xp           | DECIMAL   | default 0                    |
| remember_token    | STRING    | nullable                     |
| deleted_at        | TIMESTAMP | nullable                     |
| created_at        | TIMESTAMP |                              |
| updated_at        | TIMESTAMP |                              |

---

### rooms
| Field                | Type      | Notes                        |
|----------------------|-----------|------------------------------|
| id                   | BIGINT    | PK                           |
| user_id              | BIGINT    | FK → users                   |
| theme_id             | BIGINT    | FK → themes, nullable        |
| popularity_index     | UINT      | default 0                    |
| country              | CHAR(2)   |                              |
| name                 | STRING    | unique                       |
| greetings            | TEXT      | nullable                     |
| logo                 | STRING    | nullable                     |
| can_tourists_speak   | BOOLEAN   | default true                 |
| can_tourists_send_text| BOOLEAN  | default true                 |
| can_tourists_send_files| BOOLEAN | default true                 |
| is_hidden            | BOOLEAN   | default false                |
| password             | STRING    | nullable                     |
| type                 | TINYINT   | default 1                    |
| deleted_at           | TIMESTAMP | nullable                     |
| created_at           | TIMESTAMP |                              |
| updated_at           | TIMESTAMP |                              |

---

### seats
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| id           | BIGINT    | PK                           |
| room_id      | BIGINT    | FK → rooms                   |
| user_id      | BIGINT    | FK → users, nullable, unique |
| status       | TINYINT   | default 0                    |
| is_muted     | BOOLEAN   | default false                |
| deleted_at   | TIMESTAMP | nullable                     |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |

---

### messages
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| id           | BIGINT    | PK                           |
| sender_id    | BIGINT    | FK → users                   |
| receiver_id  | BIGINT    | FK → users                   |
| content_type | TINYINT   | unsigned                     |
| content      | TEXT      |                              |
| delivered_at | TIMESTAMP | nullable                     |
| deleted_at   | TIMESTAMP | nullable                     |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |

---

### frames
| Field         | Type      | Notes                        |
|---------------|-----------|------------------------------|
| id            | BIGINT    | PK                           |
| name          | STRING    | unique                       |
| price         | DECIMAL   |                              |
| static_src    | STRING    |                              |
| animated_src  | STRING    |                              |
| valid_duration| BIGINT    | nullable                     |
| status        | TINYINT   | default 1                    |
| deleted_at    | TIMESTAMP | nullable                     |
| created_at    | TIMESTAMP |                              |
| updated_at    | TIMESTAMP |                              |

---

### themes
| Field                | Type      | Notes                        |
|----------------------|-----------|------------------------------|
| id                   | BIGINT    | PK                           |
| name                 | STRING    |                              |
| theme_color          | CHAR(30)  |                              |
| icon_color           | CHAR(30)  |                              |
| thumbnail_src        | STRING(255)|                             |
| background_src       | STRING(255)|                             |
| seat_ring_src        | STRING(255)|                             |
| seat_src             | STRING(255)|                             |
| space_btw_ring_and_seat| TINYINT | nullable                     |
| status               | TINYINT   | unsigned                     |
| price                | DECIMAL(8,2)|                            |
| valid_duration_seconds| BIGINT   | unsigned                     |
| deleted_at           | TIMESTAMP | nullable                     |
| created_at           | TIMESTAMP |                              |
| updated_at           | TIMESTAMP |                              |

---

### levels
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| id           | BIGINT    | PK                           |
| name         | STRING(100)|                             |
| type         | TINYINT   |                              |
| description  | TEXT      |                              |
| min_points   | DECIMAL(8,2)|                            |
| max_points   | DECIMAL(8,2)|                            |
| badge        | STRING(255)|                             |
| deleted_at   | TIMESTAMP | nullable                     |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |

---

### rewards
| Field                | Type      | Notes                        |
|----------------------|-----------|------------------------------|
| id                   | BIGINT    | PK                           |
| rewardable_id        | BIGINT    | morph                        |
| rewardable_type      | STRING(255)| morph                       |
| level_id             | BIGINT    | FK → levels                  |
| name                 | STRING(100)|                             |
| type                 | TINYINT   |                              |
| value                | DECIMAL(8,2)|                            |
| valid_duration_seconds| BIGINT   | unsigned                     |
| deleted_at           | TIMESTAMP | nullable                     |
| created_at           | TIMESTAMP |                              |
| updated_at           | TIMESTAMP |                              |

---

### gifts
| Field                | Type      | Notes                        |
|----------------------|-----------|------------------------------|
| id                   | BIGINT    | PK                           |
| category             | TINYINT   | unsigned, indexed            |
| name                 | STRING(100)|                             |
| price                | DECIMAL(8,2)|                            |
| static_src           | STRING(255)|                             |
| animated_file_type   | CHAR(30)  |                              |
| animated_src         | STRING(255)|                             |
| animation_duration   | INTEGER   | unsigned                     |
| deleted_at           | TIMESTAMP | nullable                     |
| created_at           | TIMESTAMP |                              |
| updated_at           | TIMESTAMP |                              |

---

### transactions
| Field                | Type      | Notes                        |
|----------------------|-----------|------------------------------|
| id                   | BIGINT    | PK                           |
| user_id              | BIGINT    | FK → users (initiator)       |
| beneficiary_id       | BIGINT    | FK → users (beneficiary)     |
| transactionable_id   | BIGINT    | morph                        |
| transactionable_type | STRING    | morph                        |
| currency_type        | TINYINT   | default 1                    |
| quantity             | MEDIUMINT | default 1                    |
| real_value           | DECIMAL   | default 0                    |
| change_in_value      | DECIMAL   | default 0                    |
| before               | DECIMAL   | default 0                    |
| after                | DECIMAL   | default 0                    |
| status               | TINYINT   | default 1                    |
| deleted_at           | TIMESTAMP | nullable                     |
| created_at           | TIMESTAMP |                              |
| updated_at           | TIMESTAMP |                              |

---

### coin_requests
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| id           | BIGINT    | PK                           |
| amount       | DECIMAL   |                              |
| message      | STRING    | nullable                     |
| action_message| STRING   | nullable                     |
| proof_1      | STRING    | nullable                     |
| proof_2      | STRING    | nullable                     |
| proof_3      | STRING    | nullable                     |
| type         | TINYINT   |                              |
| status       | TINYINT   | default 1                    |
| credit_days  | USMALLINT | nullable                     |
| user_id      | BIGINT    | FK → users                   |
| requested_from| BIGINT   | FK → users                   |
| updated_by   | BIGINT    | FK → users                   |
| deleted_at   | TIMESTAMP | nullable                     |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |

---

### visitors
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| id           | BIGINT    | PK                           |
| room_id      | BIGINT    | FK → rooms                   |
| user_id      | BIGINT    | FK → users                   |
| is_banned    | BOOLEAN   | default false                |
| kicked_at    | TIME      | nullable                     |
| kicked_for   | TIME      | nullable                     |
| joined_at    | TIMESTAMP | nullable                     |
| left_at      | TIMESTAMP | nullable                     |
| deleted_at   | TIMESTAMP | nullable                     |

---

### personal_access_tokens
| Field            | Type      | Notes                        |
|------------------|-----------|------------------------------|
| id               | BIGINT    | PK                           |
| tokenable_id     | BIGINT    | morph                        |
| tokenable_type   | STRING    | morph                        |
| name             | STRING    |                              |
| token            | STRING    | unique                       |
| abilities        | TEXT      | nullable                     |
| last_used_at     | TIMESTAMP | nullable                     |
| expires_at       | TIMESTAMP | nullable                     |
| created_at       | TIMESTAMP |                              |
| updated_at       | TIMESTAMP |                              |

---

### Pivot Tables

#### frame_user
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| user_id      | BIGINT    | FK → users                   |
| frame_id     | BIGINT    | FK → frames                  |
| expires_at   | DATETIME  | nullable                     |
| quantity     | USMALLINT | default 1                    |
| is_active    | BOOLEAN   | default false                |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |

#### level_user
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| level_id     | BIGINT    | FK → levels                  |
| user_id      | BIGINT    | FK → users                   |
| is_active    | BOOLEAN   | default false                |
| type         | TINYINT   | unsigned                     |
| points_before| DECIMAL(8,2)|                             |
| points_after | DECIMAL(8,2)|                             |
| achieved_at  | TIMESTAMP | nullable                     |
| lost_at      | TIMESTAMP | nullable                     |
| deleted_at   | TIMESTAMP | nullable                     |

#### theme_user
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| theme_id     | BIGINT    | FK → themes                  |
| user_id      | BIGINT    | FK → users                   |
| purchased_at | TIMESTAMP | nullable                     |
| expires_at   | DATETIME  | nullable                     |
| quantity     | INTEGER   |                              |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |

---

## Relationships and How They Are Used

### User Relationships
- **frames**: Many-to-many (`belongsToMany`) via `frame_user` pivot.
- **levels**: Many-to-many (`belongsToMany`) via `level_user` pivot.
- **themes**: Many-to-many (`belongsToMany`) via `theme_user` pivot.
- **room**: One-to-one (`hasOne`) for the room owned by the user.
- **seat**: Belongs to a seat (`belongsTo`).
- **visitor**: Has one visitor (`hasOne`).
- **sentMessages**: Has many messages sent (`hasMany` as sender).
- **receivedMessages**: Has many messages received (`hasMany` as receiver).
- **initiatedTransactions**: Has many transactions initiated by the user.
- **receivedTransactions**: Has many transactions where the user is the beneficiary.
- **coinRequests**: Has many coin requests made by the user.
- **coinRequestedFromMe**: Has many coin requests where the user is the requested_from.

### Room Relationships
- **user**: Belongs to a user (owner).
- **theme**: Belongs to a theme.
- **seats**: Has many seats.
- **visitors**: Has many visitors.

### Seat Relationships
- **room**: Belongs to a room.
- **user**: Has one user.

### Visitor Relationships
- **room**: Belongs to a room.
- **user**: Belongs to a user.

### Message Relationships
- **sender**: Belongs to a user (sender).
- **receiver**: Belongs to a user (receiver).

### Frame Relationships
- **users**: Many-to-many (`belongsToMany`) via `frame_user` pivot.
- **rewards**: Morph many (`morphMany`) as rewardable.
- **transactions**: Morph many (`morphMany`) as transactionable.
- **directUsers**: Has many users (direct, not pivot).
- **owner**: Belongs to a user (owner).

### Theme Relationships
- **rooms**: Has many rooms.
- **rewards**: Morph many (`morphMany`) as rewardable.
- **transactions**: Morph many (`morphMany`) as transactionable.
- **users**: Many-to-many (`belongsToMany`) via `theme_user` pivot.

### Level Relationships
- **users**: Many-to-many (`belongsToMany`) via `level_user` pivot.
- **rewards**: Has many rewards.

### Reward Relationships
- **level**: Belongs to a level.
- **rewardable**: Morph to (polymorphic).

### Gift Relationships
- **transactions**: Morph many (`morphMany`) as transactionable.

### Transaction Relationships
- **initiator**: Belongs to a user (user_id).
- **beneficiary**: Belongs to a user (beneficiary_id).
- **transactionable**: Morph to (polymorphic).

### CoinRequest Relationships
- **user**: Belongs to a user (user_id).
- **requestedFrom**: Belongs to a user (requested_from).
- **updater**: Belongs to a user (updated_by).

---

## How Your App Works With These Relationships

- **Eloquent Relationships**: Your app uses Laravel Eloquent relationships (`hasMany`, `belongsTo`, `belongsToMany`, `hasOne`, `morphTo`, `morphMany`) to easily fetch related data. For example, `$user->frames` gets all frames for a user, `$room->seats` gets all seats in a room, `$message->receiver` gets the user who received a message, and `$frame->transactions` gets all transactions for a frame.
- **Pivot Tables**: For many-to-many (like users and frames, users and levels, users and themes), you use pivot tables with extra fields (e.g., `expires_at`, `quantity`, `is_active` in `frame_user`).
- **Polymorphic Relations**: Rewards, transactions, and personal access tokens use polymorphic relations to link to multiple possible models.
- **Role/Permission System**: The app uses the Spatie Laravel Permission package, so users can have roles and permissions, managed via additional tables (not detailed here).
- **Soft Deletes**: Many tables use soft deletes, so records are not removed from the database but marked as deleted.
- **Custom Accessors/Mutators**: The User and Transaction models use custom accessors/mutators for fields like `gender` and `currency_type` to map between integers and strings.

---

If you want a more detailed breakdown for a specific table or relationship, or want to see example code for how to use these relationships in controllers or services, let me know! 