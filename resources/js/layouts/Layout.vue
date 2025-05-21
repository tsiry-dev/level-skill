<script setup>
import Sidebar from '@/components/Sidebar.vue';

const props = defineProps({
  errors: Object,
  name: String,
  quote: Object,
  auth: Object,
  ziggy: Object,
  sidebarOpen: Boolean,
});

</script>


<template>

<Sidebar />

<main class="p-4 sm:ml-64">
    <slot />
</main>
</template>

<style scoped>
</style>
