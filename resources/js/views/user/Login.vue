<script>
  import axios from 'axios'

  export default {
    data() {
      return {
        email: null,
        password: null,
      }
    },
    methods: {
      login() {
        axios.get('/sanctum/csrf-cookie').then(response => {
          axios.post('/api/login', {
            email: this.email,
            password: this.password
          })
            .then(res => {
              console.log('Login successful', res.data)
              localStorage.setItem('token', res.data.token)
              this.isAuthenticated = true
              this.$router.push({ name: 'user.personal' })
            })
            .catch(err => {
              console.error('Ошибка входа:', err.response?.data ?? err)
            })
        })
      }
    }
  }
</script>

<template>
  <div style="display: table-caption;">
    Login
    <input v-model="email" type="email" class="from-control m-1" placeholder="email" name="" id="">
    <input v-model="password" type="password" class="from-control m-1" placeholder="password" name="" id="">
    <input @click.prevent="login" type="submit" value="login" class="btn btn-primary m-1">
  </div>
</template>

<style scoped></style>
