import { defineStore } from 'pinia'

export const useSystemStore = defineStore('system', {
    state: () => ({
        authenticated: false
    }),
    getters: {
        getAuthenticated: (state) => state.authenticated
    },
    persist: true
})
