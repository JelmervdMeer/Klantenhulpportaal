<template>

<div class="card shadow-sm border-0 h-100">


    <div class="card-body d-flex flex-column">


        <div class="category-icon mb-3">

            <i class="bi bi-tag-fill"></i>

        </div>



        <h4 class="fw-bold">

            {{ category.name }}

        </h4>



        <p class="text-muted">

            {{ category.description }}

        </p>




        <div class="d-flex gap-2 mt-auto pt-4">


            <button
                class="btn btn-primary flex-fill"
                @click="$emit('edit', category)"
            >

                <i class="bi bi-pencil me-2"></i>

                Bewerken

            </button>




            <button
                class="btn btn-danger flex-fill"
                @click="$emit('delete', category.id)"
            >

                <i class="bi bi-trash me-2"></i>

                Verwijderen

            </button>


        </div>


    </div>


</div>


</template>





<script setup lang="ts">


interface Category {

    id:number

    name:string

    description:string

}


defineProps<{

    category:Category

}>()



defineEmits<{

    edit:[category:Category]

    delete:[id:number]

}>()



</script>





<style scoped>


.category-icon {

    width:60px;

    height:60px;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#e7f1ff;

    color:#0d6efd;

    font-size:28px;

}


</style>