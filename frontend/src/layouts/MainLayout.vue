<template>

    <div class="layout">


        <!-- Topbar -->

        <header class="topbar">


            <!-- Logo links -->

            <div class="logo">

    <i class="bi bi-headset"></i>

</div>



            <!-- Titel midden -->

            <div class="header-title">

                <h4 class="mb-0 fw-bold">
                    Klantenhulpportaal
                </h4>

                <small>
                    Ticketbeheer & klantenondersteuning
                </small>

            </div>




            <!-- Acties rechts -->

            <div class="header-actions">


                <button class="btn btn-light notification-btn">

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






        <div class="body-layout">



            <!-- Sidebar -->

            <aside class="sidebar">


                <div class="logo">


                    <i class="bi bi-headset"></i>


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




/* HEADER */


.topbar{

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



.header-logo{

    display:flex;

    align-items:center;

}



.header-logo i{

    font-size:45px;

}



.header-title{

    text-align:center;

}



.header-title small{

    color:rgba(255,255,255,.75);

}




.header-actions{

    justify-self:end;

    display:flex;

    align-items:center;

    gap:20px;

}





.notification-btn{

    width:45px;

    height:45px;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

}





.user-card{

    display:flex;

    align-items:center;

    gap:15px;

}



.user-card small{

    color:rgba(255,255,255,.75);

}




.avatar{

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




.logout-btn{

    border-radius:12px;

    padding:10px 18px;

}





/* LAYOUT */


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


.logo {

    width:80px;

    height:80px;

    margin:0 auto 20px;


    background:linear-gradient(
        135deg,
        #ffffff,
        #dbeafe
    );


    color:#2563eb;


    border-radius:50%;


    display:flex;

    align-items:center;

    justify-content:center;


    box-shadow:
        0 0 0 0 rgba(255,255,255,.6);


    animation:
        logoPulse 3s infinite;


}



.logo i {

    font-size:42px;

    color:#2563eb;

    animation:
        logoColor 4s infinite alternate;

}






@keyframes logoPulse {


    0% {

        box-shadow:
            0 0 0 0 rgba(255,255,255,.6);

    }


    50% {

        box-shadow:
            0 0 0 15px rgba(255,255,255,0);

    }


    100% {

        box-shadow:
            0 0 0 0 rgba(255,255,255,0);

    }

}






@keyframes logoColor {


    0% {

        color:#2563eb;

        transform:scale(1);

    }


    50% {

        color:#0d6efd;

        transform:scale(1.08);

    }


    100% {

        color:#38bdf8;

        transform:scale(1);

    }

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

/* Algemene knopstijl */

.btn {
    border-radius: 12px;
    font-weight: 600;
    padding: 10px 22px;
    transition: all .25s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
}

/* Hover */

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0,0,0,.15);
}

/* Primary */

.btn-primary {
    background: linear-gradient(135deg,#0d6efd,#2563eb);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg,#2563eb,#1d4ed8);
}

/* Success */

.btn-success {
    background: linear-gradient(135deg,#22c55e,#16a34a);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(135deg,#16a34a,#15803d);
}

/* Danger */

.btn-danger {
    background: linear-gradient(135deg,#ef4444,#dc2626);
    border: none;
}

.btn-danger:hover {
    background: linear-gradient(135deg,#dc2626,#b91c1c);
}

/* Warning */

.btn-warning {
    background: linear-gradient(135deg,#f59e0b,#d97706);
    border: none;
    color: white;
}

.btn-warning:hover {
    background: linear-gradient(135deg,#d97706,#b45309);
    color: white;
}

/* Secondary */

.btn-secondary {
    background: #64748b;
    border: none;
}

.btn-secondary:hover {
    background: #475569;
}

/* Outline */

.btn-outline-secondary {
    border: 2px solid #cbd5e1;
    color: #475569;
    background: white;
}

.btn-outline-secondary:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #1e293b;
}



</style>