<script setup>

import SubTitle from '@/components/SubTitle.vue';
import { computed, ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormModal from '@/components/FormModal.vue';

const props = defineProps({
    categoryTest: Object,
    errors: Object,
    auth: Object,
    ziggy: Object,
});

const form = useForm({
    name: '',
});

const activities = computed(() => props.categoryTest?.activities || []);

const isActiveModal = ref(false);

const handleDelete = (data) => {
    // activityTypes.destroy
    console.log(data);

}


function openModal() {
    isActiveModal.value = true;
    form.reset();
}

const handleCloseModal = () => {
    isActiveModal.value = false;
    form.reset();
}


</script>

<template>
    <Head :title="`${categoryTest?.name} | Categories`" />

<div class="flex items-center justify-between">
    <SubTitle>
       {{ categoryTest?.name }} ({{ categoryTest?.activities.length }})
    </SubTitle>

    <Link :href="route('admin.categories.index')" class="btn btn-gradient btn-secondary">
        <i class="pi pi-arrow-left"></i>
        Retour
    </Link>
</div>

  <table class="table">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Questions</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="activity in activities" :key="activity.id">
        <td >
            <Link :href="route('admin.activities.show', activity)"  class="underline underline-offset-2">
                {{ activity?.title }}
            </Link>
        </td>
        <td>
          <span
            class="bg-green-300 text-green-700 text-sm px-2 py-1 rounded-lg font-extrabold`"
          >
            {{ activity?.activity_types.length }}
          </span>
        </td>
        <td class="flex items-center gap-2">
            <Link :href="route('admin.activities.show', activity)"  class="underline underline-offset-2">
                <i class="pi pi-eye text-green-500 text-lg cursor-pointer"></i>
            </Link>
        </td>
      </tr>
    </tbody>
  </table>


    <FormModal
         title="Modifier"
         :isActive="isActiveModal"
         @close-modal-form="handleCloseModal"
      >
        <form @submit.prevent="handleSubmit">
            <div class="mb-3">
                <label for="name" class="label-text">Titre</label>
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

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </FormModal>

</template>

<style scoped>
</style>
