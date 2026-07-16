<template>

    <div class="card shadow-sm border-0 h-100">

        <div class="card-body d-flex align-items-center gap-3">

            <div
                class="icon"
                :class="`bg-${color}`"
            >

                <i :class="`bi ${icon}`"></i>

            </div>


            <div>

                <small class="text-muted">
                    {{ title }}
                </small>


                <h2 class="fw-bold mb-0">
                    {{ value }}
                </h2>

            </div>


        </div>

    </div>

</template>


<script setup lang="ts">

defineProps({

    title:{
        type:String,
        required:true
    },

    value:{
        type:Number,
        required:true
    },

    icon:{
        type:String,
        required:true
    },

    color:{
        type:String,
        default:'primary'
    }

})

</script>


<style scoped>

.icon {

    width:48px;

    height:48px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:12px;

    color:white;

    font-size:22px;

}

</style>