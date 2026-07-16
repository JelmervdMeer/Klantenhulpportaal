

<template>

<div class="container-fluid">

    <!-- Laden -->

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


        <!-- Pagina header -->

        <PageHeader
            :title="ticket.title"
            :subtitle="`Ticket #${ticket.id}`"
        >

            <button
                class="btn btn-light"
                @click="$router.back()"
            >

                <i class="bi bi-arrow-left me-2"></i>

                Terug

            </button>

        </PageHeader>





        <div class="row g-4">



            <!-- Linkerkant -->


            <div class="col-lg-4">


                <ContentCard
                    title="Ticket informatie"
                    icon="bi-info-circle"
                >



                    <div class="info-item mb-3">


                        <strong>
                            Status
                        </strong>


                        <div class="mt-2">

                            <BadgeStatus
                                type="status"
                                :value="ticket.status"
                            />

                        </div>


                    </div>





                    <div
                        v-if="authStore.user?.role === 'admin'"
                        class="mb-4"
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





                    <hr>





                    <div class="info-item mb-3">


                        <strong>
                            Prioriteit
                        </strong>


                        <div class="mt-2">

                            <BadgeStatus
                                type="priority"
                                :value="ticket.priority"
                            />

                        </div>


                    </div>






                    <div
                        v-if="authStore.user?.role === 'admin'"
                        class="mb-4"
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






                    <hr>






                    <div class="info-text mb-3">


                        <strong>
                            Categorie
                        </strong>


                        <p class="mt-2 mb-0">
                            {{ ticket.category?.name }}
                        </p>


                    </div>







                    <div class="info-text mb-3">


                        <strong>
                            Aangemaakt door
                        </strong>


                        <p class="mt-2 mb-0">
                            {{ ticket.user?.name }}
                        </p>


                    </div>



                    <div class="info-text mb-3">

                        <strong>
                            Toegewezen aan
                        </strong>

                        <p class="mt-2 mb-0">
                            {{ ticket.assignedAdmin?.name ?? 'Nog niet toegewezen' }}
                        </p>

                    </div>


                    <div
                        v-if="authStore.user?.role === 'admin'"
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


                </ContentCard>


            </div>





            <!-- Rechter kolom -->


            <div class="col-lg-8">



                <ContentCard
                    title="Beschrijving"
                    icon="bi-file-text"
                    class="mb-4"
                >

                    <p class="mb-0">
                        {{ ticket.description }}
                    </p>


                </ContentCard>





                <!-- Reacties -->


                <ContentCard
                    title="Reacties"
                    icon="bi-chat-left-text"
                    class="mb-4"
                >


                    <div
                        v-if="ticket.reactions?.length"
                    >


                        <div
                            v-for="reaction in ticket.reactions"
                            :key="reaction.id"
                            class="reaction-item"
                        >


                            <div class="reaction-avatar">

                                {{ reaction.user?.name?.charAt(0).toUpperCase() }}

                            </div>



                            <div class="reaction-content">


                                <div class="d-flex justify-content-between">


                                    <strong>
                                        {{ reaction.user?.name }}
                                    </strong>


                                    <small class="text-muted">
                                        {{ reaction.created_at }}
                                    </small>


                                </div>



                                <p class="mt-2 mb-0">

                                    {{ reaction.message }}

                                </p>



                            </div>



                        </div>



                    </div>



                    <EmptyState
                        v-else
                        icon="bi-chat"
                        title="Geen reacties"
                        message="Er zijn nog geen reacties geplaatst."
                    />



                </ContentCard>





                <!-- Reactie toevoegen -->


                <ContentCard
                    title="Reactie plaatsen"
                    icon="bi-send"
                >


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

                        <i class="bi bi-send me-2"></i>


                        {{ sending 
                            ? 'Versturen...' 
                            : 'Reactie plaatsen'
                        }}


                    </button>



                </ContentCard>



            </div>


        </div>





        <!-- Interne notities -->


        <ContentCard

            v-if="authStore.user?.role === 'admin'"

            title="Interne notities"

            icon="bi-journal-text"

            class="mt-4"

        >


            <div

                v-for="note in notes"

                :key="note.id"

                class="note-item mb-4"

            >


                <strong>
                    {{ note.user?.name }}
                </strong>


                <small class="text-muted ms-2">
                    {{ note.created_at }}
                </small>


                <p class="mt-2">
                    {{ note.note }}
                </p>



                <button

                    class="btn btn-warning btn-sm me-2"

                    @click="editNote(note)"

                >

                    <i class="bi bi-pencil me-1"></i>

                    Bewerken

                </button>




                <button

                    class="btn btn-danger btn-sm"

                    @click="deleteNote(note.id)"

                >

                    <i class="bi bi-trash me-1"></i>

                    Verwijderen

                </button>


            </div>





            <textarea

                v-model="newNote"

                class="form-control"

                rows="3"

                placeholder="Interne notitie..."

            ></textarea>



            <button

                class="btn btn-primary mt-3"

                @click="addNote"

                :disabled="savingNote"

            >

                <i class="bi bi-plus-circle me-2"></i>


                {{ savingNote 
                    ? 'Opslaan...' 
                    : 'Notitie toevoegen'
                }}


            </button>



        </ContentCard>



    </div>
</div>


</template>


<script setup lang="ts">

import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import api from '../api/axios'
import BadgeStatus from "../components/BadgeStatus.vue"



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

    id:number

    name:string

}



interface Note {

    id:number

    note:string

    created_at:string


    user?: {

        name:string

    }

}



const route = useRoute()

const authStore = useAuthStore()



const ticket = ref<Ticket | null>(null)


const loading = ref(true)

const error = ref('')



const newReaction = ref('')

const sending = ref(false)

const reactionError = ref('')

const reactionMessage = ref('')



const selectedStatus = ref('')

const statusMessage = ref('')



const selectedPriority = ref('')

const priorityMessage = ref('')



const admins = ref<Admin[]>([])

const selectedAdmin = ref<number | null>(null)

const assignMessage = ref('')



const notes = ref<Note[]>([])

const newNote = ref('')

const noteError = ref('')

const noteMessage = ref('')

const savingNote = ref(false)



const editingNoteId = ref<number | null>(null)

const editingNoteText = ref('')



const editingReactionId = ref<number | null>(null)

const editingReactionText = ref('')



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

async function loadNotes() {

    try {

        const response = await api.get(
            `/tickets/${route.params.id}/notes`
        )


        notes.value = response.data.notes


    } catch {

        noteError.value =
            'Notities konden niet worden geladen.'

    }

}

async function addNote() {


    if (!newNote.value.trim()) {

        noteError.value =
            'Vul eerst een notitie in.'

        return

    }



    try {


        savingNote.value = true

        noteError.value = ''



        await api.post(
            `/tickets/${route.params.id}/notes`,
            {
                note: newNote.value
            }
        )



        newNote.value = ''



        noteMessage.value =
            'Notitie toegevoegd.'



        await loadNotes()



    } catch {


        noteError.value =
            'Notitie kon niet worden toegevoegd.'


    } finally {


        savingNote.value = false

    }


}

async function deleteNote(id:number) {


    if(!confirm('Notitie verwijderen?')) {

        return

    }


    await api.delete(
        `/notes/${id}`
    )


    await loadNotes()

}

function editReaction(reaction: any) {

    editingReactionId.value = reaction.id

    editingReactionText.value = reaction.message

}

async function updateReaction() {

    if (!editingReactionId.value) {
        return
    }


    try {

        await api.put(
            `/reactions/${editingReactionId.value}`,
            {
                message: editingReactionText.value
            }
        )


        reactionMessage.value =
            'Reactie aangepast.'


        editingReactionId.value = null

        editingReactionText.value = ''


        await loadTicket()


    } catch {

        reactionError.value =
            'Reactie kon niet worden aangepast.'

    }

}

function editNote(note: Note) {

    editingNoteId.value = note.id

    editingNoteText.value = note.note

}

async function updateNote() {

    if (!editingNoteId.value) {

        return

    }


    try {

        await api.put(
            `/notes/${editingNoteId.value}`,
            {
                note: editingNoteText.value
            }
        )


        noteMessage.value =
            'Notitie aangepast.'


        editingNoteId.value = null

        editingNoteText.value = ''


        await loadNotes()


    } catch {

        noteError.value =
            'Notitie kon niet worden aangepast.'

    }

}


onMounted(async () => {

    await loadTicket()


    if(authStore.user?.role === 'admin') {

        await loadAdmins()

        await loadNotes()

    }

})





</script>
<style scoped>

.card {

    border: none;

    border-radius: 16px;

    box-shadow:
        0 8px 24px rgba(0,0,0,.08);

}


.card-header {

    background:white;

    border-bottom:1px solid #e5e7eb;

    border-radius:16px 16px 0 0 !important;

    font-weight:600;

}



h1 {

    letter-spacing:-0.5px;

}



.badge {

    padding:8px 12px;

    border-radius:10px;

}



.btn {

    border-radius:10px;

}



.form-select,
.form-control {

    border-radius:10px;

    border:1px solid #d1d5db;

}



.form-control:focus,
.form-select:focus {

    box-shadow:
        0 0 0 .2rem rgba(13,110,253,.15);

}



.ticket-info-item {

    margin-bottom:15px;

}



.border-bottom {

    border-color:#e5e7eb !important;

}



.card-body p {

    line-height:1.7;

}



textarea {

    resize:none;

}



/* Reacties */

.reaction {

    background:#f8fafc;

    border-radius:12px;

    padding:15px;

}



/* Admin notities */

.note {

    background:#fff7ed;

    border-radius:12px;

    padding:15px;

}

/* Reactie timeline */


.reaction-item {

    display:flex;

    gap:15px;

    padding:18px;

    margin-bottom:15px;

    background:#f8fafc;

    border-radius:14px;

    border-left:4px solid #2563eb;

}



.reaction-avatar {

    width:42px;

    height:42px;

    border-radius:50%;

    background:#2563eb;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:bold;

    flex-shrink:0;

}



.reaction-content {

    flex:1;

}



.reaction-content p {

    color:#334155;

}

.note-item {

    background:#fff7ed;

    border-left:4px solid #f97316;

    padding:18px;

    border-radius:14px;

    margin-bottom:15px;

}

.page-header {

    background:linear-gradient(
        135deg,
        #0d6efd,
        #2563eb
    );

    color:white;

    padding:30px;

    border-radius:18px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    box-shadow:
        0 8px 24px rgba(0,0,0,.15);

}



.page-header p {

    color:rgba(255,255,255,.8);

}



.back-btn {

    border-radius:12px;

    font-weight:600;

}



.ticket-info-card,
.card {


    background:white;

    border:none;

    border-radius:18px;

    padding:25px;

    box-shadow:
        0 8px 24px rgba(0,0,0,.08);

}



.info-item {

    display:flex;

    flex-direction:column;

    gap:10px;

}



.info-text {

    margin-bottom:18px;

}



.info-text p {

    margin-top:5px;

    color:#64748b;

}



.badge {

    width:max-content;

    padding:8px 14px;

    border-radius:12px;

}



.status-large {

    font-size:16px;

}





.form-select,
.form-control {

    border-radius:12px;

}



.btn {

    border-radius:12px;

}




.reaction-item {


    display:flex;

    gap:15px;

    padding:18px;


    background:#f8fafc;


    border-radius:14px;


    border-left:4px solid #2563eb;


    margin-bottom:15px;


}



.reaction-avatar {


    width:45px;

    height:45px;


    border-radius:50%;


    background:#2563eb;

    color:white;


    display:flex;

    align-items:center;

    justify-content:center;


    font-weight:bold;


}



.note-item {


    background:#fff7ed;


    border-left:4px solid #f97316;


    padding:18px;


    border-radius:14px;


}



textarea {

    resize:none;

}



</style>


