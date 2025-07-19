# FlyLive Backend Database Schema

## Overview

This document outlines the complete database schema for the FlyLive backend rebuild using PostgreSQL. The schema supports user management, room operations, coin economy, agency system, levels, gifting, and administrative functions.

## Core Tables

### users
Enhanced user table with social features and economy tracking.

```sql
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(20) UNIQUE,
    signature VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    gender SMALLINT NOT NULL, -- 1=male, 2=female, 3=others
    country VARCHAR(3) NOT NULL, -- ISO country code
    avatar_image TEXT,
    animated_src TEXT, -- Active frame animated source
    static_src TEXT, -- Active frame static source
    
    -- Economy fields
    coin_balance DECIMAL(15,2) DEFAULT 0.00,
    diamond_balance DECIMAL(15,2) DEFAULT 0.00,
    total_spent DECIMAL(15,2) DEFAULT 0.00,
    total_received DECIMAL(15,2) DEFAULT 0.00,
    
    -- Level system
    wealth_level_id BIGINT REFERENCES levels(id),
    charm_level_id BIGINT REFERENCES levels(id),
    wealth_xp BIGINT DEFAULT 0,
    charm_xp BIGINT DEFAULT 0,
    
    -- Agency system
    agency_id BIGINT REFERENCES agencies(id),
    agency_role VARCHAR(20) DEFAULT 'member', -- member, moderator, admin
    agency_joined_at TIMESTAMP,
    
    -- VIP system
    vip_level INTEGER DEFAULT 0, -- 0=none, 1-6=VIP levels, 7=FLSVIP
    vip_expires_at TIMESTAMP,
    
    -- Social provider
    social_provider VARCHAR(50), -- google, facebook
    social_provider_id VARCHAR(255),
    
    -- Status and tracking
    is_blocked BOOLEAN DEFAULT FALSE,
    blocked_at TIMESTAMP,
    block_reason TEXT,
    last_active_at TIMESTAMP,
    email_verified_at TIMESTAMP,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW(),
    deleted_at TIMESTAMP -- Soft delete
);

-- Indexes
CREATE INDEX idx_users_phone ON users(phone);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_signature ON users(signature);
CREATE INDEX idx_users_agency_id ON users(agency_id);
CREATE INDEX idx_users_wealth_level ON users(wealth_level_id);
CREATE INDEX idx_users_charm_level ON users(charm_level_id);
CREATE INDEX idx_users_vip_level ON users(vip_level);
CREATE INDEX idx_users_last_active ON users(last_active_at);
CREATE INDEX idx_users_social_provider ON users(social_provider, social_provider_id);
```

### rooms
Enhanced room table with metrics and settings.

```sql
CREATE TABLE rooms (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name VARCHAR(40) NOT NULL UNIQUE,
    logo TEXT NOT NULL,
    type VARCHAR(10) DEFAULT 'public', -- public, private
    password VARCHAR(255), -- Plain text for private rooms
    country VARCHAR(3) NOT NULL,
    
    -- Room settings
    greetings TEXT,
    theme_id BIGINT REFERENCES themes(id),
    mic_seat_quantity INTEGER DEFAULT 5,
    max_participants INTEGER DEFAULT 1000,
    
    -- Tourist permissions
    can_tourists_speak BOOLEAN DEFAULT FALSE,
    can_tourists_send_text BOOLEAN DEFAULT TRUE,
    can_tourists_send_files BOOLEAN DEFAULT FALSE,
    
    -- Room metrics
    participant_count INTEGER DEFAULT 0,
    total_coins_spent DECIMAL(15,2) DEFAULT 0.00,
    daily_coins_spent DECIMAL(15,2) DEFAULT 0.00,
    weekly_coins_spent DECIMAL(15,2) DEFAULT 0.00,
    monthly_coins_spent DECIMAL(15,2) DEFAULT 0.00,
    
    -- Room progression
    room_level INTEGER DEFAULT 1,
    room_xp BIGINT DEFAULT 0,
    popularity_index DECIMAL(8,2) DEFAULT 0.00,
    
    -- Audio settings
    background_music_url TEXT,
    
    -- Status
    is_hidden BOOLEAN DEFAULT FALSE,
    is_featured BOOLEAN DEFAULT FALSE,
    status VARCHAR(20) DEFAULT 'active', -- active, inactive, suspended
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW(),
    deleted_at TIMESTAMP -- Soft delete
);

-- Indexes
CREATE INDEX idx_rooms_user_id ON rooms(user_id);
CREATE INDEX idx_rooms_name ON rooms(name);
CREATE INDEX idx_rooms_type ON rooms(type);
CREATE INDEX idx_rooms_country ON rooms(country);
CREATE INDEX idx_rooms_status ON rooms(status);
CREATE INDEX idx_rooms_popularity ON rooms(popularity_index DESC);
CREATE INDEX idx_rooms_coins_spent ON rooms(total_coins_spent DESC);
CREATE INDEX idx_rooms_participant_count ON rooms(participant_count DESC);
```

### room_participants
Tracks user participation in rooms with roles and timing.

```sql
CREATE TABLE room_participants (
    id BIGSERIAL PRIMARY KEY,
    room_id BIGINT NOT NULL REFERENCES rooms(id) ON DELETE CASCADE,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    role VARCHAR(20) DEFAULT 'listener', -- listener, speaker, moderator
    seat_number INTEGER, -- NULL for listeners, 1-N for speakers
    joined_at TIMESTAMP DEFAULT NOW(),
    left_at TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    is_muted BOOLEAN DEFAULT FALSE,
    
    UNIQUE(room_id, user_id, is_active) -- One active participation per user per room
);

-- Indexes
CREATE INDEX idx_room_participants_room_id ON room_participants(room_id);
CREATE INDEX idx_room_participants_user_id ON room_participants(user_id);
CREATE INDEX idx_room_participants_active ON room_participants(room_id, is_active);
CREATE INDEX idx_room_participants_speakers ON room_participants(room_id, role) WHERE role = 'speaker';
```

## Agency System

### agencies
Agency/clan system for user groups.

```sql
CREATE TABLE agencies (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    logo TEXT,
    owner_id BIGINT NOT NULL REFERENCES users(id),
    
    -- Agency settings
    commission_rate DECIMAL(5,2) DEFAULT 10.00, -- Percentage
    member_limit INTEGER DEFAULT 50,
    is_recruiting BOOLEAN DEFAULT TRUE,
    
    -- Agency metrics
    total_earnings DECIMAL(15,2) DEFAULT 0.00,
    member_count INTEGER DEFAULT 0,
    
    -- Status
    status VARCHAR(20) DEFAULT 'active', -- active, inactive, suspended
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_agencies_owner_id ON agencies(owner_id);
CREATE INDEX idx_agencies_name ON agencies(name);
CREATE INDEX idx_agencies_status ON agencies(status);
CREATE INDEX idx_agencies_earnings ON agencies(total_earnings DESC);
```

### agency_earnings
Tracks earnings and commission distribution for agencies.

```sql
CREATE TABLE agency_earnings (
    id BIGSERIAL PRIMARY KEY,
    agency_id BIGINT NOT NULL REFERENCES agencies(id) ON DELETE CASCADE,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    amount DECIMAL(10,2) NOT NULL,
    commission_amount DECIMAL(10,2) NOT NULL,
    commission_rate DECIMAL(5,2) NOT NULL,
    source_type VARCHAR(50) NOT NULL, -- gift, purchase, etc.
    source_id BIGINT, -- ID of the source transaction
    earned_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_agency_earnings_agency_id ON agency_earnings(agency_id);
CREATE INDEX idx_agency_earnings_user_id ON agency_earnings(user_id);
CREATE INDEX idx_agency_earnings_earned_at ON agency_earnings(earned_at);
```

### agency_member_requests
Handles agency join requests and invitations.

```sql
CREATE TABLE agency_member_requests (
    id BIGSERIAL PRIMARY KEY,
    agency_id BIGINT NOT NULL REFERENCES agencies(id) ON DELETE CASCADE,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    type VARCHAR(20) NOT NULL, -- application, invitation
    message TEXT,
    status VARCHAR(20) DEFAULT 'pending', -- pending, approved, rejected
    processed_by BIGINT REFERENCES users(id),
    processed_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_agency_requests_agency_id ON agency_member_requests(agency_id);
CREATE INDEX idx_agency_requests_user_id ON agency_member_requests(user_id);
CREATE INDEX idx_agency_requests_status ON agency_member_requests(status);
```

## Economy System

### transactions
Enhanced transaction table for all economic activities.

```sql
CREATE TABLE transactions (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id),
    beneficiary_id BIGINT REFERENCES users(id), -- NULL for system transactions
    
    -- Transaction details
    type VARCHAR(50) NOT NULL, -- purchase, gift, transfer, commission, etc.
    currency_type SMALLINT NOT NULL, -- 1=coins, 2=diamonds
    amount DECIMAL(10,2) NOT NULL,
    quantity INTEGER DEFAULT 1,
    
    -- Balance tracking
    user_balance_before DECIMAL(15,2) NOT NULL,
    user_balance_after DECIMAL(15,2) NOT NULL,
    beneficiary_balance_before DECIMAL(15,2),
    beneficiary_balance_after DECIMAL(15,2),
    
    -- Polymorphic relationship to source
    transactionable_type VARCHAR(255), -- Gift, Frame, CoinRequest, etc.
    transactionable_id BIGINT,
    
    -- Metadata
    description TEXT,
    metadata JSONB, -- Additional transaction data
    
    -- Status
    status VARCHAR(20) DEFAULT 'completed', -- pending, completed, failed, cancelled
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW(),
    deleted_at TIMESTAMP -- Soft delete
);

-- Indexes
CREATE INDEX idx_transactions_user_id ON transactions(user_id);
CREATE INDEX idx_transactions_beneficiary_id ON transactions(beneficiary_id);
CREATE INDEX idx_transactions_type ON transactions(type);
CREATE INDEX idx_transactions_currency_type ON transactions(currency_type);
CREATE INDEX idx_transactions_created_at ON transactions(created_at);
CREATE INDEX idx_transactions_polymorphic ON transactions(transactionable_type, transactionable_id);
```

### coin_requests
Enhanced coin request system for resellers.

```sql
CREATE TABLE coin_requests (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    requested_from BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    
    -- Request details
    amount DECIMAL(10,2) NOT NULL,
    type VARCHAR(20) NOT NULL, -- purchase, credit
    message TEXT,
    action_message TEXT, -- Admin response message
    
    -- Credit-specific fields
    credit_days INTEGER, -- For credit requests
    
    -- Proof files
    proof_1 TEXT,
    proof_2 TEXT,
    proof_3 TEXT,
    
    -- Status tracking
    status VARCHAR(20) DEFAULT 'pending', -- pending, approved, rejected, cancelled
    updated_by BIGINT REFERENCES users(id),
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_coin_requests_user_id ON coin_requests(user_id);
CREATE INDEX idx_coin_requests_requested_from ON coin_requests(requested_from);
CREATE INDEX idx_coin_requests_status ON coin_requests(status);
CREATE INDEX idx_coin_requests_created_at ON coin_requests(created_at);
```

### recharge_packages
Predefined coin purchase packages.

```sql
CREATE TABLE recharge_packages (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    coin_amount INTEGER NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    bonus_coins INTEGER DEFAULT 0,
    is_popular BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    country_restrictions TEXT[], -- Array of country codes
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_recharge_packages_active ON recharge_packages(is_active);
CREATE INDEX idx_recharge_packages_popular ON recharge_packages(is_popular);
```

## Gifting System

### gifts
Enhanced gift catalog with categories and effects.

```sql
CREATE TABLE gifts (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(8,2) NOT NULL,
    
    -- Visual assets
    thumbnail_url TEXT NOT NULL,
    animation_url TEXT, -- SVGA or MP4 file
    sound_url TEXT,
    
    -- Categorization
    category VARCHAR(50) NOT NULL, -- normal, lucky, cp, vip, country
    subcategory VARCHAR(50),
    rarity VARCHAR(20) DEFAULT 'common', -- common, rare, epic, legendary
    
    -- Game mechanics
    wealth_xp_multiplier DECIMAL(3,2) DEFAULT 1.00,
    charm_xp_multiplier DECIMAL(3,2) DEFAULT 1.00,
    
    -- Availability
    is_active BOOLEAN DEFAULT TRUE,
    vip_level_required INTEGER DEFAULT 0,
    country_specific VARCHAR(3), -- ISO country code for country-themed gifts
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_gifts_category ON gifts(category);
CREATE INDEX idx_gifts_price ON gifts(price);
CREATE INDEX idx_gifts_rarity ON gifts(rarity);
CREATE INDEX idx_gifts_active ON gifts(is_active);
CREATE INDEX idx_gifts_vip_required ON gifts(vip_level_required);
```

### gift_transactions
Detailed gift transaction tracking.

```sql
CREATE TABLE gift_transactions (
    id BIGSERIAL PRIMARY KEY,
    sender_id BIGINT NOT NULL REFERENCES users(id),
    recipient_id BIGINT NOT NULL REFERENCES users(id),
    gift_id BIGINT NOT NULL REFERENCES gifts(id),
    room_id BIGINT REFERENCES rooms(id), -- NULL for private gifts
    
    -- Transaction details
    quantity INTEGER DEFAULT 1,
    total_cost DECIMAL(10,2) NOT NULL,
    recipient_earnings DECIMAL(10,2) NOT NULL,
    agency_commission DECIMAL(10,2) DEFAULT 0.00,
    platform_fee DECIMAL(10,2) DEFAULT 0.00,
    
    -- XP rewards
    wealth_xp_awarded BIGINT DEFAULT 0,
    charm_xp_awarded BIGINT DEFAULT 0,
    
    -- Timestamps
    sent_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_gift_transactions_sender_id ON gift_transactions(sender_id);
CREATE INDEX idx_gift_transactions_recipient_id ON gift_transactions(recipient_id);
CREATE INDEX idx_gift_transactions_gift_id ON gift_transactions(gift_id);
CREATE INDEX idx_gift_transactions_room_id ON gift_transactions(room_id);
CREATE INDEX idx_gift_transactions_sent_at ON gift_transactions(sent_at);
```

## Level and Achievement System

### levels
Level definitions for different progression types.

```sql
CREATE TABLE levels (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(20) NOT NULL, -- wealth, charm, room, vip
    level_number INTEGER NOT NULL,
    required_xp BIGINT NOT NULL,
    
    -- Rewards and privileges
    coin_reward INTEGER DEFAULT 0,
    diamond_reward INTEGER DEFAULT 0,
    frame_rewards INTEGER[], -- Array of frame IDs
    privileges JSONB, -- JSON object with privilege details
    
    -- Visual
    icon_url TEXT,
    badge_url TEXT,
    
    -- Status
    is_active BOOLEAN DEFAULT TRUE,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW(),
    
    UNIQUE(type, level_number)
);

-- Indexes
CREATE INDEX idx_levels_type ON levels(type);
CREATE INDEX idx_levels_level_number ON levels(type, level_number);
CREATE INDEX idx_levels_required_xp ON levels(type, required_xp);
```

### user_levels
User progress tracking for each level type.

```sql
CREATE TABLE user_levels (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    level_id BIGINT NOT NULL REFERENCES levels(id),
    type VARCHAR(20) NOT NULL, -- wealth, charm, room, vip
    current_xp BIGINT DEFAULT 0,
    achieved_at TIMESTAMP DEFAULT NOW(),
    is_active BOOLEAN DEFAULT TRUE,
    
    UNIQUE(user_id, type, is_active) -- One active level per type per user
);

-- Indexes
CREATE INDEX idx_user_levels_user_id ON user_levels(user_id);
CREATE INDEX idx_user_levels_level_id ON user_levels(level_id);
CREATE INDEX idx_user_levels_type ON user_levels(type);
CREATE INDEX idx_user_levels_active ON user_levels(user_id, type, is_active);
```

### badges
Achievement badge system.

```sql
CREATE TABLE badges (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50) NOT NULL, -- achievement, activity, personal, room
    
    -- Requirements
    requirements JSONB NOT NULL, -- JSON object defining unlock conditions
    
    -- Visual
    icon_url TEXT NOT NULL,
    rarity VARCHAR(20) DEFAULT 'common',
    
    -- Status
    is_active BOOLEAN DEFAULT TRUE,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_badges_category ON badges(category);
CREATE INDEX idx_badges_rarity ON badges(rarity);
CREATE INDEX idx_badges_active ON badges(is_active);
```

### user_badges
User badge achievements.

```sql
CREATE TABLE user_badges (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    badge_id BIGINT NOT NULL REFERENCES badges(id),
    earned_at TIMESTAMP DEFAULT NOW(),
    
    UNIQUE(user_id, badge_id)
);

-- Indexes
CREATE INDEX idx_user_badges_user_id ON user_badges(user_id);
CREATE INDEX idx_user_badges_badge_id ON user_badges(badge_id);
CREATE INDEX idx_user_badges_earned_at ON user_badges(earned_at);
```

## Ranking and Leaderboard System

### rankings
Leaderboard rankings for different categories and time periods.

```sql
CREATE TABLE rankings (
    id BIGSERIAL PRIMARY KEY,
    category VARCHAR(50) NOT NULL, -- wealth, charm, room, agency, game
    subcategory VARCHAR(50), -- teen_patti, fruit_loop for games
    period VARCHAR(20) NOT NULL, -- daily, weekly, monthly, all_time
    period_start DATE NOT NULL,
    period_end DATE NOT NULL,
    
    -- Ranking data
    user_id BIGINT REFERENCES users(id),
    room_id BIGINT REFERENCES rooms(id),
    agency_id BIGINT REFERENCES agencies(id),
    
    rank_position INTEGER NOT NULL,
    score DECIMAL(15,2) NOT NULL,
    
    -- Metadata
    metadata JSONB, -- Additional ranking data
    
    -- Timestamps
    calculated_at TIMESTAMP DEFAULT NOW(),
    
    UNIQUE(category, subcategory, period, period_start, rank_position)
);

-- Indexes
CREATE INDEX idx_rankings_category ON rankings(category, subcategory, period);
CREATE INDEX idx_rankings_user_id ON rankings(user_id);
CREATE INDEX idx_rankings_room_id ON rankings(room_id);
CREATE INDEX idx_rankings_agency_id ON rankings(agency_id);
CREATE INDEX idx_rankings_period ON rankings(period_start, period_end);
CREATE INDEX idx_rankings_score ON rankings(category, period, score DESC);
```

## Social Features

### user_followers
User following/follower relationships.

```sql
CREATE TABLE user_followers (
    id BIGSERIAL PRIMARY KEY,
    follower_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    following_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    followed_at TIMESTAMP DEFAULT NOW(),
    
    UNIQUE(follower_id, following_id),
    CHECK(follower_id != following_id)
);

-- Indexes
CREATE INDEX idx_user_followers_follower_id ON user_followers(follower_id);
CREATE INDEX idx_user_followers_following_id ON user_followers(following_id);
CREATE INDEX idx_user_followers_followed_at ON user_followers(followed_at);
```

### room_followers
Room following relationships.

```sql
CREATE TABLE room_followers (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    room_id BIGINT NOT NULL REFERENCES rooms(id) ON DELETE CASCADE,
    followed_at TIMESTAMP DEFAULT NOW(),
    
    UNIQUE(user_id, room_id)
);

-- Indexes
CREATE INDEX idx_room_followers_user_id ON room_followers(user_id);
CREATE INDEX idx_room_followers_room_id ON room_followers(room_id);
```

### user_blocks
User blocking relationships.

```sql
CREATE TABLE user_blocks (
    id BIGSERIAL PRIMARY KEY,
    blocker_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    blocked_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    reason VARCHAR(255),
    blocked_at TIMESTAMP DEFAULT NOW(),
    
    UNIQUE(blocker_id, blocked_id),
    CHECK(blocker_id != blocked_id)
);

-- Indexes
CREATE INDEX idx_user_blocks_blocker_id ON user_blocks(blocker_id);
CREATE INDEX idx_user_blocks_blocked_id ON user_blocks(blocked_id);
```

## Frame and Customization System

### frames
Enhanced frame system with duration and effects.

```sql
CREATE TABLE frames (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(8,2) NOT NULL,
    
    -- Visual assets
    static_src TEXT NOT NULL,
    animated_src TEXT,
    thumbnail_url TEXT,
    
    -- Frame properties
    category VARCHAR(50) DEFAULT 'standard',
    rarity VARCHAR(20) DEFAULT 'common',
    duration_days INTEGER DEFAULT 30, -- NULL for permanent
    
    -- Availability
    is_active BOOLEAN DEFAULT TRUE,
    vip_level_required INTEGER DEFAULT 0,
    level_required INTEGER DEFAULT 1,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_frames_category ON frames(category);
CREATE INDEX idx_frames_price ON frames(price);
CREATE INDEX idx_frames_rarity ON frames(rarity);
CREATE INDEX idx_frames_active ON frames(is_active);
```

### frame_user
User frame ownership with expiration tracking.

```sql
CREATE TABLE frame_user (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    frame_id BIGINT NOT NULL REFERENCES frames(id) ON DELETE CASCADE,
    quantity INTEGER DEFAULT 1,
    expires_at TIMESTAMP, -- NULL for permanent frames
    is_active BOOLEAN DEFAULT FALSE, -- Only one frame can be active
    purchased_at TIMESTAMP DEFAULT NOW(),
    activated_at TIMESTAMP,
    
    UNIQUE(user_id, frame_id)
);

-- Indexes
CREATE INDEX idx_frame_user_user_id ON frame_user(user_id);
CREATE INDEX idx_frame_user_frame_id ON frame_user(frame_id);
CREATE INDEX idx_frame_user_active ON frame_user(user_id, is_active);
CREATE INDEX idx_frame_user_expires_at ON frame_user(expires_at);
```

### themes
Room theme system.

```sql
CREATE TABLE themes (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(8,2) DEFAULT 0.00,
    
    -- Theme assets
    background_image TEXT,
    css_styles JSONB, -- Custom CSS properties
    
    -- Availability
    is_active BOOLEAN DEFAULT TRUE,
    is_default BOOLEAN DEFAULT FALSE,
    vip_level_required INTEGER DEFAULT 0,
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_themes_active ON themes(is_active);
CREATE INDEX idx_themes_default ON themes(is_default);
CREATE INDEX idx_themes_price ON themes(price);
```

## Messaging System

### messages
Room and private messaging system.

```sql
CREATE TABLE messages (
    id BIGSERIAL PRIMARY KEY,
    sender_id BIGINT NOT NULL REFERENCES users(id),
    recipient_id BIGINT REFERENCES users(id), -- NULL for room messages
    room_id BIGINT REFERENCES rooms(id), -- NULL for private messages
    
    -- Message content
    content TEXT NOT NULL,
    message_type VARCHAR(20) DEFAULT 'text', -- text, image, system, gift_notification
    
    -- File attachments
    attachment_url TEXT,
    attachment_type VARCHAR(50), -- image, audio, file
    
    -- Status
    is_read BOOLEAN DEFAULT FALSE,
    is_deleted BOOLEAN DEFAULT FALSE,
    
    -- Timestamps
    sent_at TIMESTAMP DEFAULT NOW(),
    read_at TIMESTAMP,
    
    CHECK(
        (room_id IS NOT NULL AND recipient_id IS NULL) OR 
        (room_id IS NULL AND recipient_id IS NOT NULL)
    )
);

-- Indexes
CREATE INDEX idx_messages_sender_id ON messages(sender_id);
CREATE INDEX idx_messages_recipient_id ON messages(recipient_id);
CREATE INDEX idx_messages_room_id ON messages(room_id);
CREATE INDEX idx_messages_sent_at ON messages(sent_at);
CREATE INDEX idx_messages_conversation ON messages(sender_id, recipient_id, sent_at);
```

## System Tables

### personal_access_tokens
Laravel Sanctum token table (already exists).

```sql
-- This table is created by Laravel Sanctum migration
-- Included here for completeness
```

### password_reset_tokens
Password reset tokens for email-based resets.

```sql
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT NOW()
);
```

### phone_reset_tokens
Password reset tokens for phone-based resets.

```sql
CREATE TABLE phone_reset_tokens (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT NOW()
);

-- Indexes
CREATE INDEX idx_phone_reset_tokens_user_id ON phone_reset_tokens(user_id);
CREATE INDEX idx_phone_reset_tokens_token ON phone_reset_tokens(token);
CREATE INDEX idx_phone_reset_tokens_expires_at ON phone_reset_tokens(expires_at);
```

### failed_jobs
Laravel failed job queue table.

```sql
CREATE TABLE failed_jobs (
    id BIGSERIAL PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT NOW()
);
```

### jobs
Laravel job queue table.

```sql
CREATE TABLE jobs (
    id BIGSERIAL PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts SMALLINT NOT NULL,
    reserved_at INTEGER,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);

-- Indexes
CREATE INDEX idx_jobs_queue ON jobs(queue);
CREATE INDEX idx_jobs_reserved_at ON jobs(reserved_at);
```

### cache
Laravel cache table.

```sql
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);
```

### sessions
Laravel session table.

```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

-- Indexes
CREATE INDEX idx_sessions_user_id ON sessions(user_id);
CREATE INDEX idx_sessions_last_activity ON sessions(last_activity);
```

## Database Performance Optimizations

### Partitioning Strategy
For high-volume tables, consider partitioning:

```sql
-- Partition transactions by month
CREATE TABLE transactions_y2024m01 PARTITION OF transactions
FOR VALUES FROM ('2024-01-01') TO ('2024-02-01');

-- Partition gift_transactions by month
CREATE TABLE gift_transactions_y2024m01 PARTITION OF gift_transactions
FOR VALUES FROM ('2024-01-01') TO ('2024-02-01');
```

### Additional Indexes for Performance

```sql
-- Composite indexes for common queries
CREATE INDEX idx_users_agency_active ON users(agency_id, last_active_at) WHERE agency_id IS NOT NULL;
CREATE INDEX idx_rooms_country_active ON rooms(country, status) WHERE status = 'active';
CREATE INDEX idx_transactions_user_date ON transactions(user_id, created_at DESC);
CREATE INDEX idx_gift_transactions_room_date ON gift_transactions(room_id, sent_at DESC);

-- Partial indexes for better performance
CREATE INDEX idx_users_vip_active ON users(vip_level, vip_expires_at) WHERE vip_level > 0;
CREATE INDEX idx_rooms_featured ON rooms(popularity_index DESC) WHERE is_featured = true;
CREATE INDEX idx_coin_requests_pending ON coin_requests(created_at DESC) WHERE status = 'pending';
```

### Database Constraints

```sql
-- Ensure positive balances
ALTER TABLE users ADD CONSTRAINT chk_users_positive_balances 
CHECK (coin_balance >= 0 AND diamond_balance >= 0);

-- Ensure valid VIP levels
ALTER TABLE users ADD CONSTRAINT chk_users_vip_level 
CHECK (vip_level >= 0 AND vip_level <= 7);

-- Ensure valid room capacity
ALTER TABLE rooms ADD CONSTRAINT chk_rooms_capacity 
CHECK (participant_count >= 0 AND participant_count <= max_participants);

-- Ensure valid transaction amounts
ALTER TABLE transactions ADD CONSTRAINT chk_transactions_positive_amount 
CHECK (amount > 0);
```

## Summary

This database schema supports:

- **User Management**: Enhanced profiles, social features, economy tracking
- **Room System**: Comprehensive room management with metrics and permissions
- **Agency System**: Complete clan/team functionality with earnings tracking
- **Economy**: Coins, diamonds, transactions, gifts, and purchases
- **Levels & Achievements**: Progression system with XP and rewards
- **Social Features**: Following, blocking, messaging, and interactions
- **Customization**: Frames, themes, and visual enhancements
- **Administration**: Comprehensive tracking and management capabilities

The schema is optimized for performance with proper indexing and includes constraints for data integrity. It supports the full FlyLive platform feature set while maintaining scalability for 100,000+ users.