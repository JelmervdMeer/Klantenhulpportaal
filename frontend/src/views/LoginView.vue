<template>

    <div class="login">

        <h1>Inloggen</h1>

        <form @submit.prevent="login">

            <div>
                <label>Email</label>
                <input
                    v-model="email"
                    type="email"
                    required
                >
            </div>


            <div>
                <label>Wachtwoord</label>
                <input
                    v-model="password"
                    type="password"
                    required
                >
            </div>


            <button type="submit">
                Inloggen
            </button>


            <p v-if="error">
                {{ error }}
            </p>

        </form>

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


async function login() {

    try {

        await auth.login(
            email.value,
            password.value
        )


        router.push('/dashboard')


    } catch (e) {

        error.value = 'Inloggen mislukt. Controleer je gegevens.'

    }

}

</script>