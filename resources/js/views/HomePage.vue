<script>
  import axios from 'axios'

  export default {
    components: {},
    data() {
      return {
        isAuthenticated: false
      }
    },
    created() {
      this.checkAuth()
      window.addEventListener('auth-changed', this.checkAuth)
    },
    beforeUnmount() {
      window.removeEventListener('auth-changed', this.checkAuth)
    },
    methods: {
      checkAuth() {
        const token = localStorage.getItem('token')
        if (token) {
          axios.get('/api/user', {
            headers: {
              Authorization: `Bearer ${token}`
            }
          })
            .then(() => {
              this.isAuthenticated = true
            })
            .catch(() => {
              this.isAuthenticated = false
            })
        } else {
          this.isAuthenticated = false
        }
      },
      logout() {
        axios.post('/api/logout', {}, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        })
          .then(() => {
            localStorage.removeItem('token')
            this.isAuthenticated = false
            window.dispatchEvent(new Event('auth-changed'))
            this.$router.push({ name: 'user.login' })
          })
          .catch((err) => {
            console.error('Ошибка выхода:', err)
          })
      }
    }
  }
</script>

<template>
  <div>
    <div class="flex flex-wrap justify-between p-8 w-96 mx-auto">
      <router-link v-if="!isAuthenticated" :to="{ name: 'user.login' }">Login</router-link>
      <router-link v-if="!isAuthenticated" :to="{ name: 'user.registration' }">Registration</router-link>
      <router-link v-if="isAuthenticated" :to="{ name: 'user.personal' }">Personal</router-link>
      <router-link v-if="isAuthenticated" :to="{ name: 'user.index' }">Users List</router-link>
      <a v-if="isAuthenticated" @click.prevent="logout" href="#">Logout</a>
      <router-view></router-view>
    </div>
  </div>

</template>

<style scoped></style>
