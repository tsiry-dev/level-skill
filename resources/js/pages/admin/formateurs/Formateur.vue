<script setup>
import BadgeSuccess from '@/components/BadgeSuccess.vue';
import FormModal from '@/components/FormModal.vue';
import { Link, useForm , router, Head} from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from "vue3-toastify";


const props = defineProps({
    formateurs: Object,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

console.log(props.formateurs);

const form = useForm({
    name: '',
    profile: '',
});

const isActiveForm = ref(false);
const formateurEdit = ref(null);


const handleSubmit = () => {
    console.log("create");

    form.post(route('admin.formateurs.store'), {
        preserveScroll: true,
        preserveState: true, // 👍 nécessaire pour garder les erreurs visibles

        onSuccess: () => {
            toast("Formateur créé avec succès", {
                theme: "colored",
                type: "success",
                autoClose: 3000,
            });

            isActiveForm.value = false;
            formateurEdit.value = null;
            form.reset();

            router.reload({
               only: ['formateurs'],
            });
        },
    });
}


const handleDestroy = (formateur) => {
  form.delete(route('admin.formateurs.destroy', formateur), {
    onSuccess: () => {
        toast("Formateur supprimé avec succès", {
            "theme": "colored",
            "type": "warning",
             "autoClose": 3000,
            "dangerouslyHTMLString": true
        }),
        isActiveForm.value = false;
    },
    preserveState: false,
  });
}


const handleEdit = (formateur) => {
    formateurEdit.value = formateur;
    isActiveForm.value = true;
    form.name = formateurEdit.value.name;
    form.profile = formateurEdit.value.profile;
}

const handleUpdateFormateur = (formateur) => {

    form.put(route('admin.formateurs.update', formateur), {
        preserveScroll: true,
        preserveState: true, // 👍 nécessaire pour garder les erreurs visibles

        onSuccess: () => {
            toast("Formateur modifié avec succès", {
                theme: "colored",
                type: "success",
                autoClose: 3000,
            });

            isActiveForm.value = false;
            formateurEdit.value = null;
            form.reset();

            router.reload({
               only: ['formateurs'],
            });
        },
    });

}


const handleActiveForm = () => {
    isActiveForm.value = true;
}

const handleCloseModal = () => {
    isActiveForm.value = false;
    formateurEdit.value = null;
    form.reset();
}

</script>

<template>
    <Head title="Formateurs" />

<div class="relative">
    <div class="flex justify-between items-center mb-6">
        <h2>Formateur{{ formateurs.length > 1 ? 's' : '' }}</h2>
        <span
            @click="handleActiveForm"
            class="btn btn-primary">Ajouter un formateur</span>
    </div>

      <table class="table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Nb eleves</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="formateur in formateurs" :key="formateur.id">
            <td>{{ formateur.name }}</td>
            <td>
                <BadgeSuccess>{{ formateur.users_count ?? 0 }}</BadgeSuccess>
            </td>
            <td class="flex items-center gap-2">
                <i
                @click.prevent="handleEdit(formateur)"
                class="pi pi-pencil text-green-500 text-xl cursor-pointer"></i>
                <i
                 @click.prevent="handleDestroy(formateur)"
                class="pi pi-trash text-red-600 text-xl cursor-pointer"></i>
            </td>
          </tr>
        </tbody>
      </table>


      <FormModal
         :title="`${formateurEdit ? 'Modifier' : 'Ajouter'} un(e) formateur(trice)`"
         :isActive="isActiveForm"
         @close-modal-form="handleCloseModal"
      >
        <form
             @submit.prevent="() => formateurEdit ? handleUpdateFormateur(formateurEdit) : handleSubmit()"

        >
            <div>
                <label for="name" class="label-text">Nom</label>
                <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="input"
                    id="name"
                    placeholder="Nom du formateur"
                >
                <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
            </div>
            <div>
                <label for="profile" class="label-text">Profile</label>
                <input
                    v-model="form.profile"
                    type="text"
                    name="profile"
                    class="input"
                    id="profile"
                    placeholder="Exemple : Formatrice francophone"
                >
                <span class="text-red-500 text-sm" v-if="form.errors.profile">{{ form.errors.profile }}</span>
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                {{ formateurEdit ? 'Modifier' : 'Ajouter' }}
            </button>

        </form>
      </FormModal>
</div>

</template>

<style scoped>
</style>
