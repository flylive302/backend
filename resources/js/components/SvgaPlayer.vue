<template>
    <canvas ref="canvas" :style="`width: ${canvas_width}; height: ${canvas_height}`"></canvas>
</template>

<script setup lang="ts">
import {onMounted, onUnmounted, ref} from 'vue'
import { useSvgaPlayer } from '@/composables/useSvgaPlayer'

const props = defineProps({
    name: { type: String, default: '1' },
    canvas_width: { type: String, default: '50vw' },
    canvas_height: { type: String, default: '50vw' },
    loop: { type: Number, default: 0 }
})

const canvas = ref<HTMLCanvasElement | null>(null)
const playerInstance = ref<{ destroy: () => void } | null>(null)

onMounted(async () => {
    if (canvas.value) {
        try {
            playerInstance.value = await useSvgaPlayer(canvas.value, props.name!, props.loop!)
        } catch (error) {
            console.error('Error initializing SVGA player:', error)
        }
    }
})

onUnmounted(() => {
    if (playerInstance.value) {
        playerInstance.value.destroy()
        playerInstance.value = null
    }
})
</script>
