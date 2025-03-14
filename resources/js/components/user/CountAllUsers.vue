<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>Total Number of Users in the App </CardTitle>
        </CardHeader>
        <CardContent class="h-full text-3xl">
            <slot />
        </CardContent>
    </Card>
</template>
