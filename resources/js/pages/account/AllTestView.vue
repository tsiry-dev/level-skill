<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
<h1 class="text-3xl text-green-600">Selectionner un type de test</h1>

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
