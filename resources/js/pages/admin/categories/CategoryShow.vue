<script setup>

import SubTitle from '@/components/SubTitle.vue';
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    categoryTest: Object,
    errors: Object,
    auth: Object,
    ziggy: Object,
});

const activities = computed(() => props.categoryTest?.activities || []);

console.log(props.categoryTest);


</script>

<template>

<div class="flex items-center justify-between">
    <SubTitle>
       {{ categoryTest?.name }} ({{ categoryTest?.activities.length }})
    </SubTitle>

    <Link :href="route('admin.categories.index')" class="btn btn-gradient btn-secondary">
        <i class="pi pi-arrow-left"></i>
        Retour
    </Link>
</div>

  <table class="table">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Questions</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="activity in activities" :key="activity.id">
        <td >
            <span  class="underline underline-offset-2">
                {{ activity?.title }}
            </span>
        </td>
        <td>
          <span
            class="bg-green-300 text-green-700 text-sm px-2 py-1 rounded-lg font-extrabold`"
          >
            {{ activity?.activity_types.length }}
          </span>
        </td>
        <td class="flex items-center gap-2">
            <span class="">
                <i class="pi pi-eye text-green-500 text-lg cursor-pointer"></i>
            </span>
          <i class="pi pi-pen-to-square text-blue-500 text-lg cursor-pointer"></i>
          <i
          class="pi pi-trash text-red-600 text-lg cursor-pointer"></i>
        </td>
      </tr>
    </tbody>
  </table>

</template>

<style scoped>
</style>
