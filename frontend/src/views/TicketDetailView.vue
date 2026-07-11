<template>

    <div class="container mt-4">

        <div
            v-if="loading"
            class="alert alert-info"
        >
            Ticket laden...
        </div>


        <div
            v-if="error"
            class="alert alert-danger"
        >
            {{ error }}
        </div>


        <div v-if="ticket">

            <h1>
                {{ ticket.title }}
            </h1>


            <div class="card mt-3">

                <div class="card-body">

                    <p>
                        <strong>Status:</strong>
                        {{ ticket.status }}
                    </p>


                    <p>
                        <strong>Prioriteit:</strong>
                        {{ ticket.priority }}
                    </p>


                    <p>
                        <strong>Categorie:</strong>
                        {{ ticket.category?.name }}
                    </p>


                    <p>
                        <strong>Aangemaakt door:</strong>
                        {{ ticket.user?.name }}
                    </p>


                    <hr>


                    <h5>Beschrijving</h5>

                    <p>
                        {{ ticket.description }}
                    </p>


                </div>

            </div>


        </div>


    </div>

</template>


<script setup lang="ts">

import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

import api from '../api/axios'


interface Ticket {

    id: number

    title: string

    description: string

    status: string

    priority: string


    category?: {
        name: string
    }


    user?: {
        name: string
    }

}


const route = useRoute()


const ticket = ref<Ticket | null>(null)


const loading = ref(true)


const error = ref('')



async function loadTicket() {

    try {

        const response = await api.get(
            `/tickets/${route.params.id}`
        )


        ticket.value = response.data.ticket


    } catch {

        error.value = 'Ticket kon niet worden geladen.'

    } finally {

        loading.value = false

    }

}



onMounted(loadTicket)

</script>