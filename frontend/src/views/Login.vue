<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Faça login para acessar sua lista de contatos</h4>
            </div>
            <div class="card-body px-5" >
                <ul class="alert alert-warning" v-if="Object.keys(errorList).length > 0">
                    <li class="mb-0 ms-3" v-for="(error, index) in errorList" :key="index">
                        {{ error[0] }}
                    </li>
                </ul>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="text" v-model="login.email" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Senha</label>
                    <input type="password" v-model="login.password" class="form-control">
                </div>
                <div class="mb-3">
                    <button type="button" @click="authLogin" class="btn btn-primary">Entrar</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import axios from 'axios'
import Cookie from 'js-cookie'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter();
const errorList = ref('');
const login = ref({
     email: '',
     password: ''
 });

 const authLogin = () => {
    axios.get('http://localhost:90/sanctum/csrf-cookie').then(response => {
        axios.post(
            '/api/login',
            login.value,
        )
        .then(response => {
            if (response.data.success === false) {
                errorList.value = response.data.errors;
            } else {
                Cookie.set('token', response.data);
                router.push('/');
            }
        })
        .catch(function (error) {
            if (error.response.data === 'Unauthorized') {
                errorList.value = {
                    invalidAuthentication : [
                        'Email e/ou senha iválidos.'
                    ]
                };
                login.value.email = ''
                login.value.password = ''
            }
        })
    });
 }
</script>