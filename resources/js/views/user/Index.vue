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
      },
      toggleFollowing(user) {
        axios.get(`/api/users/${user.id}/toggle_following`)
          .then(res => {
            user.is_followed = res.data.is_followed
          })
      }
    }
  }
</script>

<template>
  <div class="w-96 mx-auto">
    <div>
      <h1 class="mt-8 pt-8 mb-5 pb-5 border-gray-500 text-center">Users Registred</h1>
      <div v-for="(user, index) in users" :key="index" class="flex justify-between items-center mb-2 p-2 rounded-2xl border border-gray-500">
        <router-link :to="{ name: 'user.show', params: { id: user.id } }">
          <p class="my-3">ID - {{ user.id }}</p>
          <p class="my-3">Name - {{ user.name }}</p>
          <p class="my-3">Email - {{ user.email }}</p>
        </router-link>
        <div>
          <a @click.prevent="toggleFollowing(user)" :class="[
            'block ml-auto p-2 w-32 rounded-3xl cursor-pointer focus:outline-none text-white text-center font-medium text-sm px-5 py-2.5 me-2 mb-2',
            user.is_followed
              ? 'bg-gray-700 hover:bg-gray-800 focus:ring-4  dark:bg-gray-600 dark:hover:bg-gray-700 '
              : 'bg-blue-700 hover:bg-blue-800 focus:ring-4  dark:bg-blue-600 dark:hover:bg-blue-700 '
          ]" href="#">{{ user.is_followed ? 'Unfollow' : 'Follow'}}</a>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
