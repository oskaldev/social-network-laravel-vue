<script>
  import axios from 'axios'

  export default {
    components: {
    },
    data() {
      return {
        isAuthenticated: false
      }
    },
    created() {
      this.checkAuth()
    },
    methods: {
      checkAuth() {
        const token = this.getCookie('XSRF-TOKEN')
        this.isAuthenticated = !!token
      },
      getCookie(name) {
        const value = `; ${document.cookie}`
        const parts = value.split(`; ${name}=`)
        if (parts.length === 2) return parts.pop().split(';').shift()
      },
      logout() {
        axios.post('/logout')
          .then(res => {
            document.cookie = 'XSRF-TOKEN=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/'
            this.isAuthenticated = false
            this.$router.push({ name: 'user.login' })
          })
      }
    }
  }
</script>

<template>
  <div>
    <router-link v-if="!isAuthenticated" class="p-1" :to="{ name: 'user.login' }">Login</router-link>
    <router-link v-if="!isAuthenticated" class="p-1" :to="{ name: 'user.registration' }">Registration</router-link>
    <router-link v-if="isAuthenticated" class="p-1" :to="{ name: 'user.personal' }">Personal</router-link>
    <a v-if="isAuthenticated" @click.prevent="logout" href="#">Logout</a>
    <router-view></router-view>
  </div>
</template>

<style scoped></style>