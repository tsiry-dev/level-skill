<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    activityType: Object,
    activities: Object,
    questions: Array,
    user: Object,
    activityTypeStory: Array,
    errors: Object,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

const form = useForm();

const questions = computed(() => props.questions || [   ]);
const isStarted = ref(false);
const questionIndex = ref(JSON.parse(localStorage.getItem('questionIndex')) || 0);
const selectedIndex = ref(null);
const isFinished = ref(localStorage.getItem('isFinished') === 'true'); // ✅ récupère depuis localStorage
const timer = ref(JSON.parse(localStorage.getItem('timer')) || 10);
const studentTimerCount = ref(JSON.parse(localStorage.getItem('studentTimerCount')) || 0);
let interval = null;

const selectedAnswer = ref(null);

console.log(questions.value);



localStorage.setItem('total', localStorage.getItem('total') || 0);
localStorage.setItem('studentTimerCount', localStorage.getItem('studentTimerCount') || 0);

//SUBMISSION
const total = ref(JSON.parse(localStorage.getItem('total')) || 0);
const anwerChoose = ref(null);

const finalSum = computed(() => total.value.toFixed(2));


function formatSeconds(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;

    if (minutes > 0) {
        return `${minutes} minutes ${remainingSeconds} secondes`;
    }

    return `${remainingSeconds} secondes`;
}



// Fonction pour démarrer le test
const handleStart = () => {


    if(props.user.id !== props.activityType.user_id && props.activityTypeStory.find(story => story.user_id === props.user.id && story.activity_type_id === props.activityType.id))
    {

        router.visit(route('account.test.show', props.activities));
        return;
    }

    isStarted.value = true;
    isFinished.value = false;
    localStorage.setItem('isFinished', false); // ✅ remet à false

    questionIndex.value = JSON.parse(localStorage.getItem('questionIndex')) || 0;
    selectedIndex.value = null;
    timer.value = JSON.parse(localStorage.getItem('timer')) || 10;

    localStorage.setItem('questionIndex', questionIndex.value);
    localStorage.setItem('timer', timer.value);

    total.value = 0;
    localStorage.setItem('total', 0);
    selectedAnswer.value = null;


    startTimer();
};

// Démarrer le timer
const startTimer = () => {
    clearInterval(interval);
    timer.value = JSON.parse(localStorage.getItem('timer')) || 10;

    interval = setInterval(() => {
        timer.value--;
        studentTimerCount.value++;
        localStorage.setItem('studentTimerCount', studentTimerCount.value);
        localStorage.setItem('timer', timer.value);

        if (timer.value <= 0) {
            clearInterval(interval);
            goToNextQuestion();
        }
    }, 1000);

    console.log(total.value);

};

const goToNextQuestion = () => {
    clearInterval(interval);

    // Vérifie la réponse de la question actuelle AVANT de passer à la suivante
    const currentQuestion = questions.value[questionIndex.value];
    selectedIndex.value = null

    if (!selectedAnswer.value) {
        toast("😓 Oups! Veuillez sélectionner une réponse", {
            theme: "colored",
            type: "error",
            autoClose: 2000,
            dangerouslyHTMLString: true,
        });

        // Pénalise si aucune réponse sélectionnée
        total.value -= 1;
    } else if (selectedAnswer.value.is_correct) {
        total.value += currentQuestion?.point || 1;
    }

    localStorage.setItem('total', JSON.stringify(total.value));
    selectedAnswer.value = null;

    // Passe à la prochaine question
    if (questionIndex.value < questions.value.length - 1) {
        questionIndex.value++;
        localStorage.setItem('questionIndex', questionIndex.value);

        const nextTimer = questions.value[questionIndex.value]?.timer || 10;
        timer.value = nextTimer;
        localStorage.setItem('timer', nextTimer);

        startTimer();
    } else {
        // Fin du test
        isFinished.value = true;
        isStarted.value = false;
        localStorage.setItem('isFinished', true);
        localStorage.removeItem('questionIndex');
        localStorage.removeItem('timer');
        localStorage.removeItem('total');

        // Enregistrement des résultats
        form.post(route('account.test.storeTestStory', props.activityType), {
            onSuccess: () => {
                toast("Test sauvegardé avec succès", {
                    theme: "colored",
                    type: "success",
                    autoClose: 3000,
                });
            },
        });

        form.post(route('account.test.submission', {
            activityType: props.activityType,
            total: total.value,
            time: formatSeconds(studentTimerCount.value),
        }), {
            onSuccess: () => {
                toast("Résultat soumis", {
                    theme: "colored",
                    type: "success",
                    autoClose: 3000,
                });

                // Reset complet
                localStorage.setItem('total', 0);
                localStorage.setItem('isFinished', false);
                localStorage.setItem('studentTimerCount', 0);

                // router.visit(route('account.test.show', props.activities));
            },
        });
    }
};


const handleSetIsFinishedFalse = () => {
    isFinished.value = false;
    localStorage.setItem('isFinished', false);
    localStorage.setItem('studentTimerCount', 0);
    localStorage.setItem('total', 0);
    router.visit(route('account.test.show', props.activities));
};

const handleAnswerChange = (answer) => {
    selectedAnswer.value = answer;
};

// Nettoyer le timer si le composant est démonté
onUnmounted(() => {
    clearInterval(interval);
});

// Réinitialisation du timer à l'ouverture du composant
onMounted(() => {
    if (!isFinished.value) {
        localStorage.setItem('questionIndex', questionIndex.value);
        localStorage.setItem('timer', localStorage.getItem('timer') || questions.value[questionIndex.value]?.timer || 10);
    }
});
</script>


<template>
<nav class="flex items-center gap-2 text-lg">
    <span>
        <Link :href="route('account.test.all')">Tests</Link>
    </span>
    <span><i class="pi pi-arrow-right"></i></span>
    <Link :href="route('account.test.show', activities)">
        {{ activities?.title }}
    </Link>
    <span><i class="pi pi-arrow-right"></i></span>
    <span>{{ activityType?.name }} |  Nombre des questions ({{ questions.length }})</span>
</nav>

<div>
    <p class="text-sm">Vous avez {{ questions.length }} question à répondre <br>
      chaque question a un timer de 10 à 30 secondes à peut prêt <br>
      Si vous ne Choisissez pas, vous perdez un point <span class="bg-red-500 text-white p-1 rounded-sm">-1</span>
    </p>
</div>

<main class="mt-10">

    <div
       v-if="isFinished"
      class="text-center p-5"
    >
         <h3>Test terminer, à la prochaine fois !</h3>
         <span
         @click="handleSetIsFinishedFalse"
         class="btn btn-gradient btn-success">
             <i class="pi pi-arrow-left"></i>
             <span>Retour à la liste des tests</span>
         </span>
    </div>

    <div v-else>
        <div v-if="!isStarted" class="flex items-center justify-center mt-15 bg-yellow-400 p-20 rounded-2xl">
            <button @click="handleStart" class="btn btn-gradient btn-success">
                <div class="flex items-center gap-2 justify-between">

                    <span
                       v-if=" props.activityTypeStory.find(story => story.user_id === props.user.id && story.activity_type_id === props.activityType.id)"
                    >
                       🙂 Vous avez déjà Terminer ce test
                    </span>

                    <span v-else>
                    <i class="pi pi-play"></i>

                        Commencer
                    </span>

                </div>
            </button>
        </div>

        <div v-else class="rounded-sm">
            <div>
                Questions {{ questionIndex + 1 }} / {{ questions.length }}
            </div>
            <h2 class="text-2xl text-green-600 mb-5">
                {{ questions[questionIndex]?.question }}
            </h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <!-- Choix des réponses -->
                    <label
                        v-for="(answer, i) in questions[questionIndex]?.answers"
                        :key="i"
                        :for="`answer-${i}`"
                        class="flex cursor-pointer gap-5 border-2 rounded-sm p-2 mb-2 transition-all"
                        :class="{
                            'bg-purple-600 text-white border-white': selectedIndex === i,
                            'bg-green-200 hover:bg-purple-500 hover:text-white border-transparent': selectedIndex !== i
                        }"
                    >
                        <input
                            type="radio"
                            :id="`answer-${i}`"
                            name="answer"
                            class="peer hidden"
                            :value="i"
                            v-model="selectedIndex"
                             @change="handleAnswerChange(answer)"
                        />
                        <span class="text-lg">
                            {{ answer.answer }} {{ answer.is_correct }}
                        </span>
                    </label>

                    <div class="mt-5">
                        <button
                            class="btn-primary btn"
                            @click="goToNextQuestion">
                            Suivant &nbsp; <i class="pi pi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Timer + Emoji -->
                <div class="flex gap-4">
                <div
                    class="flex-1 flex items-center justify-center text-white rounded-4xl shadow-2xl text-8xl border transition-all duration-300"
                    :class="{
                    'bg-green-500 border-green-300': timer > 8,
                    'bg-yellow-500 border-yellow-300': timer > 5 && timer <= 8,
                    'bg-orange-500 border-orange-300': timer > 3 && timer <= 5,
                    'bg-red-500 border-red-300': timer <= 3
                    }"
                >
                    {{ timer }}
                </div>

                <!---Emoji--->
                <div
                    class="flex-1 flex items-center justify-center text-white rounded-4xl shadow-2xl text-8xl border transition-all duration-300"
                    :class="{
                    'bg-green-500 border-green-300': timer > 8,
                    'bg-yellow-500 border-yellow-300': timer > 5 && timer <= 8,
                    'bg-orange-500 border-orange-300': timer > 3 && timer <= 5,
                    'bg-red-500 border-red-300': timer <= 3
                    }"
                >
                    {{ timer >= 8 ? '😉' : (timer >= 5 ? '😐' : (timer >= 3 ? '😓' : '💀')) }}
                </div>
                </div>


            </div>

        </div>
    </div>

</main>
</template>

<style scoped>
</style>
