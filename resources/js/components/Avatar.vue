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
})
const urlEndpoint = 'https://ik.imagekit.io/flylive/'
</script>

<template>
    <Link :href="goTo" class="overflow-hidden flex items-center justify-center"
          :style="`width: ${size}rem; height: ${size}rem;`"
    >

        <div class="flex items-center justify-center relative p-0 w-full h-full"
             :style="`width: ${size - profileDifference}rem; height: ${size - profileDifference}rem;`"
        >
            <IKImage
                :urlEndpoint="urlEndpoint"
                :path="profileSrc" :alt="alt"
                :transformation="[{ width: profileSize, height: profileSize }]"
                class="absolute rounded-full size-full"
            />

            <SvgaPlayer
                v-if="isAnimated"
                :name="frameSrc"
                :loop="0" class="absolute"
                :canvas_width="`${size + frameDifference}rem`"
                :canvas_height="`${size + frameDifference}rem`"
            />

            <IKImage
                v-else
                :urlEndpoint="urlEndpoint"
                :path="`/siteAssets/frames/${frameSrc}`" :alt="alt"
                :transformation="[{ width: frameSize, height: frameSize }]"
                :style="`min-width: ${size + frameDifference}rem;max-width: ${size + frameDifference}rem;height: ${size + frameDifference}rem;position: absolute`"
            />
        </div>

  </Link>
</template>
