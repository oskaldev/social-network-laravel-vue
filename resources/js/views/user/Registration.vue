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
          })
      }
    }
  }
</script>

<template>
  <div>
    <div class="w-96 mx-auto">
      <div>
        <input v-model="name" type="name" placeholder="name" class="w-96 p-1 mb-2 border border-inherit rounded-lg">
      </div>
      <div>
        <input v-model="email" type="email" placeholder="email" class="w-96 p-1 mb-2 border border-inherit rounded-lg">
      </div>
      <div>
        <input v-model="password" type="password" placeholder="password" class="w-96 p-1 mb-2 border border-inherit rounded-lg">
      </div>
      <div>
        <input v-model="password_confirmation" type="password" placeholder="password_confirmation" class="w-96 p-1 mb-2 border border-inherit rounded-lg">
      </div>
      <input @click.prevent="register" type="submit" value="register" class="block cursor-pointer float-right mx-auto w-32 p-1 bg-sky-400 text-white rounded-lg">
    </div>
  </div>
</template>
<style scoped></style>