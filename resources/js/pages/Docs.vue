<template>
  <AppLayout>
    <div class="flex min-h-screen bg-white dark:bg-zinc-900">
      <!-- Sidebar -->
      <aside class="w-72 border-r border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900 p-6">
        <div class="mb-8 flex items-center gap-2">
          <AppLogoIcon class="size-8" />
          <span class="font-bold text-xl tracking-tight">FlyLive Docs</span>
        </div>
        <nav class="flex flex-col gap-2">
          <Link v-for="item in navItems" :key="item.file" :href="`/docs?doc=${item.file}`" :class="{ 'font-semibold text-primary': currentDoc === item.file }">
            {{ item.title }}
          </Link>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 p-8 overflow-y-auto">
        <div v-if="loading" class="text-center text-lg text-muted-foreground">Loading...</div>
        <div v-else>
          <component :is="MarkdownRenderer" :source="docContent" class="prose max-w-4xl mx-auto" />
        </div>
      </main>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, watch, onMounted, defineAsyncComponent } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';

const navItems = [
  { title: 'Introduction', file: '00-introduction.md' },
  { title: 'Environment Setup', file: '01-development-environment-setup.md' },
  { title: 'Config & Build', file: '02-config-and-build.md' },
  { title: 'Third-Party Integrations', file: '03-third-party-integrations.md' },
  { title: 'Data Flow & State', file: '04-data-flow-and-state.md' },
  { title: 'API Endpoints', file: '05-api-endpoints.md' },
  { title: 'Modules & Functions', file: '06-modules-and-functions.md' },
  { title: 'Codebase Analysis', file: '07-codebase-analysis-and-rebuild.md' },
  { title: 'Business Feedback', file: '08-phase3-interactive-feedback.md' },
  { title: 'Rebuild Proposal', file: '09-rebuild-proposal.md' },
  { title: 'AI Agent Index', file: 'ai-index.md' },
];

const getDocFromQuery = () => {
  const params = new URLSearchParams(window.location.search);
  return params.get('doc') || '00-introduction.md';
};

const currentDoc = ref(getDocFromQuery());
const docContent = ref('');
const loading = ref(false);

const MarkdownRenderer = defineAsyncComponent(() => import('../components/MarkdownRenderer.vue'));

async function loadDoc(file: string) {
  loading.value = true;
  try {
    const modules = import.meta.glob('../../../docs/*.md', { as: 'raw' });
    const path = `../../../docs/${file}`;
    if (modules[path]) {
      docContent.value = await modules[path]();
    } else {
      docContent.value = '# Not Found\nThe requested documentation page does not exist.';
    }
  } catch (e) {
    docContent.value = '# Error\nFailed to load documentation.';
  }
  loading.value = false;
}

function handlePopState() {
  currentDoc.value = getDocFromQuery();
  loadDoc(currentDoc.value);
}

onMounted(() => {
  window.addEventListener('popstate', handlePopState);
  loadDoc(currentDoc.value);
});

watch(currentDoc, (newDoc) => {
  loadDoc(newDoc);
});
</script>

<style scoped>
.prose {
  @apply text-zinc-900 dark:text-zinc-100 max-w-4xl mx-auto bg-white dark:bg-zinc-900 p-8 rounded-lg shadow;
}
aside {
  @apply text-zinc-900 dark:text-zinc-100 border-r border-zinc-200 dark:border-zinc-800;
}
nav a {
  @apply transition-colors hover:text-primary focus:text-primary px-2 py-1 rounded;
}
nav a.font-semibold {
  @apply text-primary bg-zinc-100 dark:bg-zinc-800;
}
</style> 