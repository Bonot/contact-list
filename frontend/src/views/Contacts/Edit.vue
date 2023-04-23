<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Editar contato</h4>
            </div>
            <div class="card-body">
                <ul class="alert alert-warning" v-if="Object.keys(this.errorList).length > 0">
                    <li class="mb-0 ms-3" v-for="(error, index) in this.errorList" :key="index">
                        {{ error[0] }}
                    </li>
                </ul>
                <div class="mb-3">
                    <label>Nome Completo</label>
                    <input type="text" v-model="this.model.person.name" class="form-control">
                </div>
                <div class="mb-3">
                    <add-contacts :dataContacts="this.model.person.contacts"></add-contacts>
                </div>
            <div class="mb-3">
                <RouterLink to="/contatos" class="btn btn-primary mx-2">Voltar</RouterLink>
                <button type="button" @click="updateContact" class="btn btn-success">Salvar</button>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import addContacts from '../../components/addContacts.vue';
import router from '../../router';
import Cookie from 'js-cookie'

export default {
    name: 'contactCreate',
    components: {
        addContacts,
    },
    data(){
        return {
            errorList: '',
            model: {
                person: {
                    name: '',
                    contacts: [],
                }
            },
            token: '',
            config: {}
        }
    },
    mounted() {
        this.token = Cookie.get('token')
        this.config = {
            headers: {
                Authorization: `Bearer ${this.token}`
            }
        }
        this.personId = this.$route.params.id;
        this.getContact(this.personId);
    },
    methods: {
        getContact(personId) {
            axios.get(`/api/contacts-list/${personId}`, this.config)
                .then(response => {
                    this.model.person = response.data;
                })
                .catch(function (error) {
                        alert('Houve um erro ao localizar esse contato')
                        router.push('/contatos');
                })
        },
        updateContact() {
            axios.put(`/api/contacts-list/${this.personId}`, this.model.person, this.config)
                .then(response => {
                    if (response.data.success === false) {
                        this.errorList = response.data.errors;
                    }

                    if (response.status === 201) {
                        alert('Contato salvo com sucesso');
                        router.push('/contatos');
                    }
                })
        }
    }
}
</script>
