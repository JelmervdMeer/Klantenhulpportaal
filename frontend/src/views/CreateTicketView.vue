<template>
    

    <div class="container mt-4">

        <h1>Nieuw ticket maken</h1>


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


        <form @submit.prevent="createTicket">


            <div class="mb-3">

                <label class="form-label">
                    Titel
                </label>

                <input
                    v-model="form.title"
                    type="text"
                    class="form-control"
                >

            </div>



            <div class="mb-3">

                <label class="form-label">
                    Beschrijving
                </label>

                <textarea
                    v-model="form.description"
                    class="form-control"
                    rows="5"
                ></textarea>

            </div>



            <div class="mb-3">

                <label class="form-label">
                    Categorie
                </label>

                <select
                    v-model="form.category_id"
                    class="form-select"
                >

                    <option value="">
                        Kies categorie
                    </option>

                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>

                </select>

            </div>



            <div class="mb-3">

                <label class="form-label">
                    Prioriteit
                </label>


                <select
                    v-model="form.priority"
                    class="form-select"
                >

                    <option value="Laag">
                        Laag
                    </option>

                    <option value="Normaal">
                        Normaal
                    </option>

                    <option value="Hoog">
                        Hoog
                    </option>

                </select>

            </div>



            <button
                class="btn btn-primary"
                type="submit"
            >
                Ticket aanmaken
            </button>


        </form>

    </div>

</template>
<script setup lang="ts">

import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Navbar from '../components/Navbar.vue'

import api from '../api/axios'


const router = useRouter()


const form = ref({

    title: '',
    description: '',
    category_id: '',
    priority: 'Normaal'

})

interface Category {

    id: number

    name: string

}


const categories = ref<Category[]>([])


const message = ref('')

const error = ref('')



async function loadCategories() {

    try {

        const response = await api.get('/categories')

        categories.value = response.data.categories

    } catch {

        error.value = 'Categorieën konden niet worden geladen.'

    }

}



async function createTicket() {

    try {

        await api.post('/tickets', form.value)


        message.value = 'Ticket succesvol aangemaakt.'


        setTimeout(() => {

            router.push('/tickets')

        }, 1000)


    } catch {

        error.value = 'Ticket kon niet worden aangemaakt.'

    }

}



onMounted(loadCategories)

</script>