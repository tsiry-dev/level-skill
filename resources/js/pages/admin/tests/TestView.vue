<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    activities: Array
});


console.log(props.activities);



</script>

<template>

<div class="flex items-center justify-between">
    <SubTitle>
        Liste des tests
    </SubTitle>

    <Link :href="route('admin.test.create')" class="btn btn-gradient btn-secondary">Nouveau</Link>
</div>

<div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 lg:grid-cols-3">
    <Link :href="route('admin.activitie.show', activity.slug)" v-for="activity in props.activities" :key="activity.id">
        <div class="bg-green-400 p-10 rounded-2xl text-black flex items-center justify-between">
            <span class="text-2xl text-white">{{ activity.title }} ({{ activity.activity_types_count }})</span>
        </div>
    </Link>
</div>
</template>

<style scoped>
</style>
