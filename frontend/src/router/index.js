import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import ContactsList from '../views/Contacts/List.vue'
import ContactsCreate from '../views/Contacts/Create.vue'
import ContactsEdit from '../views/Contacts/Edit.vue'
import ContactsView from '../views/Contacts/View.vue'
import Login from '../views/Login.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login,
    },
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
    {
      path: '/contatos/novo',
      name: 'ContactsCreate',
      component: ContactsCreate,
    },
    {
      path: '/contatos/:id/editar',
      name: 'ContactsEdit',
      component: ContactsEdit,
    },
    {
      path: '/contatos/:id/ver',
      name: 'ContactsView',
      component: ContactsView,
    },
  ]
})

export default router
