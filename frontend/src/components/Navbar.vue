<template>

    <nav>

        <div class="container">

            <!--<RouterLink
                class="navbar-brand fw-bold"
                to="/dashboard"
            >
                Klantenhulpportaal
            </RouterLink>-->


          <!--  <div class="d-flex align-items-center">

                <span class="text-white me-3">

                    {{ authStore.user?.name }}

                    <span
                        class="badge bg-light text-dark ms-2"
                    >
                        {{ authStore.user?.role }}
                    </span>

                </span>


                <RouterLink
                    class="btn btn-outline-light btn-sm me-2"
                    to="/dashboard"
                >
                    Dashboard
                </RouterLink>


                <RouterLink
                    class="btn btn-outline-light btn-sm me-2"
                    to="/tickets"
                >
                    Tickets
                </RouterLink> -->


                <RouterLink
                    v-if="authStore.user?.role === 'admin'"
                    class="btn btn-outline-light btn-sm me-2"
                    to="/admin/categories"
                >
                    Categorieën
                </RouterLink>


                <RouterLink
                    v-if="authStore.user?.role === 'admin'"
                    class="btn btn-outline-light btn-sm me-3"
                    to="/admin/users"
                >
                    Gebruikers
                </RouterLink>


               <!-- <button
                    class="btn btn-danger btn-sm"
                    @click="logout"
                >
                    Uitloggen
                </button> -->

            </div>

        

    </nav>

</template>

<script setup lang="ts">

import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()

const authStore = useAuthStore()

async function logout() {

    await authStore.logout()

    router.push('/login')

}

</script>