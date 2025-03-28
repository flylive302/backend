<script lang="ts" setup>
import type { BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Avatar from '@/components/Avatar.vue';
import Icon from '@/components/Icon.vue';
import { Button } from '@/components/ui/button';
import { computed } from 'vue';

interface User {
    name: string;
    avatar_image?: string;
}

interface CoinRequests {
    user: User;
    amount: number;
    message?: string;
    type: number;
    proof_1?: string;
    proof_2?: string;
    proof_3?: string;
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

const Page = usePage().props;

const can = computed(() => Page.can as Record<string, boolean>);

</script>

<template>

    <Head :title="`${coinRequest.user.name} Requested ${coinRequest.amount} Coins for`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="border-2 overflow-auto rounded-lg m-6">

            <div class="m-4 flex flex-col md:flex-row items-center gap-2">
                <Avatar
                    :frameDifference="0"
                    :profileDifference="0"
                    :profileSrc="coinRequest.user?.avatar_image ? coinRequest?.user?.avatar_image : '/default-image.jpg'"
                    :size="6"
                    alt="Profile Picture"
                    class="min-w-[100px] min-h-[100px]"
                    frameSize="100"
                    profileSize="100"
                />
                <h1 class="text-2xl text-green-500 font-bold">
                    {{ coinRequest.user.name }} Requested {{ Math.round(coinRequest.amount) }} Coins
                </h1>
            </div>
            <p v-if="coinRequest.user_id != Page.auth.user.id" class="ml-4 text-yellow-500">
                Please Review the Request and take Action Very Carefully...
                <br>
                Because you will be held responsible for any action you take.
            </p>
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
                    <TableRow v-if="coinRequest.proof_1">
                        <TableCell>
                            <h2 class="text-lg font-bold">1st Proof of Payment:</h2>
                        </TableCell>
                        <TableCell>
                            <img :src="`../../../../storage/${coinRequest.proof_1}`" alt=""
                                 class="h-[500px] rounded-lg shadow-md">
                        </TableCell>
                    </TableRow>
                    <TableRow v-if="coinRequest.proof_2">
                        <TableCell>
                            <h2 class="text-lg font-bold">2nd Proof of Payment:</h2>
                        </TableCell>
                        <TableCell>
                            <img :src="`../../../../storage/${coinRequest.proof_2}`" alt=""
                                 class="h-[500px] rounded-lg shadow-md">
                        </TableCell>
                    </TableRow>
                    <TableRow v-if="coinRequest.proof_3">
                        <TableCell>
                            <h2 class="text-lg font-bold">3rd Proof of Payment:</h2>
                        </TableCell>
                        <TableCell>
                            <img :src="`../../../../storage/${coinRequest.proof_3}`" alt=""
                                 class="h-[500px] rounded-lg shadow-md">
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

            <div v-if="coinRequest.user_id != Page.auth.user.id" class="flex mt-5">
                <Button class="w-full rounded-none" variant="success">Approve</Button>
                <Button class="w-full rounded-none" variant="destructive">Reject</Button>
            </div>
        </div>
    </AppLayout>
</template>
