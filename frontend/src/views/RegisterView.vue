<template>

<div class="container-fluid">


    <!-- Pagina header -->


    <div class="page-header mb-4">


        <div>


            <h1 class="fw-bold mb-1">

                Registreren

            </h1>


            <p class="mb-0">

                Maak een nieuw account aan voor het klantenhulpportaal

            </p>


        </div>


    </div>






    <div class="row justify-content-center">


        <div class="col-lg-6">



            <div class="register-card">



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







               <div class="form-group mb-4">


    <label class="form-label">
        Naam
    </label>


    <input
        v-model="form.name"
        class="form-control"
        placeholder="Naam"
    >


</div>





<div class="form-group mb-4">


    <label class="form-label">
        Email
    </label>


    <input
        v-model="form.email"
        class="form-control"
        placeholder="Email"
        type="email"
    >


</div>






<div class="form-group mb-5">


    <label class="form-label">
        Wachtwoord
    </label>


    <input
        v-model="form.password"
        class="form-control"
        placeholder="Wachtwoord"
        type="password"
    >


</div>







                <button
                    class="btn btn-primary w-100"
                    @click="register"
                    :disabled="loading"
                >


                    <i class="bi bi-person-plus me-2"></i>


                    {{ loading ? 'Registreren...' : 'Registreren' }}


                </button>





            </div>



        </div>


    </div>



</div>

</template>





<script setup lang="ts">


import { ref } from 'vue'

import api from '../api/axios'





const form = ref({

    name: '',

    email: '',

    password: ''

})





const loading = ref(false)

const error = ref('')

const message = ref('')







async function register(){


    try {


        loading.value = true

        error.value = ''



        const response = await api.post(
            '/register',
            form.value
        )



        console.log(response.data)



        message.value =
            'Registratie gelukt. Controleer je email om je account te bevestigen.'





        form.value = {

            name: '',

            email: '',

            password: ''

        }





    } catch(err:any){



        error.value =
            err.response?.data?.message ??
            'Registreren mislukt.'



    } finally {


        loading.value = false


    }


}



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





.register-card {


    background:white;


    padding:30px;


    border-radius:18px;


    box-shadow:
        0 8px 24px rgba(0,0,0,.08);


}





.form-label {


    font-weight:600;


    color:#334155;


}





.form-control {


    border-radius:12px;


    padding:12px 15px;


    border:1px solid #d1d5db;


}





.form-control:focus {


    border-color:#2563eb;


    box-shadow:
        0 0 0 .2rem rgba(37,99,235,.15);


}





.btn {


    border-radius:12px;


    padding:12px;


    font-weight:600;


}

.form-control {

    border-radius:12px;

    padding:14px 16px;

    border:1px solid #d1d5db;

    font-size:15px;

}


.form-group {

    margin-bottom:24px;

}


</style>