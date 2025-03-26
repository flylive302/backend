<script lang="ts" setup>
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from '@/components/ui/dropdown-menu';
import { MoreHorizontal } from 'lucide-vue-next';

defineProps<{
    item: {
        id: string
    },
}>();

defineEmits<{
    (e: 'expand'): void
}>();

function copy(id: string) {
    navigator.clipboard.writeText(id);
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button class="w-8 h-8 p-0" size="icon">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuItem @click="copy(item.id)">
                Copy ID
            </DropdownMenuItem>
            <DropdownMenuItem @click="$emit('expand')">
                Expand
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem>View customer</DropdownMenuItem>
            <DropdownMenuItem>View details</DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
