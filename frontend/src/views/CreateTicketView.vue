<template>

<div class="container-fluid">



    <!-- Pagina header -->


    <div class="page-header mb-4">


        <div>


            <h1 class="fw-bold mb-1">

                Nieuw ticket maken

            </h1>


            <p class="mb-0">

                Maak een nieuwe hulpvraag aan

            </p>


        </div>


    </div>







    <div class="row justify-content-center">


        <div class="col-lg-8">



            <div class="ticket-form-card">





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








                <form @submit.prevent="createTicket">





                    <div class="form-group">


                        <label class="form-label">

                            Titel

                        </label>


                        <input
                            v-model="form.title"
                            type="text"
                            class="form-control"
                            placeholder="Titel van je probleem"
                            required
                        >


                    </div>








                    <div class="form-group">


                        <label class="form-label">

                            Beschrijving

                        </label>



                        <textarea

                            v-model="form.description"

                            class="form-control"

                            rows="6"

                            placeholder="Beschrijf je probleem zo duidelijk mogelijk..."

                            required

                        ></textarea>



                    </div>








                    <div class="form-group">


                        <label class="form-label">

                            Categorie

                        </label>



                        <select

                            v-model="form.category_id"

                            class="form-select"

                            required

                        >


                            <option value="">

                                Kies categorie

                            </option>



                            <option

                                v-for="category in categories"

                                :key="category.id"

                                :value="category.id"

                            >

                                {{ category.name }}

                            </option>


                        </select>



                    </div>








                    <div class="form-group priority-group">


                        <label class="form-label">

                            Prioriteit

                        </label>




                        <select

                            v-model="form.priority"

                            class="form-select"

                        >


                            <option value="Laag">

                                Laag

                            </option>



                            <option value="Normaal">

                                Normaal

                            </option>



                            <option value="Hoog">

                                Hoog

                            </option>



                        </select>



                    </div>








                    <button

                        class="btn btn-primary w-100"

                        type="submit"

                    >


                        <i class="bi bi-send me-2"></i>


                        Ticket aanmaken


                    </button>





                </form>




            </div>


        </div>


    </div>




</div>

</template>









<script setup lang="ts">


import { ref, onMounted } from 'vue'

import { useRouter } from 'vue-router'

import api from '../api/axios'





const router = useRouter()





const form = ref({

    title: '',

    description: '',

    category_id: '',

    priority: 'Normaal'

})







interface Category {


    id:number

    name:string


}







const categories = ref<Category[]>([])



const message = ref('')

const error = ref('')








async function loadCategories(){


    try {


        const response = await api.get('/categories')


        categories.value =
            response.data.categories



    } catch {


        error.value =
            'Categorieën konden niet worden geladen.'


    }


}








async function createTicket(){


    try {


        await api.post(
            '/tickets',
            form.value
        )



        message.value =
            'Ticket succesvol aangemaakt.'





        setTimeout(() => {


            router.push('/tickets')


        },1000)





    } catch {


        error.value =
            'Ticket kon niet worden aangemaakt.'


    }


}








onMounted(loadCategories)





</script>








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







.ticket-form-card {


    background:white;


    padding:35px;


    border-radius:18px;


    box-shadow:


        0 8px 24px rgba(0,0,0,.08);


}







.form-group {


    margin-bottom:28px;


}







.priority-group {


    margin-bottom:35px;


}







.form-label {


    display:block;


    margin-bottom:10px;


    font-weight:600;


    color:#334155;


}







.form-control,
.form-select {


    border-radius:12px;


    padding:14px 16px;


    border:1px solid #d1d5db;


    font-size:15px;


}







.form-control:focus,
.form-select:focus {


    border-color:#2563eb;


    box-shadow:

        0 0 0 .2rem rgba(37,99,235,.15);


}







textarea {


    resize:none;


}







.btn {


    border-radius:12px;


    padding:13px;


    font-weight:600;


}







.alert {


    border-radius:12px;


}



</style>