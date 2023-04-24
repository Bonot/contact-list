import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import ContactsList from '../views/Contacts/List.vue'
import ContactsCreate from '../views/Contacts/Create.vue'
import ContactsEdit from '../views/Contacts/Edit.vue'
import ContactsView from '../views/Contacts/View.vue'
import Login from '../views/Login.vue'
import authorization from '../middlewares/authorization'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login,
      beforeEnter: authorization
    },
    {
      path: '/',
      name: 'home',
      component: Home,
      beforeEnter: authorization,
    },
    {
      path: '/contatos',
      name: 'ContactsList',
      component: ContactsList,
      beforeEnter: authorization,
    },
    {
      path: '/contatos/novo',
      name: 'ContactsCreate',
      component: ContactsCreate,
      beforeEnter: authorization,
    },
    {
      path: '/contatos/:id/editar',
      name: 'ContactsEdit',
      component: ContactsEdit,
      beforeEnter: authorization,
    },
    {
      path: '/contatos/:id/ver',
      name: 'ContactsView',
      component: ContactsView,
      beforeEnter: authorization,
    },
  ]
})

export default router
