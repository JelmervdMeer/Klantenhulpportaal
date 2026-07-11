<template>

    <div class="dashboard">

        <h1>
            Dashboard klantenhulpportaal
        </h1>


        <p v-if="auth.user">
            Welkom {{ auth.user.name }}
        </p>


        <div class="actions">

            <button @click="naarTickets">
                Mijn tickets
            </button>


            <button @click="logout">
                Uitloggen
            </button>

        </div>

    </div>

</template>


<script setup lang="ts">

import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'


const router = useRouter()

const auth = useAuthStore()


function naarTickets() {

    router.push('/tickets')

}


async function logout() {

    await auth.logout()

    router.push('/login')

}

</script>