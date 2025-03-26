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

const props = defineProps({
    user: Object as () => User
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'View Users',
        href: `/user/${props.user?.id}`
    }
];
</script>

<template>
    <Head title="Users Show - {{ user.name }}" />
    <AppLayout :breadcrumbs="breadcrumbs">
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
                            <TableCell v-if="key !== ('roles' as any) && key !== ('frames' as any)">
                                {{ key }}
                            </TableCell>
                            <TableCell v-if="key !== ('roles' as any) && key !== ('frames' as any)">
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
                                <TableCell v-else class="space-x-2">
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
                    <button
                        v-for="(frame, index) in user?.frames" :key="index"
                        class="
                        bg-foreground/10 shadow-md
                        focus:bg-secondary/10 dark:focus:bg-secondary/20
                        focus:shadow-inner focus:ring focus:ring-primary/50
                        text-center cursor-pointer rounded-sm overflow-hidden
                        transition-all duration-300 ease-in-out"
                    >
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
    </AppLayout>
</template>

<!--

<TableCell v-if="index == 'avatar_image'">
    <Avatar
        :frameDifference="1.2"
        :frameSrc="form.animated_src"
        :isAnimated="true"
        :profileDifference="1.4"
        :size="6"
        alt="Profile Picture"
        frameSize="100"
        profileSize="100"
        profileSrc="/default-image.jpg"
    />
</TableCell>

-->
