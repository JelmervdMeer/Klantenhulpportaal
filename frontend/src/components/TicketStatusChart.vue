<template>

    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">
                Tickets per status
            </h5>

        </div>

        <div class="card-body">

            <canvas ref="chartCanvas"></canvas>

        </div>

    </div>

</template>

<script setup lang="ts">

import {
    Chart,
    DoughnutController,
    ArcElement,
    Tooltip,
    Legend
} from 'chart.js'

import {
    ref,
    onMounted,
    watch
} from 'vue'


Chart.register(
    DoughnutController,
    ArcElement,
    Tooltip,
    Legend
)


const props = defineProps<{

    data: {

        open: number

        in_behandeling: number

        gesloten: number

    }

}>()


const chartCanvas = ref<HTMLCanvasElement | null>(null)

let chart: Chart | null = null


function renderChart() {

    if (!chartCanvas.value) {

        return

    }


    if (chart) {

        chart.destroy()

    }


    chart = new Chart(chartCanvas.value, {

        type: 'doughnut',

        data: {

            labels: [

                'Open',

                'In behandeling',

                'Gesloten'

            ],

            datasets: [

                {

                    data: [

                        props.data.open,

                        props.data.in_behandeling,

                        props.data.gesloten

                    ],

                    backgroundColor: [

                        '#0d6efd',

                        '#ffc107',

                        '#198754'

                    ],

                    borderWidth: 2

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: true,

            plugins: {

                legend: {

                    position: 'bottom'

                }

            }

        }

    })

}


onMounted(() => {

    renderChart()

})


watch(

    () => props.data,

    () => {

        renderChart()

    },

    {

        deep: true

    }

)

</script>

<style scoped>

.card {

    border: none;

    border-radius: 16px;

    box-shadow: 0 8px 24px rgba(0, 0, 0, .08);

}


.card-body {

    height: 320px;

    display: flex;

    justify-content: center;

    align-items: center;

}


canvas {

    max-width: 450px !important;

    max-height: 250px !important;

}

</style>