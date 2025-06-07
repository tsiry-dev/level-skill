<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { Link, useForm , Head} from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { ref } from 'vue';



const form = useForm({
    name: '',
});
const activityEdit = ref(null)

const props = defineProps({
    activities: Array,
    activity: Object,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

console.log(props.activities);



const handleRemoveActivity = (activity) => {
    form.delete(route('admin.activities.remove', activity.slug), {
        onSuccess: () => {
            toast("Activité supprimée avec succès", {
                "theme": "colored",
                "type": "error",
                 "autoClose": 2000,
                "dangerouslyHTMLString": true
            })
        },
        preserveState: false,
    });
};

const handleEditActivity = (activity) => {
    activityEdit.value = activity;
};

const handeleResetActivityEdit = () => {
    activityEdit.value = null;
}

const handleUpdateActivityType = (activity) => {
   form.name = activityEdit.value.title;

    form.patch(route('admin.activities.update', {
        activity: activity.slug,
        title: activityEdit.title
    }), {
          onSuccess: () => {
                toast("Activité mise à jour avec succès", {
                 "theme": "colored",
                 "type": "success",
                  "autoClose": 3000,
                 "dangerouslyHTMLString": true
                })
          },
          preserveState: false,
     });
     activityEdit.value = null;

};

</script>

<template>
    <Head title="Tests" />

<div class="flex items-center justify-between">
    <SubTitle>
        Liste des tests
    </SubTitle>

    <Link :href="route('admin.tests.create')" class="btn btn-gradient btn-secondary">
        <i class="pi pi-plus text-white"></i>
       Nouveau
    </Link>
</div>

<div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 lg:grid-cols-3">
    <div v-for="activity in props.activities" :key="activity.id">

        <div>
            <div class="bg-green-400 p-5 rounded-2xl ">
                <div class="flex justify-end mb-4">
                    <span class="bg-white px-3 py-1 text-sm rounded-sm">
                        {{ activity.category_test?.name }}
                    </span>
                </div>
                <div class="text-black flex items-center justify-between">
                    <div v-if="activityEdit === activity">
                        <input
                            v-model="activityEdit.title"
                            type="text" placeholder="Nouveau type d'activité..."
                            class="input w-[80%]"
                            id="floatingInput"
                        />
                    </div>

                    <Link v-else :href="route('admin.activities.show', activity.slug)" class="flex text-xl text-white">
                         {{ activity.title }}
                    </Link>

                    <div class="flex gap-2">
                        <div class="bg-gray-200 h-[3rem] w-[3rem] text-gray-600 flex items-center justify-center text-2xl rounded-xl">
                            {{ activity.activity_types_count }}
                        </div>


                        <div v-if="activityEdit === activity" class="flex gap-2 items-center">
                            <div
                                @click.prevent="handleUpdateActivityType(activity)"
                                class="bg-blue-400 h-[3rem] cursor-pointer w-[3rem] text-white-600 flex items-center justify-center text-xl rounded-2xl">
                                <i class="pi pi-plus-circle"></i>
                            </div>
                            <div
                              @click.prevent="handeleResetActivityEdit()"
                              class="bg-red-400 text-white h-[3rem] cursor-pointer w-[3rem] text-white-600 flex items-center justify-center text-xl rounded-2xl">
                                <i class="pi pi-times"></i>
                            </div>
                        </div>

                        <div v-else class="flex gap-2 items-center">
                            <div
                            @click.prevent="handleRemoveActivity(activity)"
                            class="bg-red-400 h-[3rem] cursor-pointer w-[3rem] text-white-600 flex items-center justify-center text-xl rounded-2xl">
                                <i class="pi pi-trash"></i>
                            </div>
                            <div
                                @click.prevent="handleEditActivity(activity)"
                              class="bg-blue-400 h-[3rem] cursor-pointer w-[3rem] text-white-600 flex items-center justify-center text-xl rounded-2xl">
                                <i class="pi pi-pen-to-square"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>
</style>
