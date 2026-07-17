<template>

    <div class="base-card card shadow-sm border-0 h-100">


        <div class="card-body d-flex flex-column">


            <!-- Titel gedeelte (optioneel) -->


            <div
                v-if="title || icon"
                class="d-flex align-items-center mb-4"
            >


                <div
                    v-if="icon"
                    class="card-icon me-3"
                >

                    <i
                        class="bi"
                        :class="icon"
                    ></i>


                </div>




                <h4
                    v-if="title"
                    class="fw-bold mb-0"
                >

                    {{ title }}

                </h4>



            </div>







            <!-- Hoofd inhoud -->


            <div class="flex-grow-1">


                <slot></slot>


            </div>







            <!-- Actie knoppen -->


            <div
                v-if="$slots.actions"
                class="mt-auto pt-4"
            >


                <slot name="actions"></slot>


            </div>



        </div>


    </div>


</template>







<script setup lang="ts">


defineProps<{

    title?:string

    icon?:string


}>()



</script>







<style scoped>


.base-card {


    border-radius:18px;


    overflow:hidden;


    transition:.25s ease;


}






.base-card:hover {


    transform:translateY(-6px);


    box-shadow:
        0 14px 30px rgba(0,0,0,.15) !important;


}







.card-icon {


    width:45px;


    height:45px;


    border-radius:12px;


    display:flex;


    align-items:center;


    justify-content:center;


    background:#e7f1ff;


    color:#0d6efd;


    font-size:22px;


}





</style>