<template>

<div
    class="base-card"
    :class="{ clickable }"
>


    <!-- Header -->

    <div
        v-if="title || icon"
        class="card-header-custom"
    >

        <h4 class="fw-bold mb-0">

            <i
                v-if="icon"
                :class="`bi ${icon} me-2`"
            ></i>


            {{ title }}

        </h4>


    </div>





    <!-- Content -->

    <div class="card-content">


        <slot></slot>


    </div>






    <!-- Footer / knoppen -->

    <div
        v-if="$slots.actions"
        class="card-actions"
    >

        <slot name="actions"></slot>


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
    },


    clickable:{
        type:Boolean,
        default:false
    }


})


</script>






<style scoped>


.base-card {


    background:white;


    border-radius:18px;


    box-shadow:
        0 8px 24px rgba(0,0,0,.08);


    padding:25px;


    height:100%;


    display:flex;


    flex-direction:column;


    transition:.25s;

    box-shadow: .25s ease;


}

.base-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(0,0,0,.15);
}





.clickable {


    cursor:pointer;


}





.clickable:hover {


    transform:translateY(-5px);


    box-shadow:
        0 14px 30px rgba(0,0,0,.15);


}





.card-header-custom {


    margin-bottom:20px;


}





.card-content {


    flex:1;


}





.card-actions {


    margin-top:auto;


    padding-top:25px;


}



</style>