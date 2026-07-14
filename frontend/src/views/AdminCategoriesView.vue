<script setup lang="ts">

import { ref, onMounted } from 'vue'
import api from '../api/axios'


interface Category {

    id:number

    name:string

    description:string

}


const categories = ref<Category[]>([])


const loading = ref(true)


const error = ref('')


const showForm = ref(false)


const editingId = ref<number | null>(null)



const form = ref({

    name:'',

    description:''

})



async function loadCategories(){

    try{

        const response = await api.get('/categories')


        categories.value =
            response.data.categories


    }catch{

        error.value =
            'Categorieën konden niet worden geladen.'

    }
    finally{

        loading.value = false

    }

}



function openCreate(){

    editingId.value = null


    form.value = {

        name:'',

        description:''

    }


    showForm.value = true

}



function editCategory(category:Category){

    editingId.value = category.id


    form.value = {

        name:category.name,

        description:category.description

    }


    showForm.value = true

}



async function saveCategory(){


    try{


        if(editingId.value){


            await api.put(

                `/categories/${editingId.value}`,

                form.value

            )


        }else{


            await api.post(

                '/categories',

                form.value

            )


        }


        showForm.value = false


        await loadCategories()



    }catch{

        error.value =
            'Categorie kon niet worden opgeslagen.'

    }


}



async function deleteCategory(id:number){


    if(!confirm('Categorie verwijderen?')){

        return

    }


    await api.delete(
        `/categories/${id}`
    )


    await loadCategories()

}



onMounted(loadCategories)


</script>
<template>

<div class="container-fluid">


    <!-- Pagina header -->

    <div class="page-header mb-4">


        <div>

            <h1 class="fw-bold mb-1">
                Categoriebeheer
            </h1>


            <p class="mb-0">
                Beheer ticketcategorieën
            </p>


        </div>



        <button
            class="btn btn-light new-category-btn"
            @click="openCreate"
        >

            <i class="bi bi-plus-circle me-2"></i>

            Nieuwe categorie

        </button>


    </div>





    <!-- Meldingen -->


    <div
        v-if="loading"
        class="alert alert-info"
    >

        Categorieën laden...

    </div>



    <div
        v-if="error"
        class="alert alert-danger"
    >

        {{ error }}

    </div>







    <!-- Formulier -->


    <div
        v-if="showForm"
        class="card form-card mb-4"
    >

        <div class="card-body">


            <h4 class="fw-bold mb-3">

                {{ editingId 
                    ? 'Categorie aanpassen' 
                    : 'Nieuwe categorie' 
                }}

            </h4>



            <input
                v-model="form.name"
                class="form-control mb-3"
                placeholder="Naam categorie"
            >



            <textarea
                v-model="form.description"
                class="form-control mb-3"
                rows="3"
                placeholder="Omschrijving"
            ></textarea>




            <button
                class="btn btn-success me-2"
                @click="saveCategory"
            >

                <i class="bi bi-check-circle me-2"></i>

                Opslaan

            </button>




            <button
                class="btn btn-secondary"
                @click="showForm=false"
            >

                Annuleren

            </button>


        </div>

    </div>







    <!-- Categorie kaarten -->


    <div class="row category-grid">


        <div
            v-for="category in categories"
            :key="category.id"
            class="col-xl-4 col-lg-6 category-column"
        >


            <div class="category-card">


                <div class="category-icon">

                    <i class="bi bi-tag"></i>

                </div>



                <h4 class="fw-bold">

                    {{ category.name }}

                </h4>



                <p class="text-muted">

                    {{ category.description }}

                </p>



                <div class="category-actions">


                    <button
                        class="btn btn-warning btn-sm"
                        @click="editCategory(category)"
                    >

                        <i class="bi bi-pencil"></i>

                        Bewerken

                    </button>




                    <button
                        class="btn btn-danger btn-sm"
                        @click="deleteCategory(category.id)"
                    >

                        <i class="bi bi-trash"></i>

                        Verwijderen

                    </button>


                </div>



            </div>



        </div>


    </div>



</div>

</template>
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



.new-category-btn {

    padding:12px 22px;

    border-radius:12px;

    font-weight:600;

}




.card {

    border:none;

    border-radius:18px;

    box-shadow:
        0 8px 24px rgba(0,0,0,.08);

}



.form-card {

    background:white;

}





.category-grid {

    margin-top:10px;

}



.category-column {

    padding:12px;

}





.category-card {


    background:white;

    border-radius:18px;

    padding:25px;

    height:100%;

    box-shadow:
        0 8px 24px rgba(0,0,0,.08);


    transition:.25s;

}



.category-card:hover {


    transform:translateY(-5px);


    box-shadow:
        0 14px 30px rgba(0,0,0,.15);


}





.category-icon {


    width:50px;

    height:50px;

    border-radius:14px;

    background:#dbeafe;

    color:#2563eb;


    display:flex;

    align-items:center;

    justify-content:center;


    font-size:24px;


    margin-bottom:18px;


}





.category-card p {

    min-height:50px;

}




.category-actions {


    display:flex;

    gap:10px;

    margin-top:20px;


}



</style>