<template>

<div class="container-fluid">


    <!-- Meldingen -->

    <div
        v-if="loading"
        class="alert alert-info mt-4"
    >
        <i class="bi bi-hourglass-split me-2"></i>
        Ticket laden...
    </div>



    <div
        v-if="error"
        class="alert alert-danger mt-4"
    >
        <i class="bi bi-exclamation-triangle me-2"></i>
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








        <div class="row g-4 mt-1">





            <!-- Linker kolom -->

            <div class="col-xl-4">



                <ContentCard
                    title="Ticket informatie"
                    icon="bi-info-circle"
                >




                    <!-- Status -->


                    <div class="ticket-detail-item">


                        <label>
                            Status
                        </label>


                        <BadgeStatus
                            type="status"
                            :value="ticket.status"
                        />


                    </div>





                    <!-- Status wijzigen admin -->


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







                    <hr>







                    <!-- Prioriteit -->


                    <div class="ticket-detail-item">


                        <label>
                            Prioriteit
                        </label>


                        <BadgeStatus
                            type="priority"
                            :value="ticket.priority"
                        />


                    </div>







                    <!-- Prioriteit wijzigen -->


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








                    <hr>








                    <!-- Categorie -->


                    <div class="ticket-detail-item">


                        <label>
                            Categorie
                        </label>


                        <p>

                            <i class="bi bi-tag me-2"></i>

                            {{ ticket.category?.name ?? 'Geen categorie' }}

                        </p>


                    </div>








                    <!-- Aangemaakt door -->


                    <div class="ticket-detail-item">


                        <label>
                            Aangemaakt door
                        </label>


                        <p>

                            <i class="bi bi-person me-2"></i>

                            {{ ticket.user?.name ?? 'Onbekend' }}

                        </p>


                    </div>







                    <!-- Toegewezen admin -->


                    <div class="ticket-detail-item">


                        <label>
                            Toegewezen aan
                        </label>


                        <p>

                            <i class="bi bi-person-badge me-2"></i>


                            {{ 
                                ticket.assignedAdmin?.name 
                                ?? 'Nog niet toegewezen' 
                            }}


                        </p>


                    </div>







                    <!-- Admin toewijzen -->


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





                </ContentCard>




            </div>
                        <!-- Rechter kolom -->

            <div class="col-xl-8">





                <!-- Beschrijving -->

                <ContentCard
                    title="Beschrijving"
                    icon="bi-file-text"
                    class="mb-4"
                >


                    <div class="ticket-description">


                        {{ ticket.description }}


                    </div>


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
                            class="reaction-card"
                        >




                            <!-- Avatar -->


                            <div class="reaction-avatar">


                                {{
                                    reaction.user?.name
                                    ?.charAt(0)
                                    .toUpperCase()
                                }}


                            </div>







                            <!-- Reactie inhoud -->


                            <div class="reaction-content">



                                <div class="d-flex justify-content-between align-items-center">


                                    <strong>

                                        {{ reaction.user?.name }}

                                    </strong>



                                    <small class="text-muted">


                                        {{ reaction.created_at }}


                                    </small>



                                </div>






                                <p class="mb-0 mt-2">


                                    {{ reaction.message }}


                                </p>





                            </div>




                        </div>





                    </div>






                    <EmptyState

                        v-else

                        icon="bi-chat"

                        title="Geen reacties"

                        text="Er zijn nog geen reacties geplaatst."

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




                        {{
                            sending
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
                v-if="notes.length"
            >



                <div

                    v-for="note in notes"

                    :key="note.id"

                    class="note-card"

                >





                    <div class="d-flex justify-content-between">


                        <strong>


                            <i class="bi bi-person me-2"></i>


                            {{ note.user?.name }}


                        </strong>




                        <small class="text-muted">


                            {{ note.created_at }}


                        </small>



                    </div>







                    <p class="mt-3 mb-3">


                        {{ note.note }}


                    </p>







                    <div>


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




                </div>




            </div>







            <EmptyState

                v-else

                icon="bi-journal"

                title="Geen notities"

                text="Er zijn nog geen interne notities."

            />







            <textarea

                v-model="newNote"

                class="form-control mt-4"

                rows="3"

                placeholder="Interne notitie..."

            ></textarea>






            <button

                class="btn btn-primary mt-3"

                @click="addNote"

                :disabled="savingNote"

            >



                <i class="bi bi-plus-circle me-2"></i>



                {{
                    savingNote
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

import api from '../api/axios'
import { useAuthStore } from '../stores/auth'

import BadgeStatus from '../components/BadgeStatus.vue'


interface User {

    id:number
    name:string

}



interface Category {

    name:string

}



interface Reaction {


    id:number

    message:string

    created_at:string


    user?:User


}



interface Ticket {


    id:number

    title:string

    description:string

    status:string

    priority:string


    category?:Category


    user?:User


    reactions?:Reaction[]


    assigned_to?:number | null


    assignedAdmin?:User


}




interface Admin {

    id:number

    name:string

}





interface Note {


    id:number

    note:string

    created_at:string


    user?:User


}







const route = useRoute()

const authStore = useAuthStore()





const ticket = ref<Ticket | null>(null)



const loading = ref(true)

const error = ref('')





// Reacties

const newReaction = ref('')

const sending = ref(false)

const reactionError = ref('')

const reactionMessage = ref('')







// Status

const selectedStatus = ref('')

const statusMessage = ref('')







// Prioriteit

const selectedPriority = ref('')

const priorityMessage = ref('')







// Admin toewijzen

const admins = ref<Admin[]>([])

const selectedAdmin = ref<number | null>(null)

const assignMessage = ref('')







// Notities

const notes = ref<Note[]>([])

const newNote = ref('')

const noteError = ref('')

const noteMessage = ref('')

const savingNote = ref(false)







const editingNoteId = ref<number | null>(null)

const editingNoteText = ref('')







async function loadTicket() {


    try {


        const response = await api.get(
            `/tickets/${route.params.id}`
        )



        ticket.value = response.data.ticket



        selectedStatus.value =
            response.data.ticket.status



        selectedPriority.value =
            response.data.ticket.priority



        selectedAdmin.value =
            response.data.ticket.assigned_to



    } catch {


        error.value =
            'Ticket kon niet worden geladen.'



    } finally {


        loading.value = false


    }


}









async function updateStatus() {


    if (!ticket.value) return



    try {


        await api.put(

            `/tickets/${ticket.value.id}/status`,

            {
                status:selectedStatus.value
            }

        )



        ticket.value.status =
            selectedStatus.value



        statusMessage.value =
            'Status succesvol gewijzigd.'



    } catch {


        statusMessage.value =
            'Status kon niet worden gewijzigd.'


    }


}









async function updatePriority() {


    if (!ticket.value) return



    try {


        await api.put(

            `/tickets/${ticket.value.id}/priority`,

            {
                priority:selectedPriority.value
            }

        )



        ticket.value.priority =
            selectedPriority.value



        priorityMessage.value =
            'Prioriteit succesvol gewijzigd.'



    } catch {


        priorityMessage.value =
            'Prioriteit kon niet worden gewijzigd.'


    }


}









async function addReaction() {


    if (!newReaction.value.trim()) {


        reactionError.value =
            'Vul eerst een reactie in.'


        return

    }




    try {


        sending.value = true



        await api.post(

            `/tickets/${route.params.id}/reactions`,

            {
                message:newReaction.value
            }

        )



        newReaction.value = ''



        await loadTicket()



    } catch {


        reactionError.value =
            'Reactie kon niet worden geplaatst.'



    } finally {


        sending.value = false


    }


}









async function loadAdmins() {


    try {


        const response =
            await api.get('/admins')



        admins.value =
            response.data.admins



    } catch {


        console.error(
            'Admins laden mislukt'
        )


    }


}









async function assignAdmin() {


    if (!ticket.value) return



    try {


        await api.put(

            `/tickets/${ticket.value.id}/assign`,

            {
                assigned_to:selectedAdmin.value
            }

        )



        const admin =
            admins.value.find(

                item =>
                item.id === selectedAdmin.value

            )



        ticket.value.assignedAdmin =
            admin



        assignMessage.value =
            'Administrator toegewezen.'



    } catch {


        assignMessage.value =
            'Administrator kon niet worden toegewezen.'



    }


}









async function loadNotes() {


    try {


        const response =
            await api.get(

                `/tickets/${route.params.id}/notes`

            )



        notes.value =
            response.data.notes



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



        await api.post(

            `/tickets/${route.params.id}/notes`,

            {
                note:newNote.value
            }

        )



        newNote.value = ''



        await loadNotes()



    } catch {


        noteError.value =
            'Notitie kon niet worden toegevoegd.'



    } finally {


        savingNote.value = false


    }


}

async function deleteNote(id:number) {


    if (!confirm('Notitie verwijderen?')) {

        return

    }



    try {


        await api.delete(
            `/notes/${id}`
        )


        await loadNotes()



    } catch {


        noteError.value =
            'Notitie kon niet worden verwijderd.'


    }


}








function editNote(note:Note) {


    editingNoteId.value =
        note.id


    editingNoteText.value =
        note.note


}








async function updateNote() {


    if (!editingNoteId.value) {

        return

    }



    try {


        await api.put(

            `/notes/${editingNoteId.value}`,

            {
                note:editingNoteText.value
            }

        )



        editingNoteId.value = null

        editingNoteText.value = ''



        await loadNotes()



    } catch {


        noteError.value =
            'Notitie kon niet worden aangepast.'



    }


}









onMounted(async()=>{


    await loadTicket()



    if(authStore.user?.role === 'admin'){


        await loadAdmins()


        await loadNotes()


    }


})



</script>
<style scoped>


.ticket-info {

    line-height:1.7;

}



.info-block {

    margin-bottom:22px;

}



.info-block strong {

    display:block;

    margin-bottom:8px;

    font-weight:700;

    color:#334155;

}



.info-value {

    color:#64748b;

}







.form-select,
.form-control {

    border-radius:12px;

    padding:10px 14px;

    border:1px solid #d1d5db;

}



.form-select:focus,
.form-control:focus {

    border-color:#2563eb;

    box-shadow:
        0 0 0 .2rem rgba(37,99,235,.15);

}








.btn {

    border-radius:12px;

    font-weight:600;

}









/*
    Reacties
*/



.reaction-item {


    display:flex;

    gap:15px;

    padding:18px;

    margin-bottom:15px;

    background:#f8fafc;

    border-radius:16px;

    border-left:4px solid #2563eb;

    transition:.25s ease;


}



.reaction-item:hover {


    transform:translateX(4px);

    background:#f1f5f9;


}






.reaction-avatar {


    width:45px;

    height:45px;

    flex-shrink:0;

    border-radius:50%;

    background:#2563eb;

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:700;

}





.reaction-content {

    flex:1;

}






.reaction-content p {

    color:#475569;

    line-height:1.6;

}










/*
    Notities
*/



.note-item {


    background:#fff7ed;

    border-left:4px solid #f97316;

    padding:18px;

    border-radius:16px;

    margin-bottom:18px;

    transition:.25s ease;


}




.note-item:hover {


    transform:translateX(4px);


}










/*
    Ticket detail layout
*/



.ticket-description {


    color:#475569;

    line-height:1.8;


}




.ticket-meta {


    display:flex;

    flex-direction:column;

    gap:14px;


}










textarea {


    resize:none;


}









/*
    Kleine schermen
*/



@media(max-width:768px){


    .reaction-item {

        flex-direction:column;

    }


}


</style>


