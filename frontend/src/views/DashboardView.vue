<template>

    <div class="container-fluid">


        <div class="mb-4">

            <h1 class="fw-bold">
                Dashboard
            </h1>

            <p class="text-muted">
                Overzicht van het klantenhulpportaal
            </p>

        </div>



        <!-- Statistieken -->


        <div class="row g-4 mb-4">


            <div class="col-md-3">

                <div class="stat-card">

                    <div class="icon bg-primary">

                        <i class="bi bi-ticket"></i>

                    </div>


                    <div>

                        <small>
                            Totaal tickets
                        </small>


                        <h2>
                            {{ stats.total }}
                        </h2>

                    </div>


                </div>

            </div>





            <div class="col-md-3">

                <div class="stat-card">


                    <div class="icon bg-warning">

                        <i class="bi bi-hourglass-split"></i>

                    </div>


                    <div>

                        <small>
                            In behandeling
                        </small>


                        <h2>
                            {{ stats.pending }}
                        </h2>


                    </div>


                </div>

            </div>






            <div class="col-md-3">


                <div class="stat-card">


                    <div class="icon bg-success">

                        <i class="bi bi-check-circle"></i>

                    </div>


                    <div>

                        <small>
                            Gesloten
                        </small>


                        <h2>
                            {{ stats.closed }}
                        </h2>


                    </div>


                </div>


            </div>







            <div class="col-md-3">


                <div class="stat-card">


                    <div class="icon bg-danger">

                        <i class="bi bi-exclamation-triangle"></i>

                    </div>


                    <div>

                        <small>
                            Hoge prioriteit
                        </small>


                        <h2>
                            {{ stats.high }}
                        </h2>


                    </div>


                </div>


            </div>


        </div>





        <!-- Recente tickets -->


        <div class="card">


            <div class="card-header">

                <h4 class="mb-0">
                    Recente tickets
                </h4>

            </div>



            <div class="card-body">


                <table class="table align-middle">


                    <thead>

                        <tr>

                            <th>
                                Titel
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Prioriteit
                            </th>

                            <th>
                                Gebruiker
                            </th>


                        </tr>


                    </thead>



                    <tbody>


                        <tr
                            v-for="ticket in tickets"
                            :key="ticket.id"
                        >


                            <td>

                                {{ ticket.title }}

                            </td>



                            <td>

                                <span
                                    class="badge"
                                    :class="statusClass(ticket.status)"
                                >

                                    {{ ticket.status }}

                                </span>


                            </td>



                            <td>

                                {{ ticket.priority }}

                            </td>



                            <td>

                                {{ ticket.user?.name }}

                            </td>


                        </tr>


                    </tbody>


                </table>


            </div>


        </div>


    </div>


</template>



<script setup lang="ts">

import { ref, onMounted } from 'vue'
import api from '../api/axios'


const tickets = ref<any[]>([])


const stats = ref({

    total:0,

    pending:0,

    closed:0,

    high:0

})



async function loadDashboard(){


    const response = await api.get('/tickets')


    tickets.value = response.data.tickets



    stats.value.total =
        tickets.value.length



    stats.value.pending =
        tickets.value.filter(
            t => t.status === 'In behandeling'
        ).length



    stats.value.closed =
        tickets.value.filter(
            t => t.status === 'Gesloten'
        ).length



    stats.value.high =
        tickets.value.filter(
            t => t.priority === 'Hoog'
        ).length


}



function statusClass(status:string){


    switch(status){


        case 'Open':

            return 'bg-primary'


        case 'In behandeling':

            return 'bg-warning text-dark'


        case 'Gesloten':

            return 'bg-success'


        default:

            return 'bg-secondary'


    }

}



onMounted(loadDashboard)


</script>
<style scoped>

.stat-card{

    background:white;

    padding:25px;

    border-radius:18px;

    display:flex;

    align-items:center;

    gap:20px;

    box-shadow:
        0 8px 24px rgba(0,0,0,.08);

}



.stat-card h2{

    margin:5px 0 0;

    font-weight:700;

}



.icon{

    width:55px;

    height:55px;

    border-radius:14px;

    display:flex;

    align-items:center;

    justify-content:center;

    color:white;

    font-size:25px;

}



.card{

    border:none;

    border-radius:16px;

    box-shadow:
        0 8px 24px rgba(0,0,0,.08);

}


</style>