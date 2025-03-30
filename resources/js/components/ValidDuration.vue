<template>
    <span>{{ formattedDuration }}</span>
</template>
<script lang="ts" setup>
import { computed } from 'vue';

const props = defineProps({
    totalSeconds: {
        required: true,
        default: 1200,
        type: Number
    }
});
const formattedDuration = computed(() => {
    // Work with a local copy so we don't modify the original value.
    let secondsLeft = props.totalSeconds;

    if (secondsLeft == 0) {
        return 'Forever Valid';
    }

    // Calculate each time unit.
    const weeks = Math.floor(secondsLeft / (7 * 24 * 3600));
    secondsLeft %= (7 * 24 * 3600);

    const days = Math.floor(secondsLeft / (24 * 3600));
    secondsLeft %= (24 * 3600);

    const hours = Math.floor(secondsLeft / 3600);
    secondsLeft %= 3600;

    const minutes = Math.floor(secondsLeft / 60);
    const seconds = secondsLeft % 60;

    // Build the formatted string. Only add parts that are non-zero.
    const parts = [];
    if (weeks > 0) {
        parts.push(`${weeks} w`);
    }
    if (days > 0) {
        parts.push(`${days} d`);
    }
    if (hours > 0) {
        parts.push(`${hours} h`);
    }
    if (minutes > 0) {
        parts.push(`${minutes} m`);
    }
    if (seconds > 0) {
        parts.push(`${seconds} s`);
    }

    // Join the parts with a space (or any separator you prefer)
    return parts.join(' ');
});
</script>
