<script lang="ts" setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Icon from '@/components/Icon.vue';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput
} from '@/components/ui/number-field';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create New Coin Request',
        href: route('coinRequest.create')
    }
];

interface CoinRequest {
    type: number | null;
    amount: number | null;
    message: string;
    proof_1: File | null;
    proof_2: File | null;
    proof_3: File | null;
    credit_days: number | null;

    [key: string]: string | File | number | null; // Ensure index signature satisfies FormData constraints
}

const form = useForm<CoinRequest>({
    type: 1,
    amount: 1000,
    credit_days: 7,
    message: '',
    proof_1: null,
    proof_2: null,
    proof_3: null
});

let loading = false;

const submit = () => {
    loading = true;
    form.post(route('coinRequest.store'), {
        preserveScroll: true
    });
    loading = false;
};
</script>

<style scoped>
.type-button {
    @apply shadow-xl rounded-md flex flex-col justify-center items-center w-full py-4 text-2xl font-bold;
}

.type-button:hover, .type-button:focus {
    box-shadow: inset 0 0 100px 10px rgba(0, 246, 255, 0.15);
}
</style>

<template>
    <Head title="Create New Coin Request" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-6 w-full md:w-6/12 p-4 border-2 rounded-md shadow-md">
            <h1 class="text-2xl font-bold">Create New Request</h1>
            <h2 class="text-xl font-bold mt-4">Type of Request</h2>

            <div v-for="error in form.errors" :key="error">
                <InputError :message="error" class="mt-2" />
            </div>
            <div class="flex gap-4 mt-2">
                <button class="type-button" @click="form.type = 1">
                    <Icon class="size-14 text-green-500" name="CircleDollarSign" />
                    Cash
                </button>
                <button class="type-button" @click="form.type = 2">
                    <Icon class="size-14 text-yellow-500" name="HelpingHand" />
                    Credit
                </button>
            </div>

            <div class="mt-4">
                <h2 class="text-xl font-bold mb-6 text-green-500">Cash Request</h2>
                <form class="space-y-6" @submit.prevent="submit">
                    <div class="grid gap-2">
                        <NumberField id="amount" v-model="form.amount" :default-value="1000" :min="0">
                            <Label for="amount">Amount in Coins</Label>
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>
                        <InputError :message="form.errors.amount" class="mt-2" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="message">Message (Optional)</Label>
                        <Input id="message" v-model="form.message" autocomplete="message" class="mt-1 block w-full"
                               placeholder="Full message"
                               required />
                        <InputError :message="form.errors.message" class="mt-2" />
                    </div>

                    <div v-if="form.type == 1" class="flex-col md:flex gap-4">
                        <div class="grid w-full max-w-sm items-center gap-1.5">
                            <Label for="proof_1">Proof Image or PDF 1 ( Optional )</Label>
                            <Input
                                id="proof_1"
                                accept=".png,.webp,.jpg,.jpeg,.pdf"
                                type="file"
                                @change="(e: Event) => form.proof_1 = (e.target as HTMLInputElement).files?.[0] || null"
                            />
                            <InputError :message="form.errors.proof_1" class="mt-2" />
                        </div>
                        <div class="grid w-full max-w-sm items-center gap-1.5">
                            <Label for="proof_2">Proof Image or PDF 2 ( Optional )</Label>
                            <Input
                                id="proof_2"
                                accept=".png,.webp,.jpg,.jpeg,.pdf"
                                type="file"
                                @change="(e: Event) => form.proof_2 = (e.target as HTMLInputElement).files?.[0] || null"
                            />
                            <InputError :message="form.errors.proof_2" class="mt-2" />
                        </div>
                        <div class="grid w-full max-w-sm items-center gap-1.5">
                            <Label for="proof_3">Proof Image or PDF 3 ( Optional )</Label>
                            <Input
                                id="proof_3"
                                accept=".png,.webp,.jpg,.jpeg,.pdf"
                                type="file"
                                @change="(e: Event) => form.proof_3 = (e.target as HTMLInputElement).files?.[0] || null"
                            />
                            <InputError :message="form.errors.proof_3" class="mt-2" />
                        </div>
                    </div>


                    <div v-else class="grid gap-2">
                        <NumberField id="credit_days" v-model="form.credit_days" :default-value="7" :min="0">
                            <Label for="credit_days">Credit Days you need for Coins</Label>
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>
                        <InputError :message="form.errors.credit_days" class="mt-2" />
                    </div>

                    <Button class="w-full" size="lg" type="submit" @click="submit">Make A Request</Button>
                </form>
            </div>

        </div>
    </AppLayout>
</template>
