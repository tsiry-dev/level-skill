<script setup>
import BadgeSuccess from '@/components/BadgeSuccess.vue';
import FormModal from '@/components/FormModal.vue';
import { Link, useForm , router, Head} from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from "vue3-toastify";


const props = defineProps({
    niveaux: Object,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

console.log(props.niveaux);


const form = useForm({
    title: '',
});

const isActiveForm = ref(false);
const niveauEdit = ref(null);


const handleSubmit = () => {
   form.post(route('admin.niveaux.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast("Niveau créé avec succès", {
                theme: "colored",
                type: "success",
                autoClose: 3000,
            });
            isActiveForm.value = false;
            form.reset();
            router.reload({
               only: ['niveaux'],
            });
        },
    });
}


const handleDestroy = (niveau) => {
      form.delete(route('admin.niveaux.destroy', niveau), {
        onSuccess: () => {
            toast("Niveau supprimé avec succès", {
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


const handleEdit = (niveau) => {
   niveauEdit.value = niveau;
   isActiveForm.value = true;
   form.title = niveauEdit.value.title;
}

const handleUpdateNiveau = (niveau) => {
    form.put(route('admin.niveaux.update', niveau), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast("Niveau modifié avec succès", {
                theme: "colored",
                type: "success",
                autoClose: 3000,
            });
            isActiveForm.value = false;
            form.reset();
            router.reload({
               only: ['niveaux'],
            });
        },
    });
}


const handleActiveForm = () => {
    isActiveForm.value = true;
    niveauEdit.value = null;
    form.title = '';
}

const handleCloseModal = () => {
    isActiveForm.value = false;
    form.reset();
}

</script>

<template>

    <Head title="Niveaux" />

<div class="relative">
    <div class="flex justify-between items-center mb-6">
        <h2>Niveaux</h2>
        <span
            @click="handleActiveForm"
            class="btn btn-primary">Ajouter</span>
    </div>

      <table class="table">
        <thead>
          <tr>
            <th>Niveau</th>
            <th>Nb eleves</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="niveau in niveaux" :key="niveau.id">
            <td>{{ niveau.title }}</td>
            <td>
                <BadgeSuccess>{{ niveau.users_count ?? 0 }}</BadgeSuccess>
            </td>
            <td class="flex items-center gap-2">
                <i
                @click.prevent="handleEdit(niveau)"
                class="pi pi-pencil text-green-500 text-xl cursor-pointer"></i>
                <i
                 @click.prevent="handleDestroy(niveau)"
                class="pi pi-trash text-red-600 text-xl cursor-pointer"></i>
            </td>
          </tr>
        </tbody>
      </table>


      <FormModal
         :title="`${niveauEdit ? 'Modifier' : 'Ajouter'} un niveau`"
         :isActive="isActiveForm"
         @close-modal-form="handleCloseModal"
      >
        <form
             @submit.prevent="() => niveauEdit ? handleUpdateNiveau(niveauEdit) : handleSubmit()"
        >
            <div>
                <label for="niveau" class="label-text">Niveau</label>
                <input
                    v-model="form.title"
                    type="text"
                    name="niveau"
                    class="input"
                    id="niveau"
                    placeholder="Ex: Niveau 1"
                >
                <span class="text-red-500 text-sm" v-if="form.errors.title">{{ form.errors.title }}</span>
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                {{ niveauEdit ? 'Modifier' : 'Ajouter' }}
            </button>

        </form>
      </FormModal>
</div>

</template>

<style scoped>
</style>
