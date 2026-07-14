<template>

<div class="login-page">


    <div class="login-card">


        <!-- Branding -->

        <div class="login-brand">


            <div class="logo">

                <i class="bi bi-life-preserver"></i>

            </div>


            <h1 class="fw-bold mb-2 text-center">
                Klantenhulpportaal
            </h1>


            <p class="mb-0 text-center">
                Ticketbeheer & klantenondersteuning
            </p>


        </div>





        <!-- Login formulier -->

        <div class="login-body">


            <h3 class="text-center fw-bold mb-4">
                Inloggen
            </h3>




            <form @submit.prevent="login">



                <div class="form-group">


                    <label class="form-label">
                        Email
                    </label>


                    <input

                        v-model="email"

                        type="email"

                        class="form-control"

                        placeholder="Emailadres"

                        required

                    >


                </div>






                <div class="form-group">


                    <label class="form-label">
                        Wachtwoord
                    </label>


                    <input

                        v-model="password"

                        type="password"

                        class="form-control"

                        placeholder="Wachtwoord"

                        required

                    >


                </div>







                <button

                    type="submit"

                    class="btn btn-primary w-100 login-button"

                >

                    <i class="bi bi-box-arrow-in-right me-2"></i>

                    Inloggen


                </button>





                <div

                    v-if="error"

                    class="alert alert-danger mt-4 mb-0"

                >

                    {{ error }}

                </div>




            </form>



        </div>


    </div>


</div>

</template>






<script setup lang="ts">


import { ref } from 'vue'

import { useRouter } from 'vue-router'

import { useAuthStore } from '../stores/auth'



const auth = useAuthStore()

const router = useRouter()



const email = ref('')

const password = ref('')

const error = ref('')





async function login(){


    try {


        error.value = ''


        await auth.login(

            email.value,

            password.value

        )


        router.push('/dashboard')



    } catch {


        error.value =
            'Inloggen mislukt. Controleer je gegevens.'


    }


}


</script>






<style scoped>


.login-page {


    min-height:100vh;


    background:#eef2f7;


    display:flex;


    align-items:center;


    justify-content:center;


    padding:30px;


}




.login-card {

    width:500px;

    max-width:95%;

    background:white;

    border-radius:18px;

    overflow:hidden;

    box-shadow:
        0 8px 24px rgba(0,0,0,.12);

}




.login-brand {


    background:linear-gradient(
        135deg,
        #0d6efd,
        #2563eb
    );


    color:white;


    padding:35px 30px;


    display:flex;

    flex-direction:column;

    align-items:center;


}




.logo {


    width:70px;


    height:70px;


    margin-bottom:20px;


    background:white;


    color:#2563eb;


    border-radius:50%;


    display:flex;


    align-items:center;


    justify-content:center;


}




.logo i {


    font-size:36px;


}




.login-brand p {


    color:rgba(255,255,255,.8);


}




.login-body {

    padding:35px;

}


.login-body form {

    width:100%;

    max-width:380px;

    margin:0 auto;

}



.form-group {

    margin-bottom:25px;

}



.form-label {

    display:block;

    font-weight:600;

    margin-bottom:8px;

}



.form-control {

    width:100%;

    box-sizing:border-box;

    border-radius:12px;

    padding:13px 15px;

    border:1px solid #dbe3ef;

    font-size:15px;

}




.form-control:focus {


    border-color:#2563eb;


    box-shadow:
        0 0 0 .2rem rgba(37,99,235,.15);


}




.login-button {


    padding:13px;


    border-radius:12px;


    font-weight:600;


    font-size:16px;


}

</style>

