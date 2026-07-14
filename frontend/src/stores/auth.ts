import { defineStore } from 'pinia'
import api from '../api/axios'

const token = localStorage.getItem('token')

if (token) {
    api.defaults.headers.common.Authorization = `Bearer ${token}`
}

interface User {
    id: number
    name: string
    email: string
    role: string
}

export const useAuthStore = defineStore('auth', {

    state: () => ({
        user: null as User | null,
        token: localStorage.getItem('token') || null
    }),


    actions: {

        async login(email: string, password: string) {

    const response = await api.post('/login', {
        email,
        password
    })

    console.log('Response:', response.data)
    console.log('Token:', response.data.token)

    this.user = response.data.user
    this.token = response.data.token

    localStorage.setItem('token', response.data.token)

    console.log('LocalStorage token:', localStorage.getItem('token'))

    api.defaults.headers.common['Authorization'] =
        `Bearer ${response.data.token}`
},


        async logout() {

            console.log(localStorage.getItem('token'))

            await api.post('/logout')

            this.user = null
            this.token = null

            localStorage.removeItem('token')

            delete api.defaults.headers.common[
                'Authorization'
            ]
        }

    }

})