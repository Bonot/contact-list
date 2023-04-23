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
                            <p v-for="(contact, index) in person.contacts" :key="index">
                                {{contact.contact_type}}: {{contact.value}}
                            </p>
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
            offset: 0,
            limit: 10,
            total: 0,
        }
    },
    mounted(){
        this.getContactsList();
    },
    methods: {
        getContactsList() {
            axios.get(`/api/contacts-list?page=${this.offset}&limit=${this.limit}`)
                .then(response => {
                    this.persons = response.data.data;
                    this.total = response.data.total;
                });
        },
        deleteContact(personId) {
            //  TO DO
        },
        changePage(value) {
            this.offset = value;
            this.getContactsList();
        },
    }
}
</script>
