<template>

    <div class="container-fluid">


        <!-- Pagina header -->

        <div class="page-header">

            <div>

                <h1 class="fw-bold mb-2">
                    Dashboard
                </h1>

                <p class="mb-0">
                    Overzicht van het klantenhulpportaal
                </p>

            </div>

        </div>



        <!-- Statistieken -->

        <div class="stats-container">


            <div class="stat-card">

                <div class="icon bg-primary">

                    <i class="bi bi-ticket"></i>

                </div>

                <div>

                    <small>
                        Totaal tickets
                    </small>

                    <h2>
                        {{ stats.totaal }}
                    </h2>

                </div>

            </div>




            <div class="stat-card">

                <div class="icon bg-warning">

                    <i class="bi bi-hourglass-split"></i>

                </div>


                <div>

                    <small>
                        In behandeling
                    </small>

                    <h2>
                        {{ stats.in_behandeling }}
                    </h2>

                </div>

            </div>





            <div class="stat-card">

                <div class="icon bg-success">

                    <i class="bi bi-check-circle"></i>

                </div>


                <div>

                    <small>
                        Gesloten
                    </small>

                    <h2>
                        {{ stats.gesloten }}
                    </h2>

                </div>

            </div>





            <div class="stat-card">

                <div class="icon bg-danger">

                    <i class="bi bi-exclamation-triangle"></i>

                </div>


                <div>

                    <small>
                        Hoge prioriteit
                    </small>

                    <h2>
                        {{ stats.hoge_prioriteit }}
                    </h2>

                </div>

            </div>


        </div>





        <!-- Ticket status grafiek -->


        <!-- Recente tickets -->

<div class="card">


    <div class="tickets-title">

    <h4 class="mb-0">
        Recente tickets
    </h4>

</div>



    <div class="card-body">


        <div class="ticket-grid">


            <div
                v-for="ticket in tickets"
                :key="ticket.id"
                class="ticket-item"
            >


                <TicketCard

                    :ticket="ticket"

                    @open="openTicket"

                />


            </div>


        </div>


    </div>
    </div>



</div>


</template>





<script setup lang="ts">


import { ref, onMounted } from 'vue'

import { useRouter } from 'vue-router'

import api from '../api/axios'

import TicketStatusChart from '../components/TicketStatusChart.vue'

import TicketCard from '../components/TicketCard.vue'



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


.page-header {


    display:flex;

    justify-content:space-between;

    align-items:center;


    background:linear-gradient(
        135deg,
        #0d6efd,
        #3b82f6
    );


    color:white;


    padding:30px;


    border-radius:16px;


    margin-bottom:30px;


    box-shadow:
        0 8px 24px rgba(13,110,253,.25);


}



.page-header p{


    color:rgba(255,255,255,.8);


}





.stats-container {


    display:flex;


    justify-content:center;


    gap:20px;


    flex-wrap:wrap;


    margin-bottom:30px;


}





.stat-card {


    display:flex;


    align-items:center;


    gap:16px;


    width:250px;


    padding:20px;


    background:white;


    border-radius:16px;


    box-shadow:
        0 8px 24px rgba(0,0,0,.08);


}





.stat-card h2 {


    margin:5px 0 0;


    font-weight:700;


}




.icon {


    width:48px;


    height:48px;


    border-radius:12px;


    display:flex;


    align-items:center;


    justify-content:center;


    color:white;


    font-size:22px;


}




.card {


    border:none;


    border-radius:16px;


    box-shadow:
        0 8px 24px rgba(0,0,0,.08);


}




.card-header {


    background:#2563eb;


    color:white;


    border-radius:16px 16px 0 0 !important;


    padding:18px;


}




.ticket-grid {


    row-gap:25px;


}

.ticket-grid {

    display:grid;

    grid-template-columns: repeat(2, 1fr);

    gap:25px;

}



.ticket-item {

    width:100%;

}



/* Tablet */

@media(max-width: 992px){

    .ticket-grid {

        grid-template-columns:1fr;

    }

    
    .tickets-title {

    padding:20px 24px;

    background:white;

    border-radius:16px 16px 0 0;

    font-weight:700;

}
}




</style>