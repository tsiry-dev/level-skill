<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref , onMounted} from 'vue';
import { toast } from "vue3-toastify";

const props = defineProps({
    activity: Object
});

const activityItem = ref(null);
const activityTypes = ref(null);


onMounted(() => {
    activityItem.value = props.activity;
    activityTypes.value = props.activity.activity_types;
});

const form = useForm({
    name: '',
});

const submit = () => {
    form.post(route('admin.activityType.store', activityItem.value), {
        onSuccess: () => {

            toast("Nouveau type d'activité créé avec succès", {
                "theme": "colored",
                "type": "success",
                 "autoClose": 3000,
                "dangerouslyHTMLString": true
            })
        },
        preserveState: form.name ? false : true,
    });

    form.reset();
}

const destroy = (activity) => {
    form.delete(route('admin.activityType.destroy', {
                activity: activityItem.value.slug,
                activityType: activity.slug
    }), {
        onSuccess: () => {
            toast("Activité supprimé avec succès", {
                "theme": "colored",
                "type": "error",
                 "autoClose": 2000,
                "dangerouslyHTMLString": true
            })
        },
        preserveState: false,
    });

}

</script>

<template>
<div class="flex items-center justify-between">
    <SubTitle>
        {{ activityItem?.title }}
    </SubTitle>

    <Link :href="route('admin.test.all')"  class="btn btn-gradient btn-secondary">Retour</Link>
</div>

<div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 lg:grid-cols-3">
    <div>
        <div v-for="activity in activityTypes" :key="activity.id">
            <div class="bg-white p-2 mb-2 rounded-2xl text-black flex items-center justify-between">
                <Link class="text-sm text-gray-500" :href="route('admin.activitie.show', activity.slug)" >{{ activity.name }}</Link>
                <div class="flex gap-2 items-center">
                    <form  class="translate-y-[-2px]" @submit.prevent="destroy(activity)">
                        <button class="badge badge-error size-6 p-0 cursor-pointer"> <i class="pi pi-trash"></i></button>
                    </form>
                    <span class="badge badge-info size-6 p-0"> <i class="pi pi-pen-to-square"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <form class="bg-white px-2 py-5" @submit.prevent="submit">
            <div class="input-floating max-w-150 mb-5">
                <input v-model="form.name" type="text" placeholder="Nom du {{ activityItem?.title }}" class="input" id="floatingInput" />
                <label class="input-floating-label" for="floatingInput">Nom du {{ activityItem?.title }}</label>
                <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
            </div>
            <div>
                <button class="btn btn-gradient btn-success">Ajouter</button>
            </div>
        </form>
    </div>
    <div class="bg-yellow-400"></div>
</div>

</template>

<style scoped>
</style>
