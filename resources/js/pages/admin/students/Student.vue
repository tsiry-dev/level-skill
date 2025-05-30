<script setup>
import { router, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ref, watch } from 'vue';

const props = defineProps({
    students: Object,
    formateurs: Array,
    niveaux: Array,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

console.log(props.students);

//FILTER
const search = ref('');
const byFormateur = ref('');
const byNiveau = ref('');

const filters = computed(() => ({
  search: search.value,
  byFormateur: byFormateur.value,
  byNiveau: byNiveau.value,
}));

const formateur = computed(() => props.formateurs);
const niveaux = computed(() => props.niveaux);

watch(search, () => {
  router.get(route('admin.students'), filters.value, {
    preserveState: true,
    replace: true,
  });
});

const handleFilterByFormateur = (formateur) => {
  byFormateur.value = formateur.slug;
  router.get(route('admin.students'), filters.value, {
    preserveState: true,
    replace: true,
  });
};

const handleFilterByNiveau = (niveau) => {
  byNiveau.value = niveau.slug;
  router.get(route('admin.students'), filters.value, {
    preserveState: true,
    replace: true,
  });
};

function changePage(url) {
  if (url) router.visit(url)
}

function highlightMatch(text) {
  if (!search.value) return text;

  const escapedSearch = search.value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  const regex = new RegExp(`(${escapedSearch})`, 'gi');

  return text.replace(regex, `<span class="bg-yellow-200 text-black font-bold">$1</span>`);
}

</script>

<template>
  <div class="flex items-center justify-between mb-5">
    <h1>Listes</h1>
    <div class="flex gap-2 items-center">
        <div class="bg-blue-400  px-3 py-2 rounded-lg text-sm cursor-pointer relative filter">
            <i class="pi pi-filter text-lg text-white"></i>
            <div
               class="hidden absolute bg-white border-1 border-gray-300 w-[30rem]  z-10  top-8 right-0 p-2 rounded-lg ">
                <h2 class="text-lg">filtrer par</h2>
                <div class="flex">
                    <div class="flex-1">
                        <h2 class="text-green-600 text-xl">Formateurs</h2>
                        <div class="flex flex-col gap-1">
                            <span v-for="formateur in formateurs" :key="formateur.id">
                                <span @click="handleFilterByFormateur(formateur)" class="cursor-pointer">
                                     {{ formateur.name }}
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-green-600 text-xl">Niveau</h2>
                        <div class="flex flex-col gap-1">
                            <span v-for="niveau in niveaux" :key="niveau.id">
                                <span
                                @click="handleFilterByNiveau(niveau)"
                                class="cursor-pointer">
                                    {{ niveau.title }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <input
        v-model="search"
        type="text"
        placeholder="Rechercher..."
        class="input w-[200px]"
      />
    </div>
  </div>

  <div v-if="search" class="text-xl text-gray-600 mb-5">
     Recherche: <span class="font-bold text-green-600">{{ search }}</span>
  </div>

    <div class="text-center text-2xl my-10  w-full" v-if="students.data.length === 0">
        😓 Aucun étudiant trouvé ...
    </div>

  <table class="table" v-else>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Format(eur|rice)</th>
        <th>Niveau</th>
        <th>Nb tests</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="student in students.data" :key="student.id">
        <Link :href="route('admin.students.show', student)" v-html="highlightMatch(student.name)" class="underline underline-offset-2"></Link>
        <td v-html="student.formateur?.name"></td>
        <td v-html="student.niveau?.title"></td>
        <td>
          <span
            :class="`${student.submissions.length > 0 ? 'bg-green-300 text-green-700' : 'bg-red-300 text-red-700'} text-sm px-2 py-1 rounded-lg font-extrabold`"
          >
            {{ student.submissions.length }}
          </span>
        </td>
        <td class="flex items-center gap-2">
          <Link
            :href="route('admin.students.show', student)"
            class="pi pi-eye text-green-500 text-xl cursor-pointer"
          ></Link>
          <i class="pi pi-trash text-red-600 text-xl cursor-pointer"></i>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="mt-4 flex gap-2">
    <button
      v-for="link in students.links"
      :key="link.label"
      @click="changePage(link.url)"
      v-html="link.label"
      :class="[
        'px-3 py-1 border rounded text-sm',
        link.active ? 'bg-green-500 text-white' : 'bg-white text-black',
        !link.url ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'
      ]"
      :disabled="!link.url"
    />
  </div>
</template>

<style scoped>

.filter:hover .hidden {
   display: block;
}
</style>
