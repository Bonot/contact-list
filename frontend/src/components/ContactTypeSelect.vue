<template>
    <select class="form-select"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <option value="0" selected>Selecione o tipo de contato</option>
        <option v-for="(type, index) in this.types" :key="index"
            :value="type.id">{{type.type}}</option>
    </select>
</template>

<script>
import axios from 'axios'
import Cookie from 'js-cookie'

export default {
    name: 'ContactTypeSelect',
    props: ['modelValue'],
    emits: ['update:modelValue'],
    data(){
        return {
            types: [],
            token : '',
            config : {}
        }
    },
    mounted(){
        this.token = Cookie.get('token')
        this.config = {
            headers: {
                Authorization: `Bearer ${this.token}`
            }
        }
        this.getTypes();
    },
    methods: {
        getTypes() {
            axios.get('/api/contacts-list/contact-types', this.config)
                .then(response => {
                    this.types = response.data;
                });
        }
    }
}
</script>
