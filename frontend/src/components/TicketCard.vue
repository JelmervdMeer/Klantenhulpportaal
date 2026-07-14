<template>

    <div
        class="ticket-card"
        @click="$emit('open', ticket.id)"
    >


        <div class="ticket-header">


            <div>

                <h5 class="mb-0">
                    #{{ ticket.id }} {{ ticket.title }}
                </h5>

            </div>


            <span
                class="priority-dot"
                :class="priorityDotClass(ticket.priority)"
                :title="ticket.priority"
            ></span>


        </div>





        <div class="ticket-body">


            <div class="mb-3">


                <span
                    class="badge me-2"
                    :class="statusClass(ticket.status)"
                >

                    {{ ticket.status }}

                </span>




                <span
                    class="badge"
                    :class="priorityClass(ticket.priority)"
                >

                    {{ ticket.priority }}

                </span>


            </div>





            <p class="mb-2">

                <i class="bi bi-tag me-2"></i>

                {{ ticket.category?.name }}

            </p>





            <p class="mb-0 text-muted">

                <i class="bi bi-person me-2"></i>

                {{ ticket.user?.name }}

            </p>


        </div>


    </div>


</template>





<script setup lang="ts">


defineProps<{

    ticket:any

}>()





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







function priorityClass(priority:string){


    switch(priority){

        case 'Laag':
            return 'bg-success'

        case 'Normaal':
            return 'bg-warning text-dark'

        case 'Hoog':
            return 'bg-danger'

        default:
            return 'bg-secondary'

    }

}






function priorityDotClass(priority:string){


    switch(priority){


        case 'Hoog':
            return 'dot-high'


        case 'Normaal':
            return 'dot-normal'


        case 'Laag':
            return 'dot-low'


        default:
            return ''

    }

}


</script>





<style scoped>


.ticket-card {


    background:white;


    border-radius:18px;


    overflow:hidden;


    cursor:pointer;


    height:100%;


    box-shadow:
        0 8px 24px rgba(0,0,0,.08);


    transition:.25s;


}



.ticket-card:hover {


    transform:translateY(-5px);


    box-shadow:
        0 14px 30px rgba(0,0,0,.15);


}







.ticket-header {


    background:#2563eb;


    color:white;


    padding:14px 18px;


    display:flex;


    justify-content:space-between;


    align-items:center;


}





.ticket-header h5 {


    font-size:16px;


    font-weight:700;


    margin:0;


}






/* Prioriteit stip */


.priority-dot {


    width:14px;


    height:14px;


    border-radius:50%;


    display:block;


    border:2px solid white;


}






.dot-high {


    background:#dc3545;


}





.dot-normal {


    background:#ffc107;


}





.dot-low {


    background:#198754;


}






.ticket-body {


    padding:22px;


}






.badge {


    padding:8px 12px;


    border-radius:10px;


}


</style>