<template>

    <div class="card shadow-sm border-0 content-card">

        <div class="card-body">


            <!-- Titel -->
            <div
                v-if="title"
                class="content-header mb-4"
            >

                <h4 class="fw-bold mb-0">

                    <i
                        v-if="icon"
                        :class="`bi ${icon} me-2`"
                    ></i>

                    {{ title }}

                </h4>


            </div>



            <!-- Inhoud van de card -->

            <slot></slot>


        </div>


    </div>


</template>


<script setup lang="ts">


defineProps({

    title:{
        type:String,
        default:''
    },


    icon:{
        type:String,
        default:''
    }

})


</script>


<style scoped>


.content-card {

    border-radius:18px;

}


.content-header i {

    color:#2563eb;

}



</style>