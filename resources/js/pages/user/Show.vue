<script lang="ts" setup>
import { type BreadcrumbItem, User } from '@/types';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';

import { IKImage } from 'imagekitio-vue';
import ValidDuration from '@/components/ValidDuration.vue';
import Icon from '@/components/Icon.vue';
import { computed } from 'vue';
import Avatar from '@/components/Avatar.vue';

const props = defineProps({
    user: {
        type: Object as () => User,
        required: true
    }
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'View Users',
        href: `/user/${props.user?.id}`
    }
];

const activeFrame = computed(() => {
    return props.user?.frames?.filter((frame: { pivot: { is_active: boolean } }) => frame.pivot.is_active) || [];
});

const excludedKeys = [
    'roles',
    'frames',
    'avatar_image',
    'initiated_transactions',
    'received_transactions'
];

</script>

<style scoped>
.frame-card {
    @apply bg-foreground/10 shadow-md focus:bg-secondary/10 dark:focus:bg-secondary/20
    focus:shadow-inner focus:ring focus:ring-primary/50 text-center cursor-pointer rounded-sm overflow-hidden
    transition-all duration-300 ease-in-out m-2;
}
</style>

<template>
    <Head title="Users Show - {{ user.name }}" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="m-4">
            <div class="m-4">
                <Avatar
                    :frameDifference="1.2"
                    :frameSrc="activeFrame[0]?.animated_src ?? undefined"
                    :isAnimated="activeFrame[0] !== undefined"
                    :profileDifference="1.4"
                    :profileSrc="user?.avatar_image ? user.avatar_image : '/default-image.jpg'"
                    :size="6"
                    alt="Profile Picture"
                    frameSize="100"
                    profileSize="100"
                />
            </div>
            <div class="m-4 grid grid-cols-2 gap-4">
                <div class="border-2 overflow-auto rounded-lg">
                    <h1 class="text-lg font-bold my-2 mx-4">User's Details</h1>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Key</TableHead>
                                <TableHead>Value</TableHead>
                            </TableRow>
                        </TableHeader>

                        <TableBody>
                            <TableRow v-for="(value, key) in user" :key="key">
                                <TableCell
                                    v-if="!excludedKeys.includes(key)">
                                    {{ key }}
                                </TableCell>
                                <TableCell
                                    v-if="!excludedKeys.includes(key)">
                                    {{ value }}
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>

                <div class="space-y-4">
                    <div class="border-2 overflow-auto rounded-lg">
                        <h1 class="text-lg font-bold my-2 mx-4">User's Roles and Their Permissions</h1>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Roles</TableHead>
                                    <TableHead>Permissions</TableHead>
                                </TableRow>
                            </TableHeader>

                            <TableBody>
                                <TableRow v-for="role in user?.roles" :key="role.id">
                                    <TableCell>{{ role.name }}</TableCell>
                                    <TableCell v-if="!role.permissions">{{ role }}</TableCell>
                                    <TableCell v-else class="space-x-2 space-y-2">
                                        <Badge v-for="permission in role.permissions">
                                            {{ permission.name }}
                                        </Badge>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>

                    <div class="border-2 overflow-auto rounded-lg p-4">
                        <h1 class="text-lg font-bold mb-2">Frames</h1>
                        <button v-for="(frame, index) in user?.frames" :key="index" class="frame-card">
                            <div class="w-full flex gap-2 p-2">
                                <badge v-if="frame.pivot.is_active">Active</badge>
                                <badge>{{ frame.pivot.quantity }}</badge>
                            </div>
                            <IKImage
                                :path="frame.static_src"
                                :transformation="[{ width: 144, height: 144 }]"
                                class="size-36 mx-2 my-2 min-h-32"
                                height="95"
                                urlEndpoint="https://ik.imagekit.io/flylive/siteAssets/frames" width="100"
                            />

                            <p v-if="!frame.valid_duration" class="text-center text-sm">Never Expires</p>
                            <ValidDuration v-else :total-seconds="frame.valid_duration" class="text-foreground" />

                            <Button class="w-full rounded-none">
                                <Icon class="size-5 text-tertiary" name="lucide:coins" />
                                {{ frame.price }}
                            </Button>
                        </button>
                    </div>
                </div>
            </div>

            <div class="border-2 overflow-auto rounded-lg">
                <h1 class="text-lg font-bold my-2 mx-4">Transaction's History of Money Spent</h1>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>id</TableHead>
                            <TableHead>beneficiary ID</TableHead>
                            <TableHead>Transactionable Type</TableHead>
                            <TableHead>Currency Type</TableHead>
                            <TableHead>Quantity</TableHead>
                            <TableHead>Real Value</TableHead>
                            <TableHead>Change In Value</TableHead>
                            <TableHead>Before</TableHead>
                            <TableHead>After</TableHead>
                            <TableHead>Created At</TableHead>
                            <TableHead>Updated At</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow v-for="transaction in user?.initiated_transactions" :key="transaction.id">
                            <TableCell>{{ transaction.id }}</TableCell>
                            <TableCell>{{ transaction.beneficiary_id }}</TableCell>
                            <TableCell>{{ transaction.transactionable_type }}</TableCell>
                            <TableCell>{{ transaction.currency_type }}</TableCell>
                            <TableCell>{{ transaction.quantity }}</TableCell>
                            <TableCell>{{ transaction.real_value }}</TableCell>
                            <TableCell>{{ transaction.change_in_value }}</TableCell>
                            <TableCell>{{ transaction.before }}</TableCell>
                            <TableCell>{{ transaction.after }}</TableCell>
                            <TableCell>{{ transaction.created_at }}</TableCell>
                            <TableCell>{{ transaction.updated_at }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <div class="border-2 mt-4 overflow-auto rounded-lg">
                <h1 class="text-lg font-bold my-2 mx-4">Transaction's History of Money Received</h1>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>id</TableHead>
                            <TableHead>User ID</TableHead>
                            <TableHead>Item Involved</TableHead>
                            <TableHead>Currency Type</TableHead>
                            <TableHead>Quantity</TableHead>
                            <TableHead>Real Value</TableHead>
                            <TableHead>Change In Value</TableHead>
                            <TableHead>Before</TableHead>
                            <TableHead>After</TableHead>
                            <TableHead>Created At</TableHead>
                            <TableHead>Updated At</TableHead>
                        </TableRow>
                    </TableHeader>

                    <TableBody>
                        <TableRow v-for="transaction in user?.initiated_transactions" :key="transaction.id">
                            <TableCell>{{ transaction.id }}</TableCell>
                            <TableCell>{{ transaction.user_id }}</TableCell>
                            <TableCell>{{ transaction.transactionable_type }}</TableCell>
                            <TableCell>{{ transaction.currency_type }}</TableCell>
                            <TableCell>{{ transaction.quantity }}</TableCell>
                            <TableCell>{{ transaction.real_value }}</TableCell>
                            <TableCell>{{ transaction.change_in_value }}</TableCell>
                            <TableCell>{{ transaction.before }}</TableCell>
                            <TableCell>{{ transaction.after }}</TableCell>
                            <TableCell>{{ transaction.created_at }}</TableCell>
                            <TableCell>{{ transaction.updated_at }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>

