<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { Link } from '@inertiajs/vue3';

</script>

<template>

<div class="flex items-center justify-between">
    <SubTitle>
        Liste des tests
    </SubTitle>

    <Link href="" class="btn btn-gradient btn-secondary">Secondary</Link>

</div>

<div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 lg:grid-cols-3">
    <Link :href="route('account.test')">
        <div class="bg-green-400 p-10 rounded-2xl text-black flex items-center justify-between">
            <span class="text-5xl text-white">Quiz</span>
        </div>
    </Link>
    <Link :href="route('account.test')">
        <div class="bg-green-400 p-10 rounded-2xl text-black flex items-center justify-between">
            <span class="text-5xl text-white">Quiz</span>
        </div>
    </Link>
    <Link :href="route('account.test')">
        <div class="bg-green-400 p-10 rounded-2xl text-black flex items-center justify-between">
            <span class="text-5xl text-white">Quiz</span>
        </div>
    </Link>
    <Link :href="route('account.test')">
        <div class="bg-green-400 p-10 rounded-2xl text-black flex items-center justify-between">
            <span class="text-5xl text-white">Quiz</span>
        </div>
    </Link>
    <Link :href="route('account.test')">
        <div class="bg-green-400 p-10 rounded-2xl text-black flex items-center justify-between">
            <span class="text-5xl text-white">Quiz</span>
        </div>
    </Link>

</div>
</template>

<style scoped>
</style>
