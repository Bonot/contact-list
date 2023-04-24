<script setup>
import { computed, ref } from 'vue'
import { RouterLink, RouterView, useRouter } from 'vue-router'
import Cookie from 'js-cookie'
import { useSystemStore } from './store/system'

const store = useSystemStore();
const router = useRouter();
const authenticated = computed(() => store.getAuthenticated)
const logOut = () => {
  Cookie.remove('token');
  store.authenticated = false;
  router.push('/');
}

</script>

<template>
  <div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <RouterLink class="navbar-brand" to="/">Lista de contatos</RouterLink>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <RouterLink class="nav-link" aria-current="page" to="/">Home</RouterLink>
            </li>
            <li v-if="authenticated" class="nav-item">
              <RouterLink class="nav-link" aria-current="page" to="/contatos">Contatos</RouterLink>
            </li>
            <li v-if="!authenticated" class="nav-item">
              <RouterLink class="nav-link" aria-current="page" to="/login">Log in</RouterLink>
            </li>
            <li v-else class="nav-item">
              <RouterLink class="nav-link" @click="logOut" aria-current="page" to="/login">Log out</RouterLink>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
  <RouterView></RouterView>
</template>
