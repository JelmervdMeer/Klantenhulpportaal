<script setup lang="ts">

import { ref, onMounted } from 'vue'
import api from '../api/axios'
import PageHeader from '../components/PageHeader.vue'
import CategoryCard from '../components/CategoryCard.vue'



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

        <PageHeader
            title="Categoriebeheer"
            subtitle="Beheer ticketcategorieën"
        >

            <button
                class="btn btn-primary"
                @click="openCreate"
            >

                <i class="bi bi-plus-circle me-2"></i>

                Nieuwe categorie

            </button>

        </PageHeader>





        <!-- Meldingen -->

        <div
            v-if="loading"
            class="alert alert-info mt-4"
        >

            Categorieën laden...

        </div>



        <div
            v-if="error"
            class="alert alert-danger mt-4"
        >

            {{ error }}

        </div>





        <!-- Formulier -->

        <ContentCard
            v-if="showForm"
            class="mt-4"
            :title="
                editingId
                    ? 'Categorie aanpassen'
                    : 'Nieuwe categorie'
            "
            icon="bi-tag"
        >

            <div class="row g-3">

                <div class="col-md-6">

                    <input
                        v-model="form.name"
                        class="form-control"
                        placeholder="Naam categorie"
                    >

                </div>

                <div class="col-12">

                    <textarea
                        v-model="form.description"
                        class="form-control"
                        rows="3"
                        placeholder="Omschrijving"
                    ></textarea>

                </div>

            </div>

            <div class="mt-4">

                <button
                    class="btn btn-success me-2"
                    @click="saveCategory"
                >

                    <i class="bi bi-check-circle me-2"></i>

                    Opslaan

                </button>

                <button
                    class="btn btn-secondary"
                    @click="showForm = false"
                >

                    Annuleren

                </button>

            </div>

        </ContentCard>





        <!-- Geen categorieën -->

        <EmptyState
            v-if="!loading && !categories.length"
            class="mt-4"
            icon="bi-tags"
            title="Geen categorieën gevonden"
            text="Er zijn nog geen ticketcategorieën aangemaakt."
        />





        <!-- Categorie kaarten -->

        <ContentCard
            v-if="categories.length"
            class="mt-4"
            title="Categorieën"
            icon="bi-tags"
        >

            <div class="row g-4">

                <div
                    v-for="category in categories"
                    :key="category.id"
                    class="col-xl-4 col-lg-6"
                >

                    <CategoryCard
                        :category="category"
                        @edit="editCategory"
                        @delete="deleteCategory"
                    />

                </div>

            </div>

        </ContentCard>

    </div>

</template>


<style scoped>

.card {

    border-radius:16px;

}


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