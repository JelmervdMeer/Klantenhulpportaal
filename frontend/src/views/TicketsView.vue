<template>
   

    <div class="container mt-4">

        <h1>
            Mijn tickets
        </h1>


        <RouterLink
            to="/tickets/create"
            class="btn btn-primary mb-3"
        >
            Nieuw ticket
        </RouterLink>



        <!-- Filters -->

        <div class="card mb-4">

            <div class="card-body">

                <div class="row g-3">


                    <div class="col-md-4">

                        <input
                            v-model="search"
                            type="text"
                            class="form-control"
                            placeholder="Zoeken op titel..."
                        >

                    </div>



                    <div class="col-md-3">

                        <select
                            v-model="selectedStatus"
                            class="form-select"
                        >

                            <option value="">
                                Alle statussen
                            </option>

                            <option value="Open">
                                Open
                            </option>

                            <option value="In behandeling">
                                In behandeling
                            </option>

                            <option value="Gesloten">
                                Gesloten
                            </option>

                        </select>

                    </div>



                    <div class="col-md-3">

                        <select
                            v-model="selectedPriority"
                            class="form-select"
                        >

                            <option value="">
                                Alle prioriteiten
                            </option>

                            <option value="Laag">
                                Laag
                            </option>

                            <option value="Normaal">
                                Normaal
                            </option>

                            <option value="Hoog">
                                Hoog
                            </option>

                        </select>

                    </div>



                    <div class="col-md-2">

                        <button
                            class="btn btn-secondary w-100"
                            @click="clearFilters"
                        >
                            Wissen
                        </button>

                    </div>


                </div>

            </div>

        </div>




        <div
            v-if="loading"
            class="alert alert-info"
        >
            Tickets laden...
        </div>



        <div
            v-if="error"
            class="alert alert-danger"
        >
            {{ error }}
        </div>




        <table
            v-if="tickets.length"
            class="table table-striped table-hover"
        >

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Titel</th>
                    <th>Status</th>
                    <th>Prioriteit</th>
                    <th>Categorie</th>
                    <th>Gebruiker</th>

                </tr>

            </thead>



            <tbody>

                <tr
                    v-for="ticket in tickets"
                    :key="ticket.id"
                    @click="openTicket(ticket.id)"
                    class="ticket-row"
                >


                    <td>
                        {{ ticket.id }}
                    </td>



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

                        <span
                            class="badge"
                            :class="priorityClass(ticket.priority)"
                        >

                            {{ ticket.priority }}

                        </span>

                    </td>




                    <td>
                        {{ ticket.category?.name }}
                    </td>



                    <td>
                        {{ ticket.user?.name }}
                    </td>



                </tr>


            </tbody>


        </table>




        <div
            v-if="!loading && !tickets.length && !error"
            class="alert alert-warning"
        >
            Geen tickets gevonden.
        </div>


    </div>


</template>




<script setup lang="ts">


import { ref, onMounted, watch } from 'vue'

import { useRouter } from 'vue-router'

import api from '../api/axios'
import Navbar from '../components/Navbar.vue'



interface Ticket {

    id: number

    title: string

    status: string

    priority: string


    category?: {
        name: string
    }


    user?: {
        name: string
    }

}




const router = useRouter()



const tickets = ref<Ticket[]>([])


const loading = ref(true)


const error = ref('')



const search = ref('')

const selectedStatus = ref('')

const selectedPriority = ref('')





function openTicket(id: number) {

    router.push(`/tickets/${id}`)

}





async function loadTickets() {


    try {


        loading.value = true


        const response = await api.get('/tickets', {

            params: {

                search: search.value || undefined,

                status: selectedStatus.value || undefined,

                priority: selectedPriority.value || undefined

            }

        })


        tickets.value = response.data.tickets



    } catch {


        error.value = 'Tickets konden niet worden geladen.'



    } finally {


        loading.value = false


    }


}





function clearFilters() {


    search.value = ''

    selectedStatus.value = ''

    selectedPriority.value = ''


    loadTickets()


}





function statusClass(status: string) {


    switch(status) {


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





function priorityClass(priority: string) {


    switch(priority) {


        case 'Laag':

            return 'bg-primary'



        case 'Normaal':

            return 'bg-warning text-dark'



        case 'Hoog':

            return 'bg-danger'



        default:

            return 'bg-secondary'


    }


}





watch(

    [
        search,
        selectedStatus,
        selectedPriority
    ],

    () => {

        loadTickets()

    }

)




onMounted(loadTickets)



</script>




<style scoped>


.ticket-row {

    cursor: pointer;

}



.ticket-row:hover {

    opacity: 0.8;

}



</style>