<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { columns } from '@/components/coinRequest/columns';
import type { ColumnDef } from '@tanstack/vue-table';
import DataTable from '@/components/ui/DataTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Coin Requests',
        href: route('coinRequest.index')
    }
];

defineProps({
    pending_requests: {
        type: Object,
        required: true
    },
    approved_requests: {
        type: Object,
        required: true
    },
    rejected_requests: {
        type: Object,
        required: true
    },
    my_pending_requests: {
        type: Object,
        required: true
    },
    my_approved_requests: {
        type: Object,
        required: true
    },
    my_rejected_requests: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-4">
            <div>
                <h1 class="text-2xl font-bold mb-4">Pending Coin Requests</h1>
                <DataTable
                    :columns="columns as ColumnDef<unknown, unknown>[]"
                    :data="pending_requests as any[]"
                    filterOn="amount"
                />
            </div>
            <div>
                <h1 class="text-2xl font-bold mb-4">Approved Coin Requests</h1>
                <DataTable
                    :columns="columns as ColumnDef<unknown, unknown>[]"
                    :data="approved_requests as any[]"
                    filterOn="amount"
                />
            </div>
            <div>
                <h1 class="text-2xl font-bold mb-4">Rejected Coin Requests</h1>
                <DataTable
                    :columns="columns as ColumnDef<unknown, unknown>[]"
                    :data="rejected_requests as any[]"
                    filterOn="amount"
                />
            </div>
            <div>
                <h1 class="text-2xl font-bold mb-4">My Pending Coin Requests</h1>
                <DataTable
                    :columns="columns as ColumnDef<unknown, unknown>[]"
                    :data="my_pending_requests as any[]"
                    filterOn="amount"
                />
            </div>
            <div>
                <h1 class="text-2xl font-bold mb-4">My Approved Coin Requests</h1>
                <DataTable
                    :columns="columns as ColumnDef<unknown, unknown>[]"
                    :data="my_approved_requests as any[]"
                    filterOn="amount"
                />
            </div>
            <div>
                <h1 class="text-2xl font-bold mb-4">My Rejected Coin Requests</h1>
                <DataTable
                    :columns="columns as ColumnDef<unknown, unknown>[]"
                    :data="my_rejected_requests as any[]"
                    filterOn="type"
                />
            </div>
        </div>
    </AppLayout>
</template>
