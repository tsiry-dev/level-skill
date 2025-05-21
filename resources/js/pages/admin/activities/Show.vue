<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    activityType: Object
});


</script>

<template>
  <SubTitle>
    {{ props.activityType.name }}
  </SubTitle>

  <div v-if="questions.length" class="flex justify-between mb-4">
    <h2 class="text-4xl mb-5">title</h2>
    <div class="h-[4rem] w-[4rem] bg-red-600 text-white rounded-full flex items-center justify-center cursor-pointer">
      15
    </div>
  </div>

    <li

      class="bg-gray-100 border-2 border-gray-300 rounded-lg p-4 cursor-pointer mb-2"
    >
      <label>
        test
      </label>
    </li>

</template>

<style scoped>
</style>
