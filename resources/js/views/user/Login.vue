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
        axios.post('/api/login', {
          email: this.email,
          password: this.password
        })
          .then(res => {
            console.log('Login successful', res.data)
            localStorage.setItem('token', res.data.token)
            window.dispatchEvent(new Event('auth-changed'))
            this.$router.push({ name: 'user.personal' })
          })
          .catch(err => {
            console.error('Ошибка входа:', err.response?.data ?? err)
          })

      }
    }
  }
</script>

<template>
  <div class="w-96 mx-auto">
    <div>
      <input v-model="email" type="email" placeholder="email" class="w-96 p-1 mb-2 border border-inherit rounded-lg">
    </div>
    <div>
      <input v-model="password" type="password" placeholder="password" class="w-96 p-1 mb-2 border border-inherit rounded-lg">
    </div>
    <div>
      <input @click.prevent="login" type="submit" value="login" class="block  cursor-pointer float-right mx-auto w-32 p-1 bg-sky-400 text-white rounded-lg">
    </div>
  </div>
</template>

<style scoped></style>
