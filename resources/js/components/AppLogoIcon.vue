<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
  <span class="bg-purple-500 py-2 px-5 rounded-2xl text-white">Skill Power</span>
</template>
