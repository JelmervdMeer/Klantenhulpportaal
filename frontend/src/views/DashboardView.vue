<template>

    <!-- Pagina titel -->

    <PageHeader
        title="Dashboard"
        subtitle="Overzicht van het klantenhulpportaal"
    />





    <!-- Statistieken -->

    <div class="row g-4 mb-4">


        <div class="col-md-4">

            <StatCard
                title="Totaal tickets"
                :value="stats.totaal"
                icon="bi-ticket"
                color="primary"
            />

        </div>




        <div class="col-md-4">

            <StatCard
                title="In behandeling"
                :value="stats.in_behandeling"
                icon="bi-hourglass-split"
                color="warning"
            />

        </div>




        <div class="col-md-4">

            <StatCard
                title="Gesloten"
                :value="stats.gesloten"
                icon="bi-check-circle"
                color="success"
            />

        </div>


    </div>








    <!-- Grafiek -->


    <ContentCard
        v-if="dashboard"
        title="Ticketstatus overzicht"
        icon="bi-bar-chart"
        class="mb-4"
    >


        <TicketStatusChart
            :data="dashboard.status_overzicht"
        />


    </ContentCard>









    <!-- Recente tickets -->


    <ContentCard
        title="Recente tickets"
        icon="bi-ticket-perforated"
    >


        <div class="row g-4">


            <div
                v-for="ticket in tickets"
                :key="ticket.id"
                class="
                    col-xl-4
                    col-lg-6
                    col-md-12
                "
            >


                <TicketCard

                    :ticket="ticket"

                    @open="openTicket"

                />


            </div>


        </div>


    </ContentCard>



</template>




<script setup lang="ts">

import PageHeader from '../components/PageHeader.vue'
import StatCard from '../components/StatCard.vue'
import ContentCard from '../components/ContentCard.vue'
import TicketCard from '../components/TicketCard.vue'


import { ref, onMounted } from 'vue'

import { useRouter } from 'vue-router'

import api from '../api/axios'

import TicketStatusChart from '../components/TicketStatusChart.vue'




const router = useRouter()




interface Ticket {


    id:number

    title:string

    status:string

    priority:string


    user?:{

        name:string

    }


    category?:{

        name:string

    }


}





interface DashboardData {


    totaal:number

    open:number

    in_behandeling:number

    gesloten:number

    hoge_prioriteit:number


    tickets:Ticket[]


    status_overzicht:{


        open:number

        in_behandeling:number

        gesloten:number


    }


}




const tickets = ref<Ticket[]>([])



const stats = ref({


    totaal:0,

    open:0,

    in_behandeling:0,

    gesloten:0,

    hoge_prioriteit:0


})



const dashboard = ref<DashboardData | null>(null)



const loading = ref(true)



const error = ref('')






async function loadDashboard(){


    try {


        const response = await api.get('/dashboard')


        const data = response.data



        dashboard.value = data



        stats.value = {


            totaal:data.totaal,

            open:data.open,

            in_behandeling:data.in_behandeling,

            gesloten:data.gesloten,

            hoge_prioriteit:data.hoge_prioriteit


        }



        tickets.value = data.tickets



    }
    catch{


        error.value =
            'Dashboard kon niet worden geladen.'


    }
    finally{


        loading.value=false


    }


}






function openTicket(id:number){


    router.push(`/tickets/${id}`)


}






onMounted(loadDashboard)



</script>





<style scoped>


.icon {

    width:48px;

    height:48px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:12px;

    color:white;

    font-size:22px;

}



.card {

    border-radius:16px;

}



</style>