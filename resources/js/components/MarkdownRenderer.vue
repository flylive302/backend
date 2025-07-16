<template>
  <div v-html="compiled" class="prose prose-zinc dark:prose-invert max-w-4xl mx-auto" />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { marked } from 'marked';
// Optionally, use DOMPurify for sanitization if available
// import DOMPurify from 'dompurify';

const props = defineProps<{ source: string }>();

const compiled = computed(() => {
  if (!props.source) return '';
  // Optionally sanitize: DOMPurify.sanitize(marked.parse(props.source))
  return marked.parse(props.source);
});
</script> 