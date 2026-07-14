<script setup lang="ts">

import { ref, onMounted } from 'vue'
import api from '../api/axios'
import Navbar from '../components/Navbar.vue'

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


    <!-- Pagina header -->

    <div class="page-header mb-4">


        <div>

            <h1 class="fw-bold mb-1">
                Gebruikersbeheer
            </h1>


            <p class="mb-0">
                Beheer gebruikers en rollen
            </p>


        </div>


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







    <!-- Bewerken formulier -->


    <div
        v-if="editingUser"
        class="card form-card mb-4"
    >


        <div class="card-body">


            <h4 class="fw-bold mb-3">

                Gebruiker bewerken

            </h4>




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
                class="btn btn-success me-2"
                @click="saveUser"
            >

                <i class="bi bi-check-circle me-2"></i>

                Opslaan

            </button>




            <button
                class="btn btn-secondary"
                @click="editingUser = null"
            >

                Annuleren

            </button>


        </div>


    </div>







    <!-- Gebruikers kaarten -->


    <div class="row user-grid">


        <div
            v-for="user in users"
            :key="user.id"
            class="col-xl-4 col-lg-6 user-column"
        >


            <div class="user-card">


                <div class="user-icon">

                    <i class="bi bi-person"></i>

                </div>




                <h4 class="fw-bold">

                    {{ user.name }}

                </h4>




                <p class="text-muted mb-2">

                    <i class="bi bi-envelope me-2"></i>

                    {{ user.email }}

                </p>





                <div class="mb-3">


                    <span
                        class="role-badge"
                        :class="user.role === 'admin'
                            ? 'admin'
                            : 'user'"
                    >

                        <i class="bi bi-shield me-1"></i>

                        {{ user.role === 'admin'
                            ? 'Administrator'
                            : 'Gebruiker'
                        }}

                    </span>


                </div>






                <div class="user-actions">


                    <button
                        class="btn btn-warning btn-sm"
                        @click="editUser(user)"
                    >

                        <i class="bi bi-pencil me-1"></i>

                        Bewerken

                    </button>





                    <button
                        class="btn btn-danger btn-sm"
                        @click="deleteUser(user.id)"
                    >

                        <i class="bi bi-trash me-1"></i>

                        Verwijderen

                    </button>


                </div>





                <select
                    v-model="user.role"
                    class="form-select mt-3"
                    @change="updateRole(user)"
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


    </div>



</div>

</template>
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





.card {

    border:none;

    border-radius:18px;

    box-shadow:
        0 8px 24px rgba(0,0,0,.08);

}



.form-card {

    background:white;

}





.user-grid {

    margin-top:10px;

}



.user-column {

    padding:12px;

}




.user-card {


    background:white;

    padding:25px;

    border-radius:18px;

    height:100%;


    box-shadow:
        0 8px 24px rgba(0,0,0,.08);


    transition:.25s;

}



.user-card:hover {


    transform:translateY(-5px);


    box-shadow:
        0 14px 30px rgba(0,0,0,.15);


}




.user-icon {


    width:50px;

    height:50px;

    border-radius:14px;


    background:#dbeafe;

    color:#2563eb;


    display:flex;

    justify-content:center;

    align-items:center;


    font-size:24px;

    margin-bottom:18px;


}





.role-badge {


    padding:8px 14px;

    border-radius:12px;

    font-size:14px;

    font-weight:600;


}



.role-badge.admin {


    background:#fee2e2;

    color:#dc2626;


}



.role-badge.user {


    background:#dcfce7;

    color:#16a34a;


}





.user-actions {


    display:flex;

    gap:10px;

    margin-top:20px;


}

</style>