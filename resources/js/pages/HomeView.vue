<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div class="max-w-[70rem] mx-auto mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4">
              <div class="p-9 bg-purple-700 rounded-2xl">
                  <h1>
                      <div class="text-white text-4xl mt-8">Tester vos compétences avec notre application</div><br>
                      <div class="font-bold text-white text-4xl">
                          <span class="text-8xl">SKILL <br> POWER</span>
                      </div>
                  </h1>
              </div>
              <div class="p-3 bg-green-500 rounded-2xl">
                  <h2 class="text-white text-2xl mt-10 text-center">S'authentifier</h2>

                  <div class="mt-6">
                      <Link :href="route('login')" class="w-[100%] btn btn-gradient btn-secondary mb-4">Conexion</Link>
                      <Link :href="route('login')" class="w-[100%] btn btn-gradient btn-secondary">Inscription</Link>
                  </div>
              </div>
        </div>
    </div>
</template>

<style scoped lang="scss">


</style>
