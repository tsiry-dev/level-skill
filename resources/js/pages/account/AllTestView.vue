<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    activities: Array,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

console.log(props.activities);


</script>

<template>
<h1 class="text-3xl text-green-600">Selectionner un type de test</h1>

<div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 lg:grid-cols-3">
    <div v-for="activity in activities" :key="activity.id" class="bg-green-400 rounded-2xl text-black flex items-center justify-between">
        <Link :href="route('account.test.show', activity)">
            <div class="bg-green-400 p-2 rounded-2xl text-black flex items-center justify-between">
                <span class="text-2xl text-white">
                    {{ activity.title }}
                </span>
            </div>
        </Link>
    </div>
</div>

</template>

<style scoped>
</style>
