<template>

    <nav class="navbar">

        <router-link to="/dashboard">
            Dashboard
        </router-link>


        <button @click="logout">
            Uitloggen
        </button>

    </nav>

</template>


<script setup lang="ts">

import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'


const auth = useAuthStore()

const router = useRouter()


async function logout() {

    try {

        await auth.logout()

        router.push('/login')

    } catch (error) {

        console.error('Uitloggen mislukt', error)

    }

}

</script>