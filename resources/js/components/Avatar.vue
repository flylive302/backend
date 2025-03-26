<script setup>
import { Link } from '@inertiajs/vue3';
import { IKImage } from 'imagekitio-vue';
import SvgaPlayer from '@/components/SvgaPlayer.vue';

defineProps({
    frameSrc: {
        type: String,
        default: 'default-frame.webp'
    },
    profileSrc: String,
    alt: String,
    frameSize: String,
    profileSize: String,
    size: Number,
    frameDifference: Number,
    profileDifference: Number,
    isAnimated: {
        type: Boolean,
        default: false
    },
    goTo: {
        type: String,
        default: '/profile'
    }
});
const urlEndpoint = 'https://ik.imagekit.io/flylive/';
</script>

<template>
    <Link :href="goTo" :style="`width: ${size}rem; height: ${size}rem;`"
          class="overflow-hidden flex items-center justify-center"
    >

        <div :style="`width: ${size - profileDifference}rem; height: ${size - profileDifference}rem;`"
             class="flex items-center justify-center relative p-0 w-full h-full"
        >
            <IKImage
                :alt="alt"
                :path="profileSrc"
                :transformation="[{ width: profileSize, height: profileSize }]"
                :urlEndpoint="urlEndpoint"
                class="absolute rounded-full size-full"
            />

            <SvgaPlayer
                v-if="isAnimated"
                :canvas_height="`${size + frameDifference}rem`"
                :canvas_width="`${size + frameDifference}rem`" :loop="0"
                :name="frameSrc"
                class="absolute"
            />

            <IKImage
                v-else
                :alt="alt"
                :path="`/siteAssets/frames/${frameSrc}`"
                :style="`min-width: ${size + frameDifference}rem;max-width: ${size + frameDifference}rem;height: ${size + frameDifference}rem;position: absolute`"
                :transformation="[{ width: frameSize, height: frameSize }]"
                :urlEndpoint="urlEndpoint"
            />
        </div>

    </Link>
</template>
