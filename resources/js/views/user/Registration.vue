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
        axios.post('/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        })
          .then(res => {
            console.log(res.data.message)
            localStorage.setItem('token', res.data.token)
            window.dispatchEvent(new Event('auth-changed'))
            this.$router.push({ name: 'user.personal' })
          })
          .catch(err => {
            console.error('Ошибка регистрации:', err.response?.data ?? err)
            alert('Ошибка регистрации. Проверьте введенные данные.')
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