<script setup>
import SubTitle from '@/components/SubTitle.vue';
import { onMounted, ref, watch } from 'vue';
import { Link , useForm} from '@inertiajs/vue3';
import { toast } from "vue3-toastify";
import { useModalStore } from '@/stores/modal';
import Modal from '@/components/Modal.vue';
// import { BadgeError } from '@/components/ui/badge/BadgeError.vue';


const modalStore = useModalStore();

const form = useForm({
    question: '',
    timer: 0,
    point: 0,
    unit: 's',
    is_response_ia: false,
});

const formResponse = useForm();



const props = defineProps({
    activity: Object,
    activityType: Object,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

console.log(props.activityType);


const questions = ref([]);
const isActiveForm = ref(false);
const isActiveResponseForm = ref(false);
const isQuestionActive = ref(null);
const openQuestionIndex = ref(null);
const findAnswerIsCorrect = ref(false);

const correctResponse = ref('');

const response1 = ref({
    answer: '',
    is_correct: false,
});
const response2 = ref({
    answer: '',
    is_correct: false,
});
const response3 = ref({
    answer: '',
    is_correct: false,
});
const response4 = ref({
    answer: '',
    is_correct: false,
});

onMounted(() => {
    questions.value = props.activityType.questions;
});

function toggleQuestion(index) {
    openQuestionIndex.value = openQuestionIndex.value === index ? null : index;
}

const activeResposeForm = (question) => {

    const haveCorrectAnswer = question.answers.find((ans) => ans.is_correct === 1);
    findAnswerIsCorrect.value = haveCorrectAnswer ? true : false;

    modalStore.isActive = true;
    isQuestionActive.value = question
};


const handleCreateQuestion = () => {
    form.post(
        route('admin.questions.store', {
            activityType: props.activityType.slug,
        }),
        {
            onSuccess: () => {
                toast("Nouveau question créé avec succès", {
                    "theme": "colored",
                    "type": "success",
                    "autoClose": 3000,
                    "dangerouslyHTMLString": true
                });
                form.reset();
            },
            preserveScroll: true,
            preserveState: false,
        }
    );
};

const handleCreateResponse = (question) => {


    if(
        !response1.value.answer.trim() &&
        !response2.value.answer.trim() &&
        !response3.value.answer.trim() &&
        !response4.value.answer.trim()
    ){
        toast("Vous devez ajouter au moins une réponse", {
            "theme": "colored",
            "type": "error",
            "autoClose": 3000,
            "dangerouslyHTMLString": true
        });
        return;
    }



    let responses = [
        response1.value,
        response2.value,
        response3.value,
        response4.value
    ].filter(response => response.answer.trim() !== '');

    // const index = questions.value.findIndex((q) => q.id === question.id);

    // responses.map((res, index) => {
    //     questions.value[index]?.answers?.push(res);
    // });


    const data = responses.map((response, index) => {
        return {
            answer: response.answer,
            is_correct: response.answer === correctResponse.value,
        };
    });


    formResponse.post(route('admin.responses.store', {
        activityType: question,
        responses: data,
    }), {
        onSuccess: () => {
            toast("Réponses ajoutées avec succès", {
                "theme": "colored",
                "type": "success",
                "autoClose": 3000,
                "dangerouslyHTMLString": true
            });
            isActiveResponseForm.value = false;
            isQuestionActive.value = {};
            response1.value.answer = '';
            response2.value.answer = '';
            response3.value.answer = '';
            response4.value.answer = '';
            correctResponse.value = '';
        },
        preserveScroll: true,
        preserveState: false,
    });


}

const handleRemoveResponse = (response, index) => {
    // Implement the logic to remove a response

    console.log(questions.value, index);

    const indexAsnwer = questions.value[index].answers.findIndex((ans) => ans.id === response.id);
    questions.value[index].answers.splice(indexAsnwer, 1);


     formResponse.delete(route('admin.responses.remove', {
         answer: response,
     }), {
         onSuccess: () => {
             toast("Réponse supprimée avec succès", {
                 "theme": "colored",
                 "type": "success",
                 "autoClose": 3000,
                 "dangerouslyHTMLString": true
             });


         },
         preserveScroll: true,
         preserveState: true,
     });
};


</script>

<template>
    <div class="flex items-center justify-between">
        <div>
            <SubTitle class="flex gap-4 items-center">
                <Link :href="route('admin.tests.all')">Test</Link>
                <i class="pi pi-arrow-right"></i>
                <Link :href="route('admin.activities.show', activity)">{{ activity?.title }}</Link>
                <i class="pi pi-arrow-right"></i>
                <span>{{ activityType?.name }}</span>
            </SubTitle>
        </div>
        <div>
            <Link :href="route('admin.activities.show', activity)" class="btn btn-gradient btn-secondary">Retour</Link>
        </div>
    </div>


    <div class="mt-4">
        <button
            @click="isActiveForm = !isActiveForm"
            class="btn btn-gradient btn-success"
        >
            <div v-if="!isActiveForm" class="flex items-center gap-2 justify-between">
                <i class="pi pi-plus-circle"></i>
                <span>Ajouter une nouvelle question</span>
            </div>
            <div v-else class="flex items-center justify-between gap-2">
                <i class="pi pi-times"></i>
                <span>fermer le formulaire</span>
            </div>
        </button>
    </div>

    <div class="mt-5">
        <h2>Les questions ({{ questions.length }})</h2>
        <p class="text-sm">La somme des points doit egale à 20</p>
    </div>

    <div class="grid grid-cols-1 gap-4 p-4 md:grid-cols-1 lg:grid-cols-2 items-start">
        <div>
            <form
                @submit.prevent="handleCreateQuestion"
                v-if="isActiveForm"
                class="mb-5">
                <div class="mb-2">
                    <label class="text-sm">Nouvelle question</label>
                    <input
                        type="text"
                        placeholder="Votre question..."
                        class="input"
                        v-model="form.question"
                        id="floatingInput"
                    />
                    <span class="text-red-500 text-sm" v-if="form.errors.question">{{ form.errors.question }}</span>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-1 lg:grid-cols-2">
                    <div class="flex gap-4 items-center relative">
                        <div class="flex-1">
                            <label class="text-sm">Temps de réponse</label>
                            <input
                                type="number"
                                max="60"
                                min="1"
                                v-model="form.timer"
                                placeholder="Temp de réponse..."
                                class="input"
                                id="floatingInput"
                            />
                        </div>
                        <div class="absolute z-10 right-[50%] top-[50%] translate-x-[50%] bg-green-900 h-[2rem] w-[2rem] text-white flex items-center justify-center text-2xl rounded-full">
                            <i class="pi pi-arrow-circle-right"></i>
                        </div>
                        <div class="flex-1 relative z-0">
                            <label class="text-sm">Unité</label>
                            <select class="input" v-model="form.unit">
                                <option value="s" selected>Secondes</option>
                                <option value="m">Minutes</option>
                                <option value="h">Heures</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="floatingInput" class="text-sm">Points</label>
                        <input
                            max="20"
                            min="1"
                            type="number"
                            placeholder="Points..."
                            class="input"
                            v-model="form.point"
                            id="floatingInput"
                        />
                    </div>
                    <div class="col-span-2">
                        <label class="custom-soft-option flex flex-row items-start gap-3 sm:w-1/2">
                            <input type="checkbox" v-model="form.is_response_ia" class="checkbox checkbox-primary mt-2" checked />
                            <span class="label-text w-full text-start">
                            <span class="flex justify-between mb-1">
                                <span class="text-base font-medium">IA</span>
                            </span>
                            <span class="text-base-content/80">
                                Correction et donation de pointt automatique de la question
                            </span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-gradient btn-success">Ajouter</button>
                </div>
            </form>

            <div>
                <div v-if="questions.length > 0" class="bg-gray-200 max-h-[600px] overflow-y-auto rounded-lg p-4">
                    <div
                        v-for="(question, index) in questions"
                        :key="index"
                        class="accordion-item"
                    >

                            <div class="flex items-center justify-between w-full">
                                <span>
                                   {{ index + 1 }} - {{ question.question }}
                                </span>

                                <div class="flex gap-1">
                                    <span class="text-[10px] text-white px-2 bg-primary">Point{{ question.point === 1 ? '' : 's' }} {{ question.point }}</span>
                                    <span class="text-[10px] text-white px-2  bg-primary">Temps de réponse {{ question.timer }} s</span>
                                </div>
                            </div>

                        <div class="p-2">
                            <div class="ml-5">
                                <span class="">Réponses ({{ question.answers.length }})</span>
                            </div>

                            <div class="response-content px-5 pb-4" v-for="(answer, i) in question.answers" :key="i">
                                <p class="text-base-content/80 text-sm font-normal flex items-center justify-between">
                                    <span>{{ answer.answer }}</span>

                                    <div class="response-action flex items-center gap-2">
                                        <span
                                            :class="`border-none cursor-pointer text-white text-[10px] rounded-2xl px-2 py-1 ${answer.is_correct ? 'bg-green-400' : 'bg-red-600'}`">
                                            {{  answer.is_correct ? 'Correct' : 'Incorrect' }}
                                        </span>
                                        <span
                                        @click.prevent="handleRemoveResponse(answer, index)"
                                        class="response-remove font-bolder text-red-500"><i class="pi pi-times"></i></span>
                                    </div>
                                </p>
                            </div>

                            <div class="ml-5 mb-2">
                                <div class="flex gap-2 items-center">
                                    <span
                                        @click.prevent="activeResposeForm(question)"
                                        class="text-sm badge bg-success cursor-pointer flex items-center gap-2">
                                            Ajouter une réponse
                                    </span>
                                </div>
                                <hr class="my-2">

                                <div v-if="isActiveResponseForm && isQuestionActive.id === question.id" class="p-2">
                                      <form action="" >
                                        <div
                                           v-if="question.id === isQuestionActive.id"
                                           v-for="i in countResponse"
                                           class="flex gap-2">
                                            <div>
                                                <input class="input w-[50%]" type="text">
                                            </div>
                                            <div class="flex items-center gap-2 mt-2">
                                                <input type="radio" name="is_correct" id="is_correct" class="checkbox checkbox-primary">
                                                <label for="is_correct" class="label-text">Bonne réponse</label>
                                            </div>
                                        </div>

                                        <div>
                                            <button class="py-1 px-3 text-sm bg-green-500 text-white">Sauvegarder</button>
                                        </div>
                                      </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p v-if="questions.length === 0">Aucune question Pour le moment</p>
                </div>
            </div>
        </div>


        <div v-if="!isQuestionActive" class="bg-green-500 p-4 rounded-lg">
            <ul>
                <li class="text-3xl">Statistiques des questions</li>
                <li class="text-white text-xl">Nombres des questions ({{ questions.length }})</li>
                <li class="text-white text-xl">Somes des points ({{ questions.reduce((a, b) => a + b.point, 0) }} / 20)</li>
                <li class="text-white text-xl">Total timer (4 minutes)</li>
            </ul>
        </div>

        <div v-else >
            <span
            @click="isQuestionActive = null"
            class="badge bg-success cursor-pointer">Statistiques des questions</span>
            <h2>{{ isQuestionActive.question }}</h2>
            <p class="text-sm">
                Ajouter des reponse pour cette question
            </p>

            <form
            @submit.prevent="handleCreateResponse(isQuestionActive)"
              class="mt-4">
                <div v-if="!findAnswerIsCorrect" class="mb-2">
                    <label for="" class="text-sm">Ajouter la bonne réponse ici</label>
                    <input v-model="correctResponse" type="text" class="px-2 text-md w-full rounded-md outline-none border-2 border-green-500" placeholder="Réponse 1">
                </div>

                <div v-else>
                    <p class="text-sm">
                        Cette question a déjà une réponse correcte, vous pouvez ajouter d'autres réponses.
                    </p>
                </div>

                <div>
                    <label for="" class="text-sm">Réponse 1</label>
                    <input type="text" v-model="response1.answer" class="input" placeholder="Réponse 1">
                </div>

                <div>
                    <label for="" class="text-sm">Réponse 2</label>
                    <input type="text" v-model="response2.answer" class="input" placeholder="Réponse 2">
                </div>

                <div>
                    <label for="" class="text-sm">Réponse 3</label>
                    <input type="text" v-model="response3.answer" class="input" placeholder="Réponse 3">
                </div>

                <div>
                    <label for="" class="text-sm">Réponse 4</label>
                    <input type="text" v-model="response4.answer" class="input" placeholder="Réponse 4">
                </div>

                <div class="mt-4">
                    <button class="btn btn-gradient btn-success">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>


</template>

<style scoped>
.response-remove {
    opacity: 0;
    visibility: hidden;
    cursor: pointer;
    color: red;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.response-content:hover .response-remove {
    opacity: 1;
    visibility: visible;
}

</style>
