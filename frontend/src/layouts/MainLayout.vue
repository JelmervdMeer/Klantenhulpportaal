<template>

    <div class="layout">


        <!-- Topbar -->

        <header class="topbar">

            <div>

                <h4 class="mb-0 fw-bold">
                    Klantenhulpportaal
                </h4>

                <small class="text-muted">
                    Ticketbeheer & klantenondersteuning
                </small>

            </div>



            <div class="d-flex align-items-center">


                <button class="btn btn-light me-3">

                    <i class="bi bi-bell"></i>

                </button>



                <div class="user-card">


                    <div class="avatar">

                        {{ authStore.user?.name?.charAt(0).toUpperCase() }}

                    </div>



                    <div>

                        <div class="fw-bold">

                            {{ authStore.user?.name }}

                        </div>


                        <small class="text-muted">

                            {{ authStore.user?.role }}

                        </small>


                    </div>


                </div>



                <button
                    class="btn btn-danger ms-4"
                    @click="logout"
                >

                    <i class="bi bi-box-arrow-right me-2"></i>

                    Uitloggen

                </button>


            </div>


        </header>





        <div class="body-layout">


            <!-- Sidebar -->

            <aside class="sidebar">


                <div class="logo">


                    <i class="bi bi-life-preserver"></i>


                    <span>
                        Helpdesk
                    </span>


                </div>



                <nav>


                    <RouterLink
                        class="menu-item"
                        to="/dashboard"
                    >

                        <i class="bi bi-speedometer2"></i>

                        Dashboard

                    </RouterLink>




                    <RouterLink
                        class="menu-item"
                        to="/tickets"
                    >

                        <i class="bi bi-ticket-perforated"></i>

                        Tickets

                    </RouterLink>




                    <RouterLink
                        v-if="authStore.user?.role === 'admin'"
                        class="menu-item"
                        to="/admin/categories"
                    >

                        <i class="bi bi-tags"></i>

                        Categorieën

                    </RouterLink>




                    <RouterLink
                        v-if="authStore.user?.role === 'admin'"
                        class="menu-item"
                        to="/admin/users"
                    >

                        <i class="bi bi-people"></i>

                        Gebruikers

                    </RouterLink>



                </nav>


            </aside>





            <!-- Pagina inhoud -->

            <main class="content">


                <RouterView />


            </main>


        </div>


    </div>


</template>



<script setup lang="ts">

import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'


const router = useRouter()

const authStore = useAuthStore()



async function logout(){

    await authStore.logout()

    router.push('/login')

}

</script>



<style scoped>


.layout{

    min-height:100vh;

    display:flex;

    flex-direction:column;

    background:#eef2f7;

}



.topbar{

    height:90px;

    background:white;

    padding:20px 35px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    box-shadow:0 3px 12px rgba(0,0,0,.08);

}



.body-layout{

    display:flex;

    flex:1;

}



.sidebar{

    width:260px;

    background:#1e293b;

    color:white;

    padding:25px;

}



.logo{

    font-size:24px;

    font-weight:700;

    display:flex;

    align-items:center;

    gap:12px;

    margin-bottom:30px;

}



.menu-item{

    display:flex;

    align-items:center;

    gap:12px;

    color:#cbd5e1;

    text-decoration:none;

    padding:12px 16px;

    border-radius:12px;

    margin-bottom:8px;

    transition:.25s;

}



.menu-item:hover{

    background:#334155;

    color:white;

}



.router-link-active{

    background:#2563eb;

    color:white;

}



.menu-item i{

    font-size:20px;

}



.content{

    flex:1;

    padding:30px;

}



.user-card{

    display:flex;

    align-items:center;

    gap:15px;

}



.avatar{

    width:46px;

    height:46px;

    border-radius:50%;

    background:#2563eb;

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:bold;

    font-size:20px;

}


</style>