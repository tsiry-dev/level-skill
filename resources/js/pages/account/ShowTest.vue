<script setup>

import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    activity: Object,
    activities: Object,
    activityTypeStory: Array,
    user: Object,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

const activity = ref(props.activity || {});
const activityTypes = ref(props.activity?.activity_types || []);
const activityTypeStory = ref(props.activityTypeStory || []);

console.log(props.activity);

console.log(activityTypes);
console.log(props.activityTypeStory);



</script>

<template>
<nav class="flex items-center gap-2 text-lg">
   <span>
       <Link :href="route('account.test.all')">
            Tests
       </Link>
   </span>
   <span>
      <i class="pi pi-arrow-right"></i>
   </span>
   <span>
       {{ activity?.title }}
   </span>
</nav>

<main class=" grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mt-4">
    <div v-for="activityType in activityTypes" :key="activityType.id" class="">
        <div class="bg-green-400 rounded-sm p-2 text-black flex items-center justify-between">

            <span
                 v-if="activityTypeStory.find(story => story.user_id === auth.user.id && story.activity_type_id === activityType.id)"
                 class="flex gap-3 text-lg text-white">
                <button class="bg-red-200 text-red-700 text-sm font-bold rounded-sm px-2 py-1">Terminer</button>
            </span>

            <span
            v-else
            :class="`h-[2rem] w-[2rem] text-white ${activityType.status ? 'bg-green-600' : 'bg-red-500'} flex items-center justify-center rounded-full text-lg`">
                <i v-if="activityType.status === 1" class="pi pi-unlock"></i>
                <i v-if="activityType.status === 0" class="pi pi-lock"></i>
            </span>


            <Link
                :href="route('account.activityType.show', {activities: activity, activityType: activityType})"
                    v-if="activityType.status === 1" class="text-lg text-white">
                {{ activityType.name }}
            </Link>
            <span v-else class="text-lg text-white">
                {{ activityType.name }}
            </span>

        </div>
    </div>
</main>

</template>

<style scoped>
</style>
