<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';


const props = defineProps({
    categoryTests: Array,
    errors: Object,
    auth: Object,
    ziggy: Object,
});

const categoryTests = ref(props.categoryTests || []);


</script>

<template>
<div class="flex items-center justify-between">
    <SubTitle>
       Categories des tests
    </SubTitle>

    <Link :href="route('admin.tests.create')" class="btn btn-gradient btn-secondary">Nouveau</Link>
</div>


<div class="mt-5 p-5 bg-white rounded-lg shadow-md">
    <ul>
        <li v-for="category in categoryTests" :key="category.id">
            <span>{{ category.name }}</span>
        </li>
    </ul>
</div>
</template>

<style scoped>
</style>
