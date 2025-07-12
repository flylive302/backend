<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { Label } from '@/components/ui/label/index.js';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue
} from '@/components/ui/select/index.js';

// Reactive references for each time unit
const weeks = ref(0);
const days = ref(0);
const hours = ref(0);
const minutes = ref(0);
const seconds = ref(0);

const emit = defineEmits<{
    (e: 'update:totalTime', payload: number): void;
}>();

// Computed property to calculate the total duration in seconds
const totalSeconds = computed(() => {
    const totalDays = weeks.value * 7 + days.value;
    return (
        totalDays * 86400 + // 86400 seconds in a day
        hours.value * 3600 +
        minutes.value * 60 +
        seconds.value
    );
});

// Watchers to ensure input values remain within valid ranges
watch(weeks, (newVal) => {
    if (newVal > 4) weeks.value = 4;
    if (newVal < 0) weeks.value = 0;
    emit('update:totalTime', totalSeconds.value);
});

watch(days, (newVal) => {
    if (newVal > 6) days.value = 6;
    if (newVal < 0) days.value = 0;
    emit('update:totalTime', totalSeconds.value);
});

watch(hours, (newVal) => {
    if (newVal > 23) hours.value = 23;
    if (newVal < 0) hours.value = 0;
    emit('update:totalTime', totalSeconds.value);
});

watch(minutes, (newVal) => {
    if (newVal > 59) minutes.value = 59;
    if (newVal < 0) minutes.value = 0;
    emit('update:totalTime', totalSeconds.value);
});

watch(seconds, (newVal) => {
    if (newVal > 59) seconds.value = 59;
    if (newVal < 0) seconds.value = 0;
    emit('update:totalTime', totalSeconds.value);
});
</script>
<template>
    <div class="flex gap-2">
        <div>
            <Label for="Weeks">Weeks:</Label>
            <Select v-model.number="weeks" id="Weeks">
                <SelectTrigger>
                    <SelectValue placeholder="0" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem v-for="week in 52" :key="week" :value="week">
                            {{ week }}
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
        <div>
            <Label for="Days">Days:</Label>
            <Select v-model.number="days" id="Days">
                <SelectTrigger>
                    <SelectValue placeholder="0" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem v-for="day in 30" :key="day" :value="day">
                            {{ day }}
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
        <div>
            <Label for="Hours">Hours:</Label>
            <Select v-model.number="hours" id="Hours">
                <SelectTrigger>
                    <SelectValue placeholder="0" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem v-for="hour in 24" :key="hour" :value="hour">
                            {{ hour }}
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
        <div>
            <Label for="Minutes">Minutes:</Label>
            <Select v-model.number="minutes" id="Minutes">
                <SelectTrigger>
                    <SelectValue placeholder="0" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem v-for="minute in 60" :key="minute" :value="minute">
                            {{ minute }}
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
        <div>
            <Label for="Seconds">Seconds:</Label>
            <Select v-model.number="seconds" id="Seconds">
                <SelectTrigger>
                    <SelectValue placeholder="0" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem v-for="second in 60" :key="second" :value="second">
                            {{ second }}
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
    </div>
</template>
