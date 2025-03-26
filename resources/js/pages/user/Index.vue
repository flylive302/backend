<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import CountAllUsers from '@/components/user/CountAllUsers.vue';
import { columns } from '@/components/user/columns';
import type { ColumnDef } from '@tanstack/vue-table';
import DataTable from '@/components/ui/DataTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users'
    }
];

const props = defineProps({
    users: {
        type: Array,
        required: true
    }
});

const count = props.users.length;

</script>
<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">

                <CountAllUsers> {{ count }}</CountAllUsers>

                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>

                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <DataTable :columns="columns as ColumnDef<unknown, unknown>[]" :data="users" filterOn="email" />
        </div>
    </AppLayout>
</template>
