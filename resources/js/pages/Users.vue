<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import CountAllUsers from '@/components/user/CountAllUsers.vue';
import { columns } from '@/components/user/columns';
import DataTable from '@/components/ui/DataTable.vue';
import {ref, onMounted} from 'vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

const data = ref<Payment[]>([]);

defineProps({
    count: {
        type: Number,
        required: true,
    },
    users: {
        type: Object,
        required: true,
    }
});

</script>
<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">

                <CountAllUsers> {{ count }} </CountAllUsers>

                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>

                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <DataTable :columns="columns" :data="users" />
        </div>
    </AppLayout>
</template>
