<template>
  <div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>
                Lista de contatos
                <RouterLink to="/contatos/novo" class="btn btn-primary float-end">Adicionar contato</RouterLink>
            </h4>
        </div>
        <div class="card-body">
            <div class="row g-3 my-2">
                <div class="col-md-8">
                    <input class="form-control" v-model="searchQuery" placeholder="Buscar contato" aria-label="Search">
                </div>
                <div class="d-grid gap-2 col-md-2 mx-auto">
                    <button type="button" class="btn btn-outline-secondary btn-sm" @click="getContactsList">Filtrar</button>
                </div>
                <div class="d-grid gap-2 col-md-2 mx-auto">
                    <button type="button" class="btn btn-outline-secondary btn-sm" @click="clearFilter">Limpar filtros</button>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Contatos</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody v-if="this.persons.length > 0">
                    <tr v-for="(person, index) in this.persons" :key="index">
                        <td>{{ person.id }}</td>
                        <td>{{ person.name }}</td>
                        <td>
                            <span v-for="(contact, index) in person.contacts.slice(0,this.limitContacts)" :key="index">
                                {{contact.contact_type}}: {{contact.value}}
                            </span>
                            <RouterLink
                                v-if="person.contacts.length > this.limitContacts"
                                :to="{ path: '/contatos/' + person.id + '/ver' }"
                                style="font-size:12px"
                                class="link-success link-offset-2 link-underline-opacity-0">
                                <br />Mais {{person.contacts.length - this.limitContacts}} contato(s)
                            </RouterLink>
                        </td>
                        <td class="w-25 text-end">
                            <RouterLink :to="{ path: '/contatos/' + person.id + '/ver' }" class="btn btn-primary">Ver</RouterLink>
                            <RouterLink :to="{ path: '/contatos/' + person.id + '/editar' }" class="btn btn-success mx-2">Editar</RouterLink>
                            <button type="button" @click="deleteContact(person.id)" class="btn btn-danger">Excluir</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="4">Nenhum contato encontrado</td>
                    </tr>
                </tbody>
            </table>
            <pagination
                v-if="this.persons.length > 0"
                :offset="this.offset"
                :total="this.total"
                :limit="this.limit"
                @change-page="changePage"
            />
        </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Pagination from '../../components/Pagination.vue';

export default {
    name: 'contacts-list',
    components: {
        Pagination,
    },
    data() {
        return {
            persons: [],
            searchQuery: '',
            offset: 0,
            limit: 10,
            total: 0,
            limitContacts: 1,
        }
    },
    mounted(){
        this.getContactsList();
    },
    methods: {
        getContactsList() {
            axios.get(`/api/contacts-list?page=${this.offset}&limit=${this.limit}&query=${this.searchQuery}`)
                .then(response => {
                    this.persons = response.data.data;
                    this.total = response.data.total;
                });
        },
        deleteContact(personId) {
            if (confirm('Você tem certeza que gostaria de excluir esse registro?')) {
                axios.delete(`/api/contacts-list/${personId}`)
                    .then(response => {
                        alert('Registro removido com sucesso');
                        location.reload();
                    });
            }
        },
        changePage(value) {
            this.offset = value;
            this.getContactsList();
        },
        clearFilter() {
            this.searchQuery = '';
            this.getContactsList();
        }
    }
}
</script>
