<script setup>
import { Head } from '@inertiajs/vue3';


const props = defineProps({
    resultats: Array,
    user: Object,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

console.log(props.resultats);

</script>

<template>
<Head title="Tests" />

<div class="w-full overflow-x-auto">
  <table class="table">
    <thead>
      <tr>
        <th>Category</th>
        <th>Test</th>
        <th>Points</th>
        <th>Temps</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="resultat in resultats" :key="resultat.id">
        <td>Quiz</td>
        <td>{{ resultat.activity_type.name }}</td>
        <td><span class="badge badge-soft badge-success text-xs">{{ resultat.total }}</span></td>
        <td><span class="badge badge-soft badge-success text-xs">60 s</span></td>
      </tr>
    </tbody>
  </table>
</div>
</template>

<style scoped>
</style>
