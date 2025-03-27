import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
    canAccess?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
}

export interface User {
    id: number;
    name: string;
    signature: string;
    phone?: string | null;
    email: string;
    country?: string | null;
    gender?: number | null;
    dob?: string | null;
    password: string;
    avatar_image?: string | null;
    is_blocked: boolean;
    blocked_at?: string | null;
    block_reason?: string | null;
    social_provider?: string | null;
    social_provider_id?: string | null;
    coin_balance: number;
    diamond_balance: number;
    wealth_xp: number;
    charm_xp: number;
    room_xp: number;
    roles?: string[];
    deleted_at?: string | null;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Frame {
    id: number;
    name: string;
    price: number;
    static_src: string;
    animated_src: string;
    valid_duration: number;
    status: number;
    created_at: string;
    updated_at: string;
}

export interface CoinRequests {
    id: number;
    user_id: number;
    requested_from: number;
    updated_by: number;
    status: number;
    created_at: string;
    updated_at: string;
    type: number;
    amount: number;
    message?: string;
    proof_1?: string;
    proof_2?: string;
    proof_3?: string;
    credit_days?: number,
}

export type BreadcrumbItemType = BreadcrumbItem;
