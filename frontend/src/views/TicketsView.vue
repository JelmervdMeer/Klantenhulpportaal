<template>

<div class="container-fluid">


    <!-- Pagina header -->

    <div class="page-header mb-4">


        <div>

            <h1 class="fw-bold mb-1">
                Mijn tickets
            </h1>


            <p class="mb-0">
                Beheer en volg jouw hulpvragen
            </p>


        </div>



        <RouterLink
            to="/tickets/create"
            class="btn btn-light new-ticket-btn"
        >

            <i class="bi bi-plus-circle me-2 plus-icon"></i>

            

        </RouterLink>


    </div>





    <!-- Filters -->


    <div class="card filter-card mb-4">


        <div class="card-body">


            <div class="row g-3 filter-row">


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
                        class="btn btn-secondary w-100 clear-btn"
                        @click="clearFilters"
                    >

                        Wissen

                    </button>

                </div>


            </div>


        </div>


    </div>






    <!-- Meldingen -->


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







    <!-- Ticket kaarten -->


    <div
        v-if="tickets.length"
        class="ticket-grid"
    >


        <TicketCard

            v-for="ticket in tickets"

            :key="ticket.id"

            :ticket="ticket"

            @open="openTicket"

        />


    </div>






    <div
        v-if="!loading && !tickets.length && !error"
        class="alert alert-warning mt-4"
    >

        Geen tickets gevonden.

    </div>


</div>

</template>





<script setup lang="ts">


import {
    ref,
    onMounted,
    watch
} from 'vue'


import {
    useRouter
} from 'vue-router'


import api from '../api/axios'


import TicketCard from '../components/TicketCard.vue'





interface Ticket {


    id:number


    title:string


    status:string


    priority:string



    category?: {

        name:string

    }



    user?: {

        name:string

    }


}





const router = useRouter()



const tickets = ref<Ticket[]>([])


const loading = ref(true)


const error = ref('')



const search = ref('')


const selectedStatus = ref('')


const selectedPriority = ref('')







function openTicket(id:number){

    router.push(`/tickets/${id}`)

}









async function loadTickets(){


    try {


        loading.value = true



        const response = await api.get('/tickets', {


            params:{


                search:
                    search.value || undefined,


                status:
                    selectedStatus.value || undefined,


                priority:
                    selectedPriority.value || undefined


            }


        })



        tickets.value = response.data.tickets



    } catch {


        error.value =
            'Tickets konden niet worden geladen.'



    } finally {


        loading.value = false


    }


}







function clearFilters(){


    search.value = ''


    selectedStatus.value = ''


    selectedPriority.value = ''



    loadTickets()


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



.new-ticket-btn {


    padding:12px 22px;


    border-radius:12px;


    font-weight:600;


}



.filter-card {


    border:none;


    border-radius:18px;


    box-shadow:
        0 8px 24px rgba(0,0,0,.08);


}




.clear-btn {

    border-radius:12px;

}





.ticket-grid {


    display:grid;


    grid-template-columns:
        repeat(auto-fit, minmax(320px, 1fr));


    gap:24px;


}

.plus-icon {

    font-size: 28px;
    color: white;

}

.filter-row{
    display: flex;
    justify-content: space-around;
    margin-bottom: 2rem;
    margin-top: 2rem;
    font-size: 18px;
}



</style>