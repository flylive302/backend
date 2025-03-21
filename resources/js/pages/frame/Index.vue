<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import CountAllUsers from '@/components/user/CountAllUsers.vue';
import { columns } from '@/components/frames/columns';
import type { ColumnDef } from '@tanstack/vue-table';
import DataTable from '@/components/ui/DataTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Frames',
        href: route('frame.index'),
    },
];

defineProps({
    count: {
        type: Number,
        required: true,
    },
    frames: {
        type: Array,
        required: true,
    }
});

</script>
<template>
    <Head title="Frames" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">

                <CountAllUsers> {{ count }} </CountAllUsers>

                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">

                </div>

                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <DataTable
                :columns="columns as ColumnDef<unknown, unknown>[]"
                :data="frames"
                filterOn="name"
                :createNewPage="route('frame.create')"
            />
        </div>
    </AppLayout>
</template>
