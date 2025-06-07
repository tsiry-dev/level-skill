<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { Link, useForm , Head} from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from "vue3-toastify";


const props = defineProps({
    categoryTests: Array,
    errors: Object,
    auth: Object,
    ziggy: Object,
});

const categoryTests = ref(props.categoryTests || []);


const form = useForm({
    title: '',
    description: '',
    type: '',
});

const submit = () => {

  form.post(route('admin.tests.store'), {
    onSuccess: () => {
        toast("Nouveau test créé avec succès", {
            "theme": "colored",
            "type": "success",
             "autoClose": 3000,
            "dangerouslyHTMLString": true
        })
    },
    preserveState: true,
  });

  form.reset();
}



</script>

<template>
<Head title="New tests" />


<div class="flex items-center justify-between">
    <SubTitle>
        Nouveau test
    </SubTitle>

    <Link :href="route('admin.tests.all')" class="btn btn-gradient btn-secondary">Retour</Link>
</div>

<div>
   <form @submit.prevent="submit" class="mt-5">
        <div class="input-floating max-w-150 mb-5">
            <input v-model="form.title" type="text" placeholder="Nom du type de test..." class="input" id="floatingInput" />
            <label class="input-floating-label" for="floatingInput">Nom du test</label>
            <span class="text-red-500 text-sm" v-if="form.errors.title">{{ form.errors.title }}</span>
        </div>

        <div class="input-floating max-w-150 mb-5">
            <select name="" id="" class="input" v-model="form.type">
                <option value="">Selectionner un type de test</option>
                <option
                    v-for="category in categoryTests"
                    :value="category.id"
                    :key="category.id"
                >
                    {{ category.name }}
                </option>
            </select>
            <label class="input-floating-label" for="floatingInput">Nom du test</label>
            <span class="text-red-500 text-sm" v-if="form.errors.title">{{ form.errors.title }}</span>
        </div>

        <div class="textarea-floating max-w-150 mb-5">
            <textarea class="textarea" v-model="form.description" placeholder="Hello!!!" id="textareaFloating"></textarea>
            <label class="textarea-floating-label" rows="20" for="textareaFloating">Your bio</label>
            <span class="text-red-500 text-sm" v-if="form.errors.description">{{ form.errors.description }}</span>
        </div>

        <div>
            <button class="btn btn-gradient btn-success">Success</button>
        </div>
   </form>
</div>
</template>

<style scoped>
</style>
