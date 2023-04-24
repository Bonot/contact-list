<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Home page</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div v-if="authenticated" class="alert alert-success" role="alert">
                        Você está logado! Acesse sua lista de contatos <RouterLink class="link-success" to="/contatos">aqui</RouterLink>.
                    </div>
                    <div v-else class="alert alert-danger" role="alert">
                        Você não logado! Para acessar sua lista de contatos faça login <RouterLink class="link-danger" to="/login">aqui</RouterLink>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { useSystemStore } from '../store/system'

const store = useSystemStore();
const authenticated = computed(() => store.getAuthenticated);

</script>
