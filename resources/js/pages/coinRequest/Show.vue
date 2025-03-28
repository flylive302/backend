<script lang="ts" setup>
import type { BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Avatar from '@/components/Avatar.vue';
import Icon from '@/components/Icon.vue';

interface User {
    name: string;
    avatar_image?: string;
}

interface CoinRequests {
    user: User;
    amount: number;
    message?: string;
    type: number; // Adding 'type' property to match its usage in the template
}

const props = defineProps<{
    coinRequest: CoinRequests;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Coin Request',
        href: route('coinRequest.create')
    }
];

const excludedKeys = [
    'id',
    'user_id',
    'requested_from',
    'user'
];
</script>

<template>

    <Head title="Coin Request" />

    <AppLayout>
        <div class="border-2 overflow-auto rounded-lg m-6">
            <div class="m-4 flex flex-col justify-center items-center gap-2">
                <Avatar
                    :frameDifference="0"
                    :profileDifference="0"
                    :profileSrc="coinRequest.user?.avatar_image ? coinRequest?.user?.avatar_image : '/default-image.jpg'"
                    :size="6"
                    alt="Profile Picture"
                    frameSize="100"
                    profileSize="100"
                />
            </div>
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Key</TableHead>
                        <TableHead>Value</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow>
                        <TableCell>
                            <h2 class="text-lg font-bold">This Request was created by:</h2>
                        </TableCell>
                        <TableCell>
                            <div class="font-bold bg-yellow-500/10 p-2 text-center rounded shadow">
                                {{ coinRequest.user.name }}
                            </div>
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell>
                            <h2 class="text-lg font-bold">Request Type:</h2>
                        </TableCell>
                        <TableCell>
                            <div v-if='coinRequest.type == 1'
                                 class="rounded-md flex justify-center gap-2 items-center p-2 font-bold bg-green-500/20">
                                <Icon class="size-6" name="CircleDollarSign" />
                                Cash
                            </div>
                            <div v-if='coinRequest.type == 2'
                                 class="rounded-md flex justify-center gap-2 items-center p-2 font-bold bg-yellow-500/10">
                                <Icon class="size-6" name="HelpingHand" />
                                Credit
                            </div>
                        </TableCell>
                    </TableRow>
                    <TableRow>
                        <TableCell>
                            <h2 class="text-lg font-bold">For Amount of:</h2>
                        </TableCell>
                        <TableCell>
                            <div class="font-bold bg-yellow-500/10 p-2 text-center rounded shadow">
                                {{ Math.round(coinRequest.amount) }} Coins
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
            <div v-if="coinRequest.message" class="px-4 my-2">
                <h2 class="text-lg font-bold">Have a Message is:</h2>
                <div class="rounded-md flex justify-center gap-2 items-center p-2 font-bold bg-yellow-500/10">
                    {{ coinRequest.message }}
                </div>
            </div>
        </div>
    </AppLayout>
</template>
