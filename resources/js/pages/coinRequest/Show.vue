<script lang="ts" setup>
import type { BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Avatar from '@/components/Avatar.vue';
import Icon from '@/components/Icon.vue';
import { computed, ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

interface User {
    name: string;
    avatar_image?: string;
}

interface CoinRequests {
    id: number;
    user: User;
    user_id: number;
    amount: number;
    message?: string;
    type: number;
    status: number;
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

const Page = usePage().props as unknown as {
    auth: { user: { id: number } },
    can: Record<string, boolean>,
};

const can = computed(() => Page.can);

const form = useForm<{
    status: number;
    action_message: string;
}>({
    status: 0,
    action_message: ''
});

const loading = ref(false);
const isRequesting = props.coinRequest.user_id == Page.auth.user.id;

const submit = () => {
    loading.value = true;
    form.patch(route('coinRequest.update', { coinRequest: props.coinRequest.id }), {
        preserveScroll: true
    });
    form.reset();
    loading.value = false;
};
</script>

<style scoped>
.type-button {
    @apply shadow-xl rounded-md flex flex-col justify-center items-center h-32 w-full text-2xl font-bold;
}

.approve-button {
    box-shadow: inset 0 0 30px 10px rgba(22, 255, 3, 0.29);
}

.reject-button {
    box-shadow: inset 0 0 30px 10px rgba(255, 3, 3, 0.29);
}

.type-button:hover, .type-button:focus {
    box-shadow: inset 0 0 100px 10px rgba(0, 246, 255, 0.15);
}
</style>
<template>

    <Head :title="`${coinRequest.user.name} Requested ${coinRequest.amount} Coins for`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex gap-4 m-6">
            <div class="border-2 w-full overflow-auto rounded-lg">
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
                <p v-if="!isRequesting && props.coinRequest.status === 1" class="ml-4 text-yellow-500">
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
                                <h2 class="text-lg font-bold">Status</h2>
                            </TableCell>
                            <TableCell>
                                <div v-if="coinRequest.action_message" class="mb-2">
                                    <h2 class="text-lg">Message:</h2>
                                    <p>{{ coinRequest.action_message }}</p>
                                </div>
                                <div v-if="coinRequest.status == 1"
                                     class="font-bold bg-yellow-500 p-2 text-center rounded shadow">
                                    Pending
                                </div>
                                <div v-if="coinRequest.status == 2"
                                     class="font-bold bg-green-500 p-2 text-center rounded shadow">
                                    Approved
                                </div>
                                <div v-if="coinRequest.status == 3"
                                     class="font-bold bg-destructive p-2 text-center rounded shadow">
                                    Rejected
                                </div>
                            </TableCell>
                        </TableRow>
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
                                <h2 class="text-lg font-bold">This Request was Created at:</h2>
                            </TableCell>
                            <TableCell>
                                <div class="font-bold bg-yellow-500/10 p-2 text-center rounded shadow">
                                    {{ coinRequest.created_at }}
                                </div>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>
                                <h2 class="text-lg font-bold">This Request was Updated at:</h2>
                            </TableCell>
                            <TableCell>
                                <div class="font-bold bg-yellow-500/10 p-2 text-center rounded shadow">
                                    {{ coinRequest.updated_at }}
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
            </div>
            <div v-if="!isRequesting && props.coinRequest.status === 1"
                 class="min-w-[400px] border-2 overflow-auto rounded-lg p-4">
                <h1 class="text-2xl mb-4">Take Action {{ coinRequest.status }}</h1>
                <div v-show="!loading">
                    <div v-show="form.status == 0" class="flex gap-4">
                        <button class="type-button approve-button" @click="form.status = 2">
                            Approve
                        </button>
                        <button class="type-button reject-button" @click="form.status = 3">
                            Reject
                        </button>
                    </div>
                    <form v-show="form.status != 0" @submit.prevent="submit">
                        <Label for="action_message">Message (Optional)</Label>
                        <Input
                            id="action_message" v-model="form.action_message" autocomplete="action_message"
                            class="mt-1 block w-full"
                            placeholder="Full action_message"
                        />
                        <InputError :message="form.errors.action_message" class="mt-2" />

                        <Button class="w-full mt-4" size="lg" type="submit">Submit</Button>
                    </form>
                </div>
                <div
                    v-show="loading"
                    class="w-full h-32 bg-blue-900 text-lg font-bold text-center flex flex-col justify-center items-center">
                    <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <rect fill="currentColor" height="10" rx="1" stroke="currentColor" stroke-width="0.5"
                              width="10"
                              x="1"
                              y="1">
                            <animate id="svgSpinnersBlocksShuffle30" attributeName="x"
                                     begin="0;svgSpinnersBlocksShuffle3b.end"
                                     dur="0.2s" fill="freeze" values="1;13" />
                            <animate id="svgSpinnersBlocksShuffle31" attributeName="y"
                                     begin="svgSpinnersBlocksShuffle38.end"
                                     dur="0.2s" fill="freeze" values="1;13" />
                            <animate id="svgSpinnersBlocksShuffle32" attributeName="x"
                                     begin="svgSpinnersBlocksShuffle39.end"
                                     dur="0.2s" fill="freeze" values="13;1" />
                            <animate id="svgSpinnersBlocksShuffle33" attributeName="y"
                                     begin="svgSpinnersBlocksShuffle3a.end"
                                     dur="0.2s" fill="freeze" values="13;1" />
                        </rect>
                        <rect fill="currentColor" height="10" rx="1" stroke="currentColor" stroke-width="0.5"
                              width="10"
                              x="1"
                              y="13">
                            <animate id="svgSpinnersBlocksShuffle34" attributeName="y"
                                     begin="svgSpinnersBlocksShuffle30.end"
                                     dur="0.2s" fill="freeze" values="13;1" />
                            <animate id="svgSpinnersBlocksShuffle35" attributeName="x"
                                     begin="svgSpinnersBlocksShuffle31.end"
                                     dur="0.2s" fill="freeze" values="1;13" />
                            <animate id="svgSpinnersBlocksShuffle36" attributeName="y"
                                     begin="svgSpinnersBlocksShuffle32.end"
                                     dur="0.2s" fill="freeze" values="1;13" />
                            <animate id="svgSpinnersBlocksShuffle37" attributeName="x"
                                     begin="svgSpinnersBlocksShuffle33.end"
                                     dur="0.2s" fill="freeze" values="13;1" />
                        </rect>
                        <rect fill="currentColor" height="10" rx="1" stroke="currentColor" stroke-width="0.5"
                              width="10"
                              x="13"
                              y="13">
                            <animate id="svgSpinnersBlocksShuffle38" attributeName="x"
                                     begin="svgSpinnersBlocksShuffle34.end"
                                     dur="0.2s" fill="freeze" values="13;1" />
                            <animate id="svgSpinnersBlocksShuffle39" attributeName="y"
                                     begin="svgSpinnersBlocksShuffle35.end"
                                     dur="0.2s" fill="freeze" values="13;1" />
                            <animate id="svgSpinnersBlocksShuffle3a" attributeName="x"
                                     begin="svgSpinnersBlocksShuffle36.end"
                                     dur="0.2s" fill="freeze" values="1;13" />
                            <animate id="svgSpinnersBlocksShuffle3b" attributeName="y"
                                     begin="svgSpinnersBlocksShuffle37.end"
                                     dur="0.2s" fill="freeze" values="1;13" />
                        </rect>
                    </svg>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
