<script setup lang="ts">

import { ref, onMounted } from 'vue'
import api from '../api/axios'

import PageHeader from '../components/PageHeader.vue'
import ContentCard from '../components/ContentCard.vue'
import UserCard from '../components/UserCard.vue'


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


        error.value =
            'Gebruikers konden niet worden geladen.'



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


        await api.put(

            `/users/${user.id}`,

            {

                role: user.role

            }

        )



        message.value =
            'Rol succesvol gewijzigd.'



    } catch {


        error.value =
            'Rol kon niet worden gewijzigd.'



        await loadUsers()



    }


}









async function deleteUser(id:number) {



    if (
        !confirm(
            'Weet je zeker dat je deze gebruiker wilt verwijderen?'
        )
    ) {

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


<div class="container-fluid">



    <!-- Pagina header -->


    <PageHeader

        title="Gebruikersbeheer"

        subtitle="Beheer gebruikers en rollen binnen het klantenhulpportaal"

    />







    <!-- Meldingen -->



    <div

        v-if="loading"

        class="alert alert-info mt-4"

    >

        Gebruikers laden...

    </div>





    <div

        v-if="error"

        class="alert alert-danger mt-4"

    >

        {{ error }}

    </div>





    <div

        v-if="message"

        class="alert alert-success mt-4"

    >

        {{ message }}

    </div>









    <!-- Gebruiker bewerken -->



    <ContentCard

        v-if="editingUser"

        class="mt-4"

        title="Gebruiker bewerken"

        icon="bi-person-gear"

    >



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

                @click="editingUser = null"

            >


                Annuleren


            </button>



        </div>





    </ContentCard>









    <!-- Gebruikers kaarten -->



    <div class="row g-4 mt-1">



        <div

            v-for="user in users"

            :key="user.id"

            class="col-xl-4 col-lg-6"

        >



            <UserCard

                :user="user"

                @edit="editUser"

                @delete="deleteUser"

                @roleChange="updateRole"

            />



        </div>



    </div>





</div>



</template>