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

const message = ref('')

const editingUser = ref<User | null>(null)

const form = ref({

    name: '',

    email: '',

    role: 'user'

})

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

function editUser(user: User) {

    editingUser.value = user

    form.value = {

        name: user.name,

        email: user.email,

        role: user.role

    }

}

async function saveUser() {

    if (!editingUser.value) {
        return
    }


    try {

        await api.put(
            `/users/${editingUser.value.id}`,
            form.value
        )


        message.value =
            'Gebruiker succesvol bijgewerkt.'


        editingUser.value = null


        await loadUsers()


    } catch {

        error.value =
            'Gebruiker kon niet worden bijgewerkt.'

    }

}

async function deleteUser(id: number) {

    if (!confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')) {
        return
    }


    try {

        await api.delete(
            `/users/${id}`
        )


        message.value =
            'Gebruiker succesvol verwijderd.'


        await loadUsers()


    } catch {

        error.value =
            'Gebruiker kon niet worden verwijderd.'

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

        <div
    v-if="message"
    class="alert alert-success"
>
    {{ message }}
</div>

        <div
    v-if="editingUser"
    class="card mb-4"
>

    <div class="card-header">

        Gebruiker bewerken

    </div>

    <div class="card-body">

        <input
            v-model="form.name"
            class="form-control mb-3"
            placeholder="Naam"
        >

        <input
            v-model="form.email"
            class="form-control mb-3"
            placeholder="E-mail"
        >

        <select
            v-model="form.role"
            class="form-select mb-3"
        >

            <option value="user">
                Gebruiker
            </option>

            <option value="admin">
                Administrator
            </option>

        </select>

       <button
    class="btn btn-primary"
    @click="saveUser"
>
    Opslaan
</button>

        <button
            class="btn btn-secondary ms-2"
            @click="editingUser = null"
        >
            Annuleren
        </button>

    </div>

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
                    <th>Acties</th>>

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

                    
                    <td>

   

    

    <button
        class="btn btn-warning btn-sm me-2"
        @click="editUser(user)"
    >
        Bewerken
    </button>
                    


    <button
        class="btn btn-danger btn-sm"
        @click="deleteUser(user.id)"
    >
        Verwijderen
    </button>



</td>

                </tr>

            </tbody>

        </table>

    </div>

</template>