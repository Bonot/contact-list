<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Informações de contato</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody v-if="this.model.person">
                        <tr>
                            <td><b>Código</b></td>
                            <td>{{this.model.person.id}}</td>
                        </tr>
                        <tr>
                            <td><b>Nome completo</b></td>
                            <td>{{this.model.person.name}}</td>
                        </tr>
                        <tr>
                            <td><b>Contatos</b></td>
                            <td>
                                <span v-for="(contact, index) in this.model.person.contacts" :key="index">
                                    <b>{{contact.contact_type}}</b>: {{contact.value}} <br />
                                </span>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="4">Contato inexistente</td>
                        </tr>
                    </tbody>
                </table>
                <RouterLink to="/contatos" class="btn btn-primary mx-2">Voltar</RouterLink>
                <RouterLink :to="{ path: '/contatos/' + this.model.person.id + '/editar' }" class="btn btn-success mx-2">Editar</RouterLink>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import addContacts from '../../components/addContacts.vue';
import router from '../../router';

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
        }
    },
    mounted() {
        this.personId = this.$route.params.id;
        this.getContact(this.personId);
    },
    methods: {
        getContact(personId) {
            axios.get(`/api/contacts-list/${personId}`)
                .then(response => {
                    this.model.person = response.data;
                })
                .catch(function (error) {
                    if (error) {
                        alert('Houve um erro ao localizar esse contato')
                        router.push('/contatos');
                    }
                })
        }
    }
}
</script>
