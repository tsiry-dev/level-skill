<script setup>
import { Head } from '@inertiajs/vue3';
</script>

<template>
<Head title="Tests" />

<div class="w-full overflow-x-auto">
  <table class="table">
    <thead>
      <tr>
        <th>Type</th>
        <th>Category</th>
        <th>Points</th>
        <th>Actions</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Quiz</td>
        <td>Conjugaison</td>
        <td><span class="badge badge-soft badge-success text-xs">12</span></td>
        <td>March 1, 2024</td>
        <td>
          <button class="btn btn-circle btn-text btn-sm" aria-label="Action button">
            <i class="pi pi-pen-to-square"></i>
          </button>
          <button class="btn btn-circle btn-text btn-sm" aria-label="Action button">
            <i class="pi pi-trash"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</div>
</template>

<style scoped>
</style>
