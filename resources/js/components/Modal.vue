<script setup>

import { useModalStore } from '@/stores/modal';

const props = defineProps({
  errors: Object,
  name: String,
  quote: Object,
  auth: Object,
  ziggy: Object,
  sidebarOpen: Boolean,
});

const modalStore = useModalStore();

console.log('modalStore', modalStore.isActive);


</script>

<template>
  <div
  v-if="modalStore.isActive"
  class="bg-gray-100 p-5 fixed top-[5%] right-[50%] z-50 min-w-[40rem] transform translate-x-[50%] border-1 border-gray-400 rounded-sm ">
     <slot />
  </div>
</template>

<style scoped>
</style>
