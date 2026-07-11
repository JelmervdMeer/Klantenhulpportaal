<template>
    <div class="container mt-4">

        <h1>Mijn tickets</h1>


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
                    style="cursor:pointer"
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
                            :class="{
                                'bg-success': ticket.status === 'Open',
                                'bg-warning': ticket.status === 'In behandeling',
                                'bg-secondary': ticket.status === 'Gesloten'
                            }"
                        >
                            {{ ticket.status }}
                        </span>

                    </td>


                    <td>
                        {{ ticket.priority }}
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

import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

import api from '../api/axios'


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



function openTicket(id: number) {

    router.push(`/tickets/${id}`)

}



async function loadTickets() {

    try {

        const response = await api.get('/tickets')


        tickets.value = response.data.tickets


    } catch {

        error.value = 'Tickets konden niet worden geladen.'


    } finally {

        loading.value = false

    }

}



onMounted(loadTickets)

</script>