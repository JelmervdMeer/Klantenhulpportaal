<script setup lang="ts">

import { ref, onMounted } from 'vue'
import api from '../api/axios'

interface User {

    id: number

    name: string

    email: string

    role: string

}

const users = ref<User[]>([])

const loading = ref(true)

const error = ref('')

async function loadUsers() {

    try {

        const response = await api.get('/users')

        users.value = response.data.users

    } catch {

        error.value = 'Gebruikers konden niet worden geladen.'

    } finally {

        loading.value = false

    }

}

onMounted(loadUsers)

</script>
<template>

    <div class="container mt-4">

        <h1>
            Gebruikersbeheer
        </h1>

        <div
            v-if="loading"
            class="alert alert-info"
        >
            Gebruikers laden...
        </div>

        <div
            v-if="error"
            class="alert alert-danger"
        >
            {{ error }}
        </div>

        <table
            v-if="users.length"
            class="table table-striped"
        >

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Naam</th>
                    <th>E-mail</th>
                    <th>Rol</th>

                </tr>

            </thead>

            <tbody>

                <tr
                    v-for="user in users"
                    :key="user.id"
                >

                    <td>{{ user.id }}</td>

                    <td>{{ user.name }}</td>

                    <td>{{ user.email }}</td>

                    <td>{{ user.role }}</td>

                </tr>

            </tbody>

        </table>

    </div>

</template>