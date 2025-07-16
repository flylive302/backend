# Database Schema Documentation

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
| created_at        | TIMESTAMP |                              |
| updated_at        | TIMESTAMP |                              |
| remember_token    | STRING    | nullable                     |
| deleted_at        | TIMESTAMP | nullable                     |

---

### rooms
| Field                | Type      | Notes                        |
|----------------------|-----------|------------------------------|
| id                   | BIGINT    | PK                           |
| user_id              | BIGINT    | FK → users                   |
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
| created_at           | TIMESTAMP |                              |
| updated_at           | TIMESTAMP |                              |
| deleted_at           | TIMESTAMP | nullable                     |

---

### seats
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| id           | BIGINT    | PK                           |
| room_id      | BIGINT    | FK → rooms                   |
| status       | TINYINT   | default 0                    |
| is_muted     | BOOLEAN   | default false                |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |
| deleted_at   | TIMESTAMP | nullable                     |

---

### messages
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| id           | BIGINT    | PK                           |
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
| created_at    | TIMESTAMP |                              |
| updated_at    | TIMESTAMP |                              |

---

### themes, levels, rewards, gifts
Each has:
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| id           | BIGINT    | PK                           |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |

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
| created_at           | TIMESTAMP |                              |
| updated_at           | TIMESTAMP |                              |
| deleted_at           | TIMESTAMP | nullable                     |

---

### frame_user (pivot)
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| user_id      | BIGINT    | FK → users                   |
| frame_id     | BIGINT    | FK → frames                  |
| expires_at   | DATETIME  | nullable                     |
| quantity     | USMALLINT | default 1                    |
| is_active    | BOOLEAN   | default false                |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |

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
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |
| deleted_at   | TIMESTAMP | nullable                     |

---

### visitor
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| id           | BIGINT    | PK                           |
| room_id      | BIGINT    | FK → rooms                   |
| user_id      | BIGINT    | FK → users                   |
| is_banned    | BOOLEAN   | default false                |
| kicked_at    | TIME      | nullable                     |
| kicked_for   | TIME      | nullable                     |
| created_at   | TIMESTAMP |                              |
| updated_at   | TIMESTAMP |                              |
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

## Relationships and How They Are Used

### User Relationships
- **frames**: Many-to-many (`belongsToMany`) via `frame_user` pivot. Used for assigning frames to users, with extra pivot data like `expires_at`, `quantity`, `is_active`.
- **initiatedTransactions**: One-to-many (`hasMany`) for transactions initiated by the user.
- **receivedTransactions**: One-to-many (`hasMany`) for transactions where the user is the beneficiary.
- **coinRequests**: One-to-many (`hasMany`) for coin requests made by the user.
- **coinRequestedFromMe**: One-to-many (`hasMany`) for coin requests where the user is the requested_from.
- **room**: One-to-one (`hasOne`) for the room owned by the user.

### Room Relationships
- **user**: Belongs to a user (owner).
- **seats**: One-to-many (`hasMany`) for seats in the room.

### Transaction Relationships
- **initiator**: Belongs to a user (user_id).
- **beneficiary**: Belongs to a user (beneficiary_id).
- **transactionable**: Polymorphic (`morphTo`) for linking to any model.

### Frame Relationships
- **users**: Many-to-many (`belongsToMany`) via `frame_user` pivot.

### CoinRequest Relationships
- **user**: Belongs to a user (user_id).
- **requestedFrom**: Belongs to a user (requested_from).
- **updater**: Belongs to a user (updated_by).

### Visitor Relationships
- **room_id**: FK to rooms.
- **user_id**: FK to users.
- (Model is a Pivot, so used for many-to-many between users and rooms.)

---

## How Your App Works With These Relationships

- **Eloquent Relationships**: Your app uses Laravel Eloquent relationships (`hasMany`, `belongsTo`, `belongsToMany`, `hasOne`, `morphTo`) to easily fetch related data. For example, `$user->frames` gets all frames for a user, `$room->seats` gets all seats in a room, and `$transaction->beneficiary` gets the user who benefited from a transaction.
- **Pivot Tables**: For many-to-many (like users and frames), you use pivot tables with extra fields (e.g., `expires_at`, `quantity`, `is_active` in `frame_user`).
- **Polymorphic Relations**: Transactions and personal access tokens use polymorphic relations to link to multiple possible models.
- **Role/Permission System**: The app uses the Spatie Laravel Permission package, so users can have roles and permissions, managed via additional tables (not detailed here).
- **Soft Deletes**: Many tables use soft deletes, so records are not removed from the database but marked as deleted.
- **Custom Accessors/Mutators**: The User and Transaction models use custom accessors/mutators for fields like `gender` and `currency_type` to map between integers and strings.

---

If you want a more detailed breakdown for a specific table or relationship, or want to see example code for how to use these relationships in controllers or services, let me know! 