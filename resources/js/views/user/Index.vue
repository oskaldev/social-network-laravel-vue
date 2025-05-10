<script>
  import axios from 'axios'

  export default {
    data() {
      return {
        users: []
      }
    },
    mounted() {
      this.getUsers()
    },
    methods: {
      getUsers() {
        axios.get('/api/users/')
          .then(res => {
            this.users = res.data.data
          })
      }
    }
  }
</script>

<template>
  <div class="w-96 mx-auto">
    <div>
      <h1 class="mt-8 pt-8 mb-5 pb-5 border-gray-500 text-center">Users Registred</h1>
      <div v-for="(user, index) in users" :key="index" class="mb-2 p-2 rounded-2xl border border-gray-500">
        <p class="my-3">ID - {{ user.id }}</p>
        <p class="my-3">Name - {{ user.name }}</p>
        <p class="my-3">Email - {{ user.email }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
