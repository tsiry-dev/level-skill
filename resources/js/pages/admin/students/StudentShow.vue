<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { Link, Head } from '@inertiajs/vue3';
import BadgeSucess from '@/components/BadgeSuccess.vue';
import BadgeError from '@/components/ui/badge/BadgeError.vue';
import { computed } from 'vue';


const props = defineProps({
  student: Object,
  activityTypes: Array,
  submissions: Array
})

const submissionCount = computed(() => props.student?.submissions.length);
const activityTypesCount = computed(() => props.activityTypes.length);
const todoActivityTypesCount = computed(() => activityTypesCount.value - submissionCount.value);
const activityTypeOnSubmission = computed(() => props.submissions);

const generateStatus = (activityNote) => {
    if (activityNote < 5) return 'Mauvais';
    if (activityNote >= 5 && activityNote < 10) return 'Insuffisant';
    if (activityNote >= 10 && activityNote < 12) return 'Passable';
    if (activityNote >= 12 && activityNote < 15) return 'Bon';
    if (activityNote >= 15 && activityNote <= 20) return 'Excellent';
    return 'Non définie';
}

const getStatusClass = (note) => {
    const value = parseFloat(note || 0);

    if (value < 5) return 'bg-red-500 text-white';         // Mauvais
    if (value >= 5 && value < 10) return 'bg-orange-500 text-white'; // Insuffisant
    if (value >= 10 && value < 12) return 'bg-yellow-400 text-black'; // Passable
    if (value >= 12 && value < 15) return 'bg-blue-500 text-white';   // Bon
    if (value >= 15 && value <= 20) return 'bg-green-500 text-white'; // Excellent

    return 'bg-gray-400 text-white'; // Non définie
}


console.log(activityTypeOnSubmission.value);



</script>

<template>
<Head :title="`${student?.name} | Eleves`" />


    <SubTitle class="flex gap-4 items-center mb-5">
        <Link :href="route('admin.students')">Eleves</Link>
        <i class="pi pi-arrow-right"></i>
        <span>{{ student?.name }}</span>
    </SubTitle>

    <div class="bg-gray-200 p-4 rounded-lg flex gap-4 items-center">
        <div class="flex-1">
            <h2 class="flex items-center gap-2 text-xl mb-2">
                <i class="pi pi-user"></i>
                <span>{{ student?.name }}</span>
            </h2><hr class="mb-2 text-gray-400">
            <h2 class="flex items-center justify-between gap-2 text-xl mb-2">
                Formateur(trice)
                <BadgeSucess>
                    {{ student?.formateur?.name }}
                </BadgeSucess>
            </h2><hr class="mb-2 text-gray-400">
            <h2 class="flex items-center justify-between gap-2 text-xl mb-2">
                Términé
                <BadgeSucess>
                    {{ submissionCount }}
                </BadgeSucess>
            </h2><hr class="mb-2 text-gray-400">
            <h2 class="flex items-center justify-between gap-2 text-xl mb-2">
                A faire
                <BadgeError>
                    {{ todoActivityTypesCount }}
                </BadgeError>
            </h2><hr class="mb-2 text-gray-400">
        </div>
        <div class="flex-2">
            <table class="table bg-white " >
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>test</th>
                        <th>Notes / 20</th>
                        <th>Observation</th>
                        <th>Temps</th>
                       <!-- <th>Action</th> -->
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="activityType in activityTypeOnSubmission">
                        <td>{{ activityType.activity_type.activity.name }}</td>
                        <td>{{ activityType.activity_type.name }}</td>
                        <td>
                            <BadgeSucess>
                                {{ activityType.total }}
                            </BadgeSucess>
                        </td>
                        <td>
                            <span :class="`px-2 py-1 rounded-lg font-extrabold text-[10px] ${getStatusClass(activityType.total)}`">
                                {{ generateStatus(activityType.total) }}
                            </span>
                        </td>
                        <td>
                           {{ activityType.time }}
                        </td>
                     <!--   <td class="flex gap-2 items-center">
                            <i class="pi pi-pen-to-square text-blue-500"></i>
                            <i class="pi pi-trash text-red-500"></i>
                        </td> -->
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</template>

<style scoped>
</style>
