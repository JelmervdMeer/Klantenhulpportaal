<template>

    <div class="container mt-5">

        <div class="card">

            <div class="card-header">

                <h2>
                    Registreren
                </h2>

            </div>


            <div class="card-body">


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


                <input
                    v-model="form.name"
                    class="form-control mb-3"
                    placeholder="Naam"
                >


                <input
                    v-model="form.email"
                    class="form-control mb-3"
                    placeholder="Email"
                    type="email"
                >


                <input
                    v-model="form.password"
                    class="form-control mb-3"
                    placeholder="Wachtwoord"
                    type="password"
                >


                <button
                    class="btn btn-primary"
                    @click="register"
                    :disabled="loading"
                >

                    {{ loading ? 'Registreren...' : 'Registreren' }}

                </button>


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



async function register() {


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


    } catch (err: any) {

        error.value =
            err.response?.data?.message ??
            'Registreren mislukt.'

    } finally {

        loading.value = false

    }

}

</script>