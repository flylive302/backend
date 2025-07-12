<script setup>
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const errors = ref();

watch(
    () => usePage().props.errors,
    (newErrors) => {
        if (newErrors && Object.keys(newErrors).length > 0) {
            errors.value = newErrors;
            setTimeout(() => {
                errors.value = undefined;
            }, 2500);
        }
    },
    { immediate: true }
);
</script>
<template>
    <div v-if="errors" class="bg-destructive p-4 rounded-xl shadow-xl shadow-destructive/60">
        <p v-for="(error, key) in errors" :key="key" class="text-white text-2xl">{{ error }}</p>
    </div>
</template>
