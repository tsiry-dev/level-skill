<script setup>
import { router, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    students: Object,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

console.log(props.students);

const search = ref('');

watch(search, (value) => {
  router.get(route('admin.students'), { search: value }, { preserveState: true, replace: true });
});

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
    <div>
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
        <th>Email</th>
        <th>Tests</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="student in students.data" :key="student.id">
        <Link :href="route('admin.students.show', student)" v-html="highlightMatch(student.name)" class="underline underline-offset-2"></Link>
        <td v-html="highlightMatch(student.email)"></td>
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
</style>
