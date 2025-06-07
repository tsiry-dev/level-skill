<script setup>
import { ref, onMounted , computed} from 'vue';
import SubTitle from '@/components/SubTitle.vue';
import { usePage, Head } from '@inertiajs/vue3';
import * as echarts from 'echarts';

const page = usePage();
console.log(page.props.auth.user);

const props = defineProps({
    categories: Array,
    errors: Object,
    submissions: Array,
    name: String,
    quote: Object,
    auth: Object,
    ziggy: Object,
    sidebarOpen: Boolean,
});

const data = ref([]);

data.value = props.categories.map((categoryTest) => {
    return {
        value: categoryTest.activities.length,
        name: categoryTest.name,
    };
});


console.log(props.submissions);


let pieChartInstance = null;



// Référence vers l'élément DOM
const chartRef = ref(null);
const circleRef = ref(null);
const dataChartObservation = computed(() => {
  const counts = {
    Excellent: 0,
    Bon: 0,
    Moyenne: 0,
    Insuffisant: 0,
    Mauvais: 0
  };

  props.submissions.forEach((sub) => {
    const total = sub.total;

    if (total >= 15 && total <= 20) {
      counts.Excellent++;
    } else if (total >= 12 && total < 15) {-
      counts.Bon++;
    } else if (total >= 5 && total < 10) {
      counts.Insuffisant++;
    } else if (total < 5) {
      counts.Mauvais++;
    }
  });

  return [
    { value: counts.Excellent, name: 'Excellent' },
    { value: counts.Bon, name: 'Bon' },
    { value: counts.Insuffisant, name: 'Insuffisant' },
    { value: counts.Mauvais, name: 'Mauvais' }
  ];
});



console.log(dataChartObservation.value);

onMounted(() => {
    if (chartRef.value) {
        const myChart = echarts.init(chartRef.value);

       const option = {
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: '5%',
                left: 'center'
            },
            series: [
                {
                    name: 'Nombre des eleves',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    center: ['50%', '70%'],
                    startAngle: 180,
                    endAngle: 360,
                    data: dataChartObservation.value
                }
            ]
        };

        myChart.setOption(option);
    }

    if(circleRef.value) {
        const myChart = echarts.init(circleRef.value);
        const option = {
            title: {
                text: ''
            },
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: '5%',
                left: 'center'
            },
            series: [
                {
                name: 'Nombre de tests',
                type: 'pie',
                radius: ['40%', '70%'],
                avoidLabelOverlap: false,
                padAngle: 5,
                itemStyle: {
                    borderRadius: 10
                },
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                    show: true,
                    fontSize: 40,
                    fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                  data: data.value
                }
            ]
        };
        myChart.setOption(option);

    }
});


// window.addEventListener('resize', () => {
//     myChart.resize();
// });

</script>

<template>
    <Head title="Dashboard"/>
    <SubTitle>Statistiques</SubTitle>

    <div class="flex gap-4 mt-5 mb-5">
        <div class="flex-1 text-center bg-yellow-200 rounded-2xl">
            <div ref="chartRef" class="w-full h-[400px]"></div>
            <div class="p-2 bg-white rounded-md w-[50%] mx-auto">Observations des eleves</div>
        </div>
        <div class="flex-1 text-center bg-green-200 rounded-2xl">
            <div ref="circleRef" class="w-full h-[400px] "></div>
            <div class="p-2 bg-white rounded-md w-[50%] mx-auto">Nombre de tests par catégorie</div>
        </div>
    </div>
</template>

<style scoped>
</style>
