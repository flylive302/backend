<script setup lang="ts">
import { TransitionRoot } from '@headlessui/vue';
import { useForm } from '@inertiajs/vue3';
import { IKImage } from 'imagekitio-vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import {Card, CardContent, CardHeader} from "@/components/ui/card";
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput, } from '@/components/ui/number-field'
import Avatar from '@/components/Avatar.vue';
import TimePicker from '@/components/TimePicker.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Frame Create',
        href: route('frame.create'),
    },
];

const form = useForm({
    name: '',
    price: 0,
    valid_duration: 0,
    static_src: '',
    animated_src: '',
    status: 0,
    valid_duration: null
});

const submit = () => {
    form.post(route('frame.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card class="m-6">
            <CardHeader>
                Frame Create
            </CardHeader>
            <CardContent>
                <Card v-if="form.static_src" class="rounded p-4 flex items-center mb-4 space-x-4">
                    <IKImage
                        urlEndpoint="https://ik.imagekit.io/flylive/siteAssets/frames"
                        :path="form.static_src"
                        :transformation="[{ width: 100, height: 95 }]"
                        class="size-15"
                        width="100" height="95"
                    />

                    <Avatar
                        v-if="form.animated_src"
                        :frameSrc="form.animated_src"
                        profileSrc="/default-image.jpg"
                        frameSize="100"
                        profileSize="100"
                        alt="Profile Picture"
                        :isAnimated="true"
                        :size="6"
                        :profileDifference="1.4"
                        :frameDifference="1.2"
                    />
                </Card>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <NumberField id="number" :default-value="0" v-model="form.price"
                            :format-options="{
                              signDisplay: 'exceptZero',
                              minimumFractionDigits: 1,
                            }"
                        >
                            <Label for="number">Price</Label>
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>
                        <InputError class="mt-2" :message="form.errors.price" />
                    </div>


                    <div class="grid gap-2">
                        <Label for="static_src">Static Src</Label>
                        <Input
                            id="static_src" required autocomplete="static_src" placeholder="Static Src full Path"
                            class="mt-1 block w-full" @blur="(event: InputEvent) => form.static_src = (event.target as HTMLInputElement).value"
                        />
                        <InputError class="mt-2" :message="form.errors.static_src" />
                    </div>


                    <div class="grid gap-2">
                        <Label for="animated_src">Animated Src</Label>
                        <Input
                            id="animated_src" required autocomplete="animated_src" placeholder="Animated Src Name Only"
                            class="mt-1 block w-full" @blur="(event: InputEvent) => form.animated_src = (event.target as HTMLInputElement).value"
                        />
                        <InputError class="mt-2" :message="form.errors.animated_src" />
                    </div>

                    <div class="grid gap-2">
                        <p>{{form.valid_duration}} in parent</p>
                        <TimePicker @update:totalTime="(event) => form.valid_duration = event" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Save</Button>

                        <TransitionRoot
                            :show="form.recentlySuccessful"
                            enter="transition ease-in-out"
                            enter-from="opacity-0"
                            leave="transition ease-in-out"
                            leave-to="opacity-0"
                        >
                            <p class="text-sm text-neutral-600">Saved.</p>
                        </TransitionRoot>
                    </div>
                </form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
