<script setup>
import { ref, onMounted } from 'vue';
import SubTitle from '@/components/SubTitle.vue';
import { usePage } from '@inertiajs/vue3';
import * as echarts from 'echarts';

const page = usePage();
console.log(page.props.auth.user);

const props = defineProps({
    categories: Array,
    errors: Object,
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


console.log(data.value);


let pieChartInstance = null;



// Référence vers l'élément DOM
const chartRef = ref(null);
const circleRef = ref(null);

onMounted(() => {
    if (chartRef.value) {
        const myChart = echarts.init(chartRef.value);

        const option = {
            title: {
                text: ''
            },
            tooltip: {},
            legend: {
                data: ['sales']
            },
            xAxis: {
                data: ['Shirts', 'Cardigans', 'Chiffons', 'Pants', 'Heels', 'Socks']
            },
            yAxis: {},
            series: [
                {
                    name: 'sales',
                    type: 'bar',
                    data: [5, 20, 36, 10, 10, 20]
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
    <SubTitle>Statistiques</SubTitle>

    <div class="flex gap-4 mt-5 mb-5">
        <div class="flex-1 text-center bg-yellow-200 rounded-2xl">
            <div ref="chartRef" class="w-full h-[400px]"></div>
            <div>Nombre de tests par catégorie</div>
        </div>
        <div class="flex-1 text-center bg-green-200 rounded-2xl">
            <div ref="circleRef" class="w-full h-[400px] "></div>
            <div>Nombre de tests par catégorie</div>
        </div>
    </div>
</template>

<style scoped>
</style>
