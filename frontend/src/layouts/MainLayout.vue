<template>

<div class="layout min-vh-100 bg-light d-flex flex-column">


    <!-- =========================
         HEADER
    ========================== -->

    <header class="topbar">


        <!-- Logo -->
        <div class="header-logo">

            <i class="bi bi-buildings-fill"></i>

        </div>



        <!-- Titel -->
        <div class="header-title">

            <h4 class="mb-0 fw-bold">
                Klantenhulpportaal
            </h4>

            <small>
                Ticketbeheer & klantenondersteuning
            </small>

        </div>




        <!-- Gebruiker + acties -->

        <div class="header-actions">


            <div class="user-card">


                <div class="avatar">

                    {{
                        authStore.user?.name
                        ?.charAt(0)
                        .toUpperCase()
                    }}

                </div>



                <div>

                    <div class="fw-bold">

                        {{ authStore.user?.name }}

                    </div>


                    <small>

                        {{ authStore.user?.role }}

                    </small>

                </div>


            </div>




            <button
                class="btn btn-danger logout-btn"
                @click="logout"
            >

                <i class="bi bi-box-arrow-right me-2"></i>

                Uitloggen

            </button>



        </div>


    </header>





    <!-- =========================
         NAVIGATIE
    ========================== -->


<nav class="navigation-bar shadow">

    <div class="container-fluid">

        <div class="d-flex flex-row w-100">

            <RouterLink
                class="nav-link"
                to="/dashboard"
            >
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </RouterLink>


            <RouterLink
                class="nav-link"
                to="/tickets"
            >
                <i class="bi bi-ticket-perforated me-2"></i>
                Tickets
            </RouterLink>


            <RouterLink
                v-if="authStore.user?.role === 'admin'"
                class="nav-link"
                to="/admin/categories"
            >
                <i class="bi bi-tags me-2"></i>
                Categorieën
            </RouterLink>


            <RouterLink
                v-if="authStore.user?.role === 'admin'"
                class="nav-link"
                to="/admin/users"
            >
                <i class="bi bi-people me-2"></i>
                Gebruikers
            </RouterLink>

        </div>

    </div>

</nav>





    <!-- =========================
         PAGINA INHOUD
    ========================== -->


    <main class="content flex-grow-1 p-4">


        <RouterView />


    </main>



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


/* =========================
   HEADER
========================= */

.topbar {

    display:grid;

    grid-template-columns:1fr auto 1fr;

    align-items:center;

    background:linear-gradient(
        135deg,
        #0d6efd,
        #2563eb
    );

    color:white;

    padding:20px 30px;

    box-shadow:
        0 4px 15px rgba(0,0,0,.15);

}



/* Logo */

.header-logo {

    display:flex;

    justify-content:center;

}



.header-logo i {

    font-size:48px;

    animation:
        logoColor 10s ease-in-out infinite;

}




@keyframes logoColor {


    0% {

        color:#ffffff;

    }


    20% {

        color:#dbeafe;

    }


    40% {

        color:#93c5fd;

    }


    60% {

        color:#bfdbfe;

    }


    80% {

        color:#ffffff;

    }


    100% {

        color:#dbeafe;

    }

}



/* Titel */

.header-title {

    text-align:center;

}



.header-title small {

    color:rgba(255,255,255,.75);

}




/* Gebruiker rechts */

.header-actions {

    justify-self:end;

    display:flex;

    align-items:center;

    gap:20px;

}



.user-card {

    display:flex;

    align-items:center;

    gap:15px;

}



.user-card small {

    color:rgba(255,255,255,.75);

}




/* Avatar */

.avatar {

    width:46px;

    height:46px;

    border-radius:50%;

    background:#1d4ed8;

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:bold;

    font-size:20px;

}




/* =========================
   NAVIGATIE
========================= */


.navigation-bar {

    background:#1e3a8a;

    padding:8px 0;

}


.navigation-bar > .container-fluid > div {

    display:flex;

    flex-direction:row;

    width:100%;

}



.navigation-bar .nav-link {

    flex:1;

    display:flex;

    justify-content:center;

    align-items:center;

    color:white;

    text-decoration:none;

    padding:12px 20px;

    font-weight:600;

    border-radius:8px;

    transition:.25s;

}


.navigation-bar .nav-link:hover {

    background:rgba(255,255,255,.15);

}


.navigation-bar .router-link-active {

    background:#2563eb;

    color:white;

}




/* =========================
   CONTENT
========================= */


.content {

    width:100%;

}





/* =========================
   BUTTONS
========================= */


.btn {

    font-weight:600;

    border-radius:12px;

    padding:10px 22px;

    transition:.25s;

    box-shadow:0 4px 12px rgba(0,0,0,.08);

}



.btn:hover {

    transform:translateY(-2px);

}





.btn-danger {

    background:

        linear-gradient(
            135deg,
            #ef4444,
            #dc2626
        );

    border:none;

}




.btn-primary {

    background:

        linear-gradient(
            135deg,
            #0d6efd,
            #2563eb
        );

    border:none;

}




.btn-success {

    background:

        linear-gradient(
            135deg,
            #22c55e,
            #16a34a
        );

    border:none;

}



</style>