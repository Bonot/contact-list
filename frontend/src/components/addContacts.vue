<template>
  <div>
    <div class="row g-3 my-2">
        <div class="col-md-10">
            <h5>Contatos</h5>
        </div>
        <div class="d-grid gap-2 col-md-2 mx-auto ">
            <button class="btn btn-primary" @click="addContact()">Adicionar contato</button>
        </div>
    </div>
    <div v-for="(contact, index) in contacts" :key="index">
      <div class="row g-3 my-2 contact-list-tab" :id="'contact-list-' + index">
        <div class="col-md-5">
          <contact-type-select v-model="contact.contact_type_id"></contact-type-select>
        </div>
        <div class="col-md-5">
          <input type="text" class="form-control" placeholder="Contato" aria-label="Last name" v-model="contact.value">
        </div>
        <div class="d-grid gap-2 col-md-2 mx-auto">
          <button class="btn btn-danger float-end" @click="removeContact(index)">Remover</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ContactTypeSelect from './ContactTypeSelect.vue';

export default {
  props: ['dataContacts'],
  components: {
    ContactTypeSelect,
  },
  data() {
    return {
      contacts: this.dataContacts || [
        {
          contact_type_id: 0,
          value: ''
        }
      ]
    }
  },
  watch: {
    dataContacts: function(newVal) {
      this.contacts = newVal;
    }
  },
  methods: {
    addContact() {
      this.contacts.push({
        contact_type_id: 0,
        value: ''
      });
    },
    removeContact(index) {
      this.contacts.splice(index, 1);
    },
    updateValue() {
      this.$emit('input', this.contacts);
    }
  },
  mounted() {
    this.$nextTick(() => {
      this.updateValue();
    });
  },
  updated() {
    this.updateValue();
  }
}
</script>