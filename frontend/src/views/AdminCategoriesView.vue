<template>

    <div class="container mt-4">

        <h1>
            Categoriebeheer
        </h1>


        <div
            v-if="message"
            class="alert alert-success"
        >
            {{ message }}
        </div>


        <div
            v-if="error"
            class="alert alert-danger"
        >
            {{ error }}
        </div>



        <div class="card mt-4">

            <div class="card-header">

                <h4>
                    Nieuwe categorie
                </h4>

            </div>


            <div class="card-body">


                <input
                    v-model="form.name"
                    class="form-control mb-3"
                    placeholder="Naam categorie"
                >


                <textarea
                    v-model="form.description"
                    class="form-control mb-3"
                    placeholder="Beschrijving"
                ></textarea>


                <button
                    class="btn btn-primary"
                    @click="saveCategory"
                >
                    {{ editingId ? 'Opslaan' : 'Toevoegen' }}
                </button>


                <button
                    v-if="editingId"
                    class="btn btn-secondary ms-2"
                    @click="cancelEdit"
                >
                    Annuleren
                </button>


            </div>

        </div>




        <div class="card mt-4">


            <div class="card-header">

                <h4>
                    Categorieën
                </h4>

            </div>



            <table class="table table-striped mb-0">

                <thead>

                    <tr>

                        <th>
                            Naam
                        </th>

                        <th>
                            Beschrijving
                        </th>

                        <th>
                            Acties
                        </th>

                    </tr>

                </thead>



                <tbody>

                    <tr
                        v-for="category in categories"
                        :key="category.id"
                    >

                        <td>
                            {{ category.name }}
                        </td>


                        <td>
                            {{ category.description }}
                        </td>


                        <td>


                            <button
                                class="btn btn-warning btn-sm me-2"
                                @click="editCategory(category)"
                            >
                                Bewerken
                            </button>



                            <button
                                class="btn btn-danger btn-sm"
                                @click="deleteCategory(category.id)"
                            >
                                Verwijderen
                            </button>


                        </td>


                    </tr>


                </tbody>


            </table>


        </div>


    </div>


</template>




<script setup lang="ts">

import { ref, onMounted } from 'vue'

import api from '../api/axios'



interface Category {

    id:number

    name:string

    description?:string

}




const categories = ref<Category[]>([])


const error = ref('')

const message = ref('')


const editingId = ref<number | null>(null)



const form = ref({

    name:'',

    description:''

})





async function loadCategories(){

    try {


        const response = await api.get('/categories')


        categories.value = response.data.categories



    } catch {


        error.value = 'Categorieën konden niet worden geladen.'


    }

}






async function saveCategory(){


    try {


        if(editingId.value){


            await api.put(
                `/categories/${editingId.value}`,
                form.value
            )


            message.value = 'Categorie aangepast.'



        } else {


            await api.post(
                '/categories',
                form.value
            )


            message.value = 'Categorie toegevoegd.'


        }



        resetForm()

        await loadCategories()



    } catch {


        error.value = 'Opslaan mislukt.'


    }


}






function editCategory(category:Category){


    editingId.value = category.id


    form.value.name = category.name

    form.value.description =
        category.description ?? ''


}







function cancelEdit(){

    resetForm()

}







async function deleteCategory(id:number){


    if(!confirm('Categorie verwijderen?')){

        return

    }



    try {


        await api.delete(
            `/categories/${id}`
        )


        message.value =
            'Categorie verwijderd.'


        await loadCategories()



    } catch {


        error.value =
            'Verwijderen mislukt.'


    }


}







function resetForm(){


    editingId.value = null


    form.value.name = ''

    form.value.description = ''


}







onMounted(loadCategories)



</script>