import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '../views/LoginView.vue'
import DashboardView from '../views/DashboardView.vue'
import TicketsView from '../views/TicketsView.vue'
import TicketDetailView from '../views/TicketDetailView.vue'
import CreateTicketView from "../views/CreateTicketView.vue"



const router = createRouter({

    history: createWebHistory(),

    routes: [

        {
            path: '/',
            redirect: '/login'
        },


        {
            path: '/login',
            name: 'login',
            component: LoginView
        },


        {
            path: '/dashboard',
            name: 'dashboard',
            component: DashboardView
        },


        {
            path: '/tickets',
            name: 'tickets',
            component: TicketsView
        },


        {
            path: '/tickets/:id',
            name: 'ticket-detail',
            component: TicketDetailView
        },

        {
    path: '/tickets/create',
    name: 'ticket-create',
    component: CreateTicketView
},

{
    path: '/admin/categories',
    name: 'admin-categories',
    component: () =>
        import('../views/AdminCategoriesView.vue')
},

{
    path: '/admin/users',
    name: 'admin-users',
    component: () =>
        import('../views/AdminUserView.vue')
}

    ]

})


export default router