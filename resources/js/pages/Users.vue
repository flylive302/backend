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
    }
});

async function getData(): Promise<Payment[]> {
    return [
        {
            id: '728ed52f',
            amount: 100,
            status: 'pending',
            email: 'm1@example.com'
        },
        {
            id: '728ed52g',
            amount: 150,
            status: 'completed',
            email: 'm2@example.com'
        },
        {
            id: '728ed52h',
            amount: 200,
            status: 'failed',
            email: 'm3@example.com'
        },
        {
            id: '728ed52i',
            amount: 250,
            status: 'pending',
            email: 'm4@example.com'
        },
        {
            id: '728ed52j',
            amount: 300,
            status: 'completed',
            email: 'm5@example.com'
        },
        {
            id: '728ed52k',
            amount: 350,
            status: 'failed',
            email: 'm6@example.com'
        },
        {
            id: '728ed52l',
            amount: 400,
            status: 'pending',
            email: 'm7@example.com'
        },
        {
            id: '728ed52m',
            amount: 450,
            status: 'completed',
            email: 'm8@example.com'
        },
        {
            id: '728ed52n',
            amount: 500,
            status: 'failed',
            email: 'm9@example.com'
        },
        {
            id: '728ed52o',
            amount: 550,
            status: 'pending',
            email: 'm10@example.com'
        },
        {
            id: '728ed52p',
            amount: 600,
            status: 'completed',
            email: 'm11@example.com'
        },
        {
            id: '728ed52q',
            amount: 650,
            status: 'failed',
            email: 'm12@example.com'
        },
        {
            id: '728ed52r',
            amount: 700,
            status: 'pending',
            email: 'm13@example.com'
        },
        {
            id: '728ed52s',
            amount: 750,
            status: 'completed',
            email: 'm14@example.com'
        },
        {
            id: '728ed52t',
            amount: 800,
            status: 'failed',
            email: 'm15@example.com'
        },
        {
            id: '728ed52u',
            amount: 850,
            status: 'pending',
            email: 'm16@example.com'
        },
        {
            id: '728ed52v',
            amount: 900,
            status: 'completed',
            email: 'm17@example.com'
        },
        {
            id: '728ed52w',
            amount: 950,
            status: 'failed',
            email: 'm18@example.com'
        },
        {
            id: '728ed52x',
            amount: 1000,
            status: 'pending',
            email: 'm19@example.com'
        },
        {
            id: '728ed52y',
            amount: 1050,
            status: 'completed',
            email: 'm20@example.com'
        }
    ]
}

onMounted(async () => {
    data.value = await getData()
})

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
            <DataTable :columns="columns" :data="data" />
        </div>
    </AppLayout>
</template>
