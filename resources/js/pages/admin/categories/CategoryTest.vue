<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { toast } from "vue3-toastify";


const props = defineProps({
    categoryTests: Array,
    errors: Object,
    auth: Object,
    ziggy: Object,
});

const form = useForm({
    name: '',
    description: '',
});


const categoryTests = computed(() => props.categoryTests || []);

const isActiveModal = ref(false);


function openModal() {
    isActiveModal.value = true;
}

function closeModal() {
    isActiveModal.value = false;
}

function handleSubmit() {

    console.log("create");


    form.post(route('admin.categories.store'), {
        preserveScroll: true,
        preserveState: true, // 👍 nécessaire pour garder les erreurs visibles

        onSuccess: () => {
            toast("Catégorie créée avec succès", {
            theme: "colored",
            type: "success",
            autoClose: 3000,
            });

            isActiveModal.value = false;

            router.reload({
               only: ['categoryTests'],
            });
        },
    });
}

function handleDestroy(categoryTest) {

  form.delete(route('admin.categories.destroy', categoryTest), {
    onSuccess: () => {
        toast("Catégorie supprimée avec succès", {
            "theme": "colored",
            "type": "success",
             "autoClose": 3000,
            "dangerouslyHTMLString": true
        }),
        isActiveModal.value = false;
    },
    preserveState: false,
  });
}

console.log(categoryTests.value);


</script>

<template>
<div class="flex items-center justify-between">
    <SubTitle>
       Categories
    </SubTitle>

    <button @click="openModal"  class="btn btn-gradient btn-secondary">
        <i class="pi pi-plus-circle"></i>
        Nouveau
    </button>
</div>


<div class="mt-5 p-5 bg-white rounded-lg shadow-md">
  <table class="table">
    <thead>
      <tr>
        <th>Category</th>
        <th>tests</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="categoryTest in categoryTests" :key="categoryTest.id">
        <td >
            <Link :href="route('admin.categories.show', categoryTest)" class="underline underline-offset-2">
                {{ categoryTest.name }}
            </Link>
        </td>
        <td>
          <span
            class="bg-green-300 text-green-700 text-sm px-2 py-1 rounded-lg font-extrabold`"
          >
            {{ categoryTest.activities.length }}
          </span>
        </td>
        <td class="flex items-center gap-2">
            <Link :href="route('admin.categories.show', categoryTest)" class="">
                <i class="pi pi-eye text-green-500 text-lg cursor-pointer"></i>
            </Link>
          <i class="pi pi-pen-to-square text-blue-500 text-lg cursor-pointer"></i>
          <i
          @click.prevent="handleDestroy(categoryTest)"
          class="pi pi-trash text-red-600 text-lg cursor-pointer"></i>
        </td>
      </tr>
    </tbody>
  </table>


    <div
     v-if="isActiveModal"
     :class="`${isActiveModal ? 'anime' : ''} bg-green-100 border-1 border-gray-300 rounded-md p-5 fixed top-[5rem] left-[50%] translate-x-[-50%] z-100 w-[40rem]`">
        <div class="flex justify-between">
            <h2>Créer une catégorie</h2>
            <button
            @click="closeModal"
            class="btn btn-error">
            <i class="pi pi-times-circle"></i>
        </button>
        </div>

        <form @submit.prevent="handleSubmit">
            <div>
                <label for="name" class="label-text">Category</label>
                <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="input"
                    id="name"
                    placeholder="Nom de la catégorie"
                >
                <span class="text-red-500 text-sm" v-if="form.errors.name">{{ form.errors.name }}</span>
            </div>

            <div class="w-full">
                <label class="label-text" for="textareaLabel">Description</label>
                <textarea
                    v-model="form.description"
                    class="textarea"
                    placeholder="Décrire ..."
                    id="textareaLabel">
                </textarea>
                <span class="text-red-500 text-sm" v-if="form.errors.description">{{ form.errors.description }}</span>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

</div>
</template>

<style scoped>
.anime {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        top: -5rem;
    }
    100% {
        opacity: 1;
        top: 5rem;
    }

}
</style>
