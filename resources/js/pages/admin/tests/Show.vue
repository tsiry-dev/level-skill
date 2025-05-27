<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Activity } from 'lucide-vue-next';
import { watch } from 'vue';
import { ref , onMounted} from 'vue';
import { toast } from "vue3-toastify";

const props = defineProps({
    activity: Object,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

const activityItem = ref(null);
const activityTypes = ref(null);
const activityTypeEdit = ref(null);


onMounted(() => {
    activityItem.value = props.activity;
    activityTypes.value = props.activity.activity_types;
});


const form = useForm({
    name: '',
});

const submit = () => {
    form.post(route('admin.activityTypes.store', activityItem.value), {
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
    form.delete(route('admin.activityTypes.destroy', {
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

const edit = (activity) => {
   activityTypeEdit.value = activity;
}

const resetActivityTypeEdit = () => {
   activityTypeEdit.value = null;
}

const handleUpdateActivityType = (activity) => {
    form.name = activityTypeEdit.value.name;

    form.patch(route('admin.activityTypes.update', {
        activity: activityItem.value.slug,
        activityType: activity.slug
    }), {
        onSuccess: () => {
            toast("Activité modifiée avec succès", {
                theme: "colored",
                type: "success",
                autoClose: 3000,
                dangerouslyHTMLString: true
            });
            activityTypeEdit.value = null;
            form.reset();
        },
        onError: () => {
            toast("Erreur lors de la mise à jour", {
                theme: "colored",
                type: "error",
                autoClose: 3000,
                dangerouslyHTMLString: true
            });
        },
        preserveState: false,
    });

    form.reset();
    activityTypeEdit.value = null;
};

console.log(activityTypes);


</script>

<template>
<div class="flex items-center justify-between">
    <div>
        <SubTitle class="flex gap-4 items-center">
            <Link :href="route('admin.tests.all')">Test</Link>
            <i class="pi pi-arrow-right"></i>
            <span>{{ activityItem?.title }}</span>
        </SubTitle>
        <p>Ajouter des exercices</p>
    </div>

    <Link :href="route('admin.tests.all')"  class="btn btn-gradient btn-secondary">Retour</Link>
</div>

<div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 lg:grid-cols-3">
    <div>
        <div v-for="activity in activityTypes" :key="activity.id">
            <div class="bg-gray-200 p-2 mb-2 rounded-2xl text-black flex items-center justify-between">
                <div v-if="activityTypeEdit === activity">
                    <input
                        v-model="activityTypeEdit.name"
                        type="text" placeholder="Nouveau type d'activité..."
                        class="input mr-2"
                        id="floatingInput"
                    />
                   <span class="text-red-500 text-sm" v-if="!activityTypeEdit.name">Champs vide!!</span>
                </div>

                <div v-else>
                   <Link
                    :href="route('admin.questions.show', {
                        activities: activityItem.slug,
                        activityType: activity.slug
                    })"
                     class="text-sm text-gray-500">
                   {{ activity.name }}
                </Link>
                </div>

                <div class="flex gap-2 items-center">
                    <div v-if="activityTypeEdit === activity" class="flex gap-2 items-center mx-2">
                        <form  class="translate-y-[-2px]"  @click.prevent="handleUpdateActivityType(activity)">
                            <button
                                  type="submit"
                                title="Sauvegarder"
                                 class="badge badge-success size-6 p-0 cursor-pointer"> <i class="pi pi-plus-circle"></i></button>
                        </form>
                        <div  class="translate-y-[-2px]">
                            <button
                                 title="Annuler"
                                 type="button"
                                 @click.prevent="resetActivityTypeEdit"
                                 class="badge badge-ligth size-6 p-0 cursor-pointer">❌</button>
                        </div>
                    </div>

                    <div v-else class="flex gap-2 items-center">
                        <form  class="translate-y-[-2px]" @submit.prevent="destroy(activity)">
                            <button class="badge badge-error size-6 p-0 cursor-pointer"> <i class="pi pi-trash"></i></button>
                        </form>
                        <span
                        @click="edit(activity)"
                        class="badge badge-info size-6 p-0 cursor-pointer"> <i class="pi pi-pen-to-square"></i></span>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="">
        <form class="bg-white px-2 py-5" @submit.prevent="submit">
            <div class="input-floating max-w-150 mb-5">
                <input
                    v-model="form.name"
                    type="text" placeholder="Nom du {{ activityItem?.title }}"
                    class="input"
                    id="floatingInput"
                />
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
