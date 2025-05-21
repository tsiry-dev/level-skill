<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { usePage } from '@inertiajs/vue3';


const page = usePage();

console.log(page.props.auth.user);

</script>

<template>
    <SubTitle>Statistiques</SubTitle>
</template>

<style scoped>
</style>
