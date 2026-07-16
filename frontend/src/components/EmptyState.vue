<template>

    <div class="empty-state text-center p-5">


        <div class="empty-icon mb-3">

            <i :class="`bi ${icon}`"></i>

        </div>



        <h4 class="fw-bold mb-2">

            {{ title }}

        </h4>



        <p class="text-muted mb-0">

            {{ text }}

        </p>



        <slot></slot>


    </div>


</template>





<script setup lang="ts">


defineProps({

    icon: {

        type:String,

        default:'bi-inbox'

    },


    title: {

        type:String,

        required:true

    },


    text: {

        type:String,

        default:''

    }


})


</script>





<style scoped>


.empty-state {


    background:white;

    border-radius:18px;

    box-shadow:
        0 8px 24px rgba(0,0,0,.08);


}



.empty-icon {


    width:70px;

    height:70px;

    margin:auto;


    display:flex;

    align-items:center;

    justify-content:center;


    border-radius:50%;


    background:#dbeafe;

    color:#2563eb;


    font-size:32px;


}



</style>