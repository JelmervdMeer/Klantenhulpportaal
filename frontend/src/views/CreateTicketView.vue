<template>

<div class="container-fluid">

    <PageHeader
        title="Nieuw ticket maken"
        subtitle="Maak een nieuwe hulpvraag aan."
    />

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

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

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Titel
                            </label>

                            <input
                                v-model="form.title"
                                type="text"
                                class="form-control"
                                placeholder="Titel van je probleem"
                                required
                            >

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Beschrijving
                            </label>

                            <textarea
                                v-model="form.description"
                                class="form-control"
                                rows="6"
                                placeholder="Beschrijf je probleem zo duidelijk mogelijk..."
                                required
                            ></textarea>

                        </div>

                        <div class="row g-4">

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Categorie
                                </label>

                                <select
                                    v-model="form.category_id"
                                    class="form-select"
                                    required
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

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
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

                        </div>

                        <div class="d-flex justify-content-end mt-4">

                            <RouterLink
                                to="/tickets"
                                class="btn btn-outline-secondary me-2"
                            >
                                Annuleren
                            </RouterLink>

                            <button
                                class="btn btn-primary"
                                type="submit"
                            >
                                <i class="bi bi-send me-2"></i>
                                Ticket aanmaken
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</template>









<script setup lang="ts">


import { ref, onMounted } from 'vue'

import { useRouter } from 'vue-router'

import api from '../api/axios'

import PageHeader from '../components/PageHeader.vue'





const router = useRouter()





const form = ref({

    title: '',

    description: '',

    category_id: '',

    priority: 'Normaal'

})







interface Category {


    id:number

    name:string


}







const categories = ref<Category[]>([])



const message = ref('')

const error = ref('')








async function loadCategories(){


    try {


        const response = await api.get('/categories')


        categories.value =
            response.data.categories



    } catch {


        error.value =
            'Categorieën konden niet worden geladen.'


    }


}








async function createTicket(){


    try {


        await api.post(
            '/tickets',
            form.value
        )



        message.value =
            'Ticket succesvol aangemaakt.'





        setTimeout(() => {


            router.push('/tickets')


        },1000)





    } catch {


        error.value =
            'Ticket kon niet worden aangemaakt.'


    }


}








onMounted(loadCategories)





</script>








<style scoped>

.card {
    border-radius: 16px;
}

textarea {
    resize: none;
}

</style>