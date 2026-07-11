import { defineStore } from 'pinia'
import api from '../api/axios'

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

            console.log(response.data)

            this.user = response.data.user
            this.token = response.data.token

            localStorage.setItem(
                'token',
                response.data.token
            )

            api.defaults.headers.common[
                'Authorization'
            ] = `Bearer ${response.data.token}`
        },


        async logout() {

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