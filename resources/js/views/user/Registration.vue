<script>
  import axios from 'axios'

  export default {
    data() {
      return {
        email: null,
        name: null,
        password: null,
        password_confirmation: null,
      }
    },
    components: {
    },
    methods: {
      register() {
        axios.get('/sanctum/csrf-cookie').then(response => {
          axios.post('/register', { email: this.email, password: this.password, name: this.name, password_confirmation: this.password_confirmation })
            .then(res => {
              console.log(res)
            })
        })
      }
    }
  }
</script>

<template>
  <div style="display: table-caption">
    Registration
    <input v-model="email" type="email" class="from-control m-1" placeholder="email">
    <input v-model="name" type="name" class="from-control m-1" placeholder="name">
    <input v-model="password" type="password" class="from-control m-1" placeholder="password">
    <input v-model="password_confirmation" type="password" class="from-control m-1" placeholder="password_confirmation">
    <input @click.prevent="register" type="button" value="register" class="btn btn-primary m-1">
  </div>
</template>
<style scoped></style>