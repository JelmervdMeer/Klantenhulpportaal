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

async function updateRole(user: User) {

    try {

        await api.put(`/users/${user.id}`, {
            role: user.role
        })

        message.value = 'Rol succesvol gewijzigd.'

    } catch {

        error.value = 'Rol kon niet worden gewijzigd.'

        await loadUsers()

    }

}

async function deleteUser(id: number) {

    if (!confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')) {
        return
    }

    try {

        await api.delete(`/users/${id}`)

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

<div class="container-fluid">


    <!-- Titel -->

    <div class="mb-4">

        <h1 class="fw-bold mb-1">
            Gebruikersbeheer
        </h1>

        <p class="text-muted mb-0">
            Beheer gebruikers en rollen binnen het klantenhulpportaal.
        </p>

    </div>



    <!-- Meldingen -->

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




    <!-- Bewerken -->

    <div
        v-if="editingUser"
        class="card shadow-sm border-0 mb-4"
    >

        <div class="card-body">

            <h4 class="fw-bold mb-4">

                <i class="bi bi-person-gear me-2"></i>

                Gebruiker bewerken

            </h4>



            <div class="row g-3">


                <div class="col-md-6">

                    <input
                        v-model="form.name"
                        class="form-control"
                        placeholder="Naam"
                    >

                </div>


                <div class="col-md-6">

                    <input
                        v-model="form.email"
                        class="form-control"
                        placeholder="E-mail"
                    >

                </div>



                <div class="col-md-6">

                    <select
                        v-model="form.role"
                        class="form-select"
                    >

                        <option value="user">
                            Gebruiker
                        </option>

                        <option value="admin">
                            Administrator
                        </option>

                    </select>

                </div>


            </div>



            <div class="mt-4">

                <button
                    class="btn btn-success me-2"
                    @click="saveUser"
                >

                    <i class="bi bi-check-circle me-2"></i>

                    Opslaan

                </button>


                <button
                    class="btn btn-secondary"
                    @click="editingUser=null"
                >

                    Annuleren

                </button>


            </div>


        </div>

    </div>






    <!-- Gebruikers -->

    <div class="row g-4">


        <div
            v-for="user in users"
            :key="user.id"
            class="col-xl-4 col-lg-6"
        >


            <div class="card shadow-sm border-0 h-100">


                <div class="card-body">


                    <div class="d-flex align-items-center gap-3">


                        <!-- Avatar -->

                        <div class="user-avatar">

                            <i class="bi bi-person-fill"></i>

                        </div>



                        <!-- Info -->

                        <div class="flex-grow-1">


                            <h4 class="fw-bold mb-1">
                                {{ user.name }}
                            </h4>


                            <p class="text-muted mb-2">

                                <i class="bi bi-envelope me-2"></i>

                                {{ user.email }}

                            </p>



                            <span
                                class="badge"
                                :class="
                                    user.role === 'admin'
                                    ? 'bg-danger'
                                    : 'bg-success'
                                "
                            >

                                <i class="bi bi-shield me-1"></i>

                                {{
                                    user.role === 'admin'
                                    ? 'Administrator'
                                    : 'Gebruiker'
                                }}

                            </span>


                        </div>


                    </div>





                    <select
                        v-model="user.role"
                        class="form-select mt-4"
                        @change="updateRole(user)"
                    >

                        <option value="user">
                            Gebruiker
                        </option>

                        <option value="admin">
                            Administrator
                        </option>

                    </select>






                    <div class="d-flex gap-2 mt-4">


                        <button
                            class="btn btn-primary flex-fill"
                            @click="editUser(user)"
                        >

                            <i class="bi bi-pencil me-2"></i>

                            Bewerken

                        </button>



                        <button
                            class="btn btn-danger flex-fill"
                            @click="deleteUser(user.id)"
                        >

                            <i class="bi bi-trash me-2"></i>

                            Verwijderen

                        </button>


                    </div>



                </div>


            </div>



        </div>


    </div>



</div>


</template>
<style scoped>

.user-avatar {

    width:80px;

    height:80px;

    border-radius:50%;

    background:linear-gradient(
        135deg,
        #0d6efd,
        #2563eb
    );

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:36px;

}


.card {

    border-radius:16px;

}


</style>