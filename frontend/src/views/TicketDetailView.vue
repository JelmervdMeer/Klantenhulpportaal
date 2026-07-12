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


                    <div>

                        <strong>Status:</strong>

                        <span
                            class="badge ms-2"
                            :class="statusClass(ticket.status)"
                        >
                            {{ ticket.status }}
                        </span>


                        <div
                            v-if="authStore.user?.role === 'admin'"
                            class="mt-3"
                        >

                            <select
                                v-model="selectedStatus"
                                class="form-select"
                                @change="updateStatus"
                            >

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


                        <div
                            v-if="statusMessage"
                            class="alert alert-info mt-3"
                        >
                            {{ statusMessage }}
                        </div>

                    </div>


                    <div class="mt-3">

    <strong>Prioriteit:</strong>

    <span
        class="badge ms-2"
        :class="priorityClass(ticket.priority)"
    >
        {{ ticket.priority }}
    </span>


    <div
        v-if="authStore.user?.role === 'admin'"
        class="mt-3"
    >

        <select
            v-model="selectedPriority"
            class="form-select"
            @change="updatePriority"
        >

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


    <div
        v-if="priorityMessage"
        class="alert alert-info mt-3"
    >
        {{ priorityMessage }}
    </div>

</div>


                    <p>
                        <strong>Categorie:</strong>
                        {{ ticket.category?.name }}
                    </p>


                    <p>
                        <strong>Aangemaakt door:</strong>
                        {{ ticket.user?.name }}
                    </p>

                    <div class="mt-3">

    <strong>Toegewezen aan:</strong>

    <span class="ms-2">

        {{ ticket.assignedAdmin?.name ?? 'Nog niet toegewezen' }}

    </span>


    <div
        v-if="authStore.user?.role === 'admin'"
        class="mt-3"
    >

        <select
            v-model="selectedAdmin"
            class="form-select"
            @change="assignAdmin"
        >

            <option :value="null">

                Niet toegewezen

            </option>

            <option
                v-for="admin in admins"
                :key="admin.id"
                :value="admin.id"
            >

                {{ admin.name }}

            </option>

        </select>

    </div>


    <div
        v-if="assignMessage"
        class="alert alert-info mt-3"
    >

        {{ assignMessage }}

    </div>

</div>


                    <hr>


                    <h5>
                        Beschrijving
                    </h5>


                    <p>
                        {{ ticket.description }}
                    </p>


                </div>

            </div>


            <div
                v-if="ticket.reactions?.length"
                class="card mt-4"
            >

                <div class="card-header">

                    <h4 class="mb-0">
                        Reacties
                    </h4>

                </div>


                <div class="card-body">

                    <div
                        v-for="reaction in ticket.reactions"
                        :key="reaction.id"
                        class="border-bottom mb-3 pb-3"
                    >

                        <strong>
                            {{ reaction.user?.name }}
                        </strong>


                        <br>


                        <small class="text-muted">
                            {{ reaction.created_at }}
                        </small>


                        <p class="mt-2">
                            {{ reaction.message }}
                        </p>


                    </div>


                </div>


            </div>


            <div
                v-else
                class="alert alert-secondary mt-4"
            >
                Er zijn nog geen reacties op dit ticket.
            </div>



            <div class="card mt-4">

                <div class="card-header">

                    <h4 class="mb-0">
                        Reactie plaatsen
                    </h4>

                </div>


                <div class="card-body">


                    <div
                        v-if="reactionError"
                        class="alert alert-danger"
                    >
                        {{ reactionError }}
                    </div>


                    <textarea
                        v-model="newReaction"
                        class="form-control"
                        rows="4"
                        placeholder="Typ hier je reactie..."
                    ></textarea>


                    <button
                        class="btn btn-primary mt-3"
                        @click="addReaction"
                        :disabled="sending"
                    >

                        {{ sending ? 'Versturen...' : 'Reactie plaatsen' }}

                    </button>


                </div>

            </div>


        </div>

    </div>

</template>


<script setup lang="ts">

import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '../stores/auth'

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

    reactions?: {
        id: number
        message: string
        created_at: string

        user?: {
            name: string
        }
    }[]

    assigned_to?: number | null

assignedAdmin?: {
    id: number
    name: string
}

}

interface Admin {

    id: number

    name: string

}

const selectedPriority = ref('')
const priorityMessage = ref('')

const route = useRoute()
const authStore = useAuthStore()

const ticket = ref<Ticket | null>(null)

const loading = ref(true)

const error = ref('')

const newReaction = ref('')

const sending = ref(false)

const reactionError = ref('')

const statusMessage = ref('')

const selectedStatus = ref('')

const admins = ref<Admin[]>([])

const selectedAdmin = ref<number | null>(null)

const assignMessage = ref('')


async function loadTicket() {

    try {

        const response = await api.get(
            `/tickets/${route.params.id}`
        )

        ticket.value = response.data.ticket

        selectedStatus.value = response.data.ticket.status

        selectedPriority.value = response.data.ticket.priority

        selectedAdmin.value = response.data.ticket.assigned_to

    } catch {

        error.value = 'Ticket kon niet worden geladen.'

    } finally {

        loading.value = false

    }

}

async function addReaction() {

    if (!newReaction.value.trim()) {
        reactionError.value = 'Vul eerst een reactie in.'
        return
    }

    try {

        sending.value = true
        reactionError.value = ''

        await api.post(
            `/tickets/${route.params.id}/reactions`,
            {
                message: newReaction.value
            }
        )

        newReaction.value = ''

        await loadTicket()

    } catch {

        reactionError.value = 'Reactie kon niet worden geplaatst.'

    } finally {

        sending.value = false

    }

}


async function updateStatus() {

    console.log('Status wijzigen:', selectedStatus.value)

    if (!ticket.value) return

    try {

        statusMessage.value = ''

        await api.put(
            `/tickets/${ticket.value.id}/status`,
            {
                status: selectedStatus.value
            }
        )

        statusMessage.value = 'Status succesvol gewijzigd.'

setTimeout(() => {
    statusMessage.value = ''
}, 3000)

    } catch {

        statusMessage.value = 'Status kon niet worden gewijzigd.'

    }

}

function statusClass(status: string) {

    switch (status) {

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

async function updatePriority() {

    if (!ticket.value) return

    try {

        priorityMessage.value = ''

        await api.put(
            `/tickets/${ticket.value.id}/priority`,
            {
                priority: selectedPriority.value
            }
        )

        ticket.value.priority = selectedPriority.value

        priorityMessage.value =
            'Prioriteit succesvol gewijzigd.'

    } catch {

        priorityMessage.value =
            'Prioriteit kon niet worden gewijzigd.'

    }

}

function priorityClass(priority: string) {

    switch (priority) {

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

async function loadAdmins() {

    try {

        const response = await api.get('/admins')

        admins.value = response.data.admins

    } catch {

        console.error('Administrators konden niet worden geladen.')

    }

}

async function assignAdmin() {

    if (!ticket.value) return

    try {

        assignMessage.value = ''

        await api.put(
            `/tickets/${ticket.value.id}/assign`,
            {
                assigned_to: selectedAdmin.value
            }
        )

        const admin = admins.value.find(
            admin => admin.id === selectedAdmin.value
        )

        ticket.value.assigned_to = selectedAdmin.value

        ticket.value.assignedAdmin = admin

        assignMessage.value =
            'Administrator succesvol toegewezen.'

        setTimeout(() => {
            assignMessage.value = ''
        }, 3000)

    } catch {

        assignMessage.value =
            'Administrator kon niet worden toegewezen.'

    }

}


onMounted(async () => {

    await loadTicket()

    await loadAdmins()

})



</script>