import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import ContactsList from '../views/Contacts/List.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
    },
    {
      path: '/contatos',
      name: 'ContactsList',
      component: ContactsList,
    },
  ]
})

export default router
