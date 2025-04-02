<script>
  export default {
    components: {
    },
  }
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
    <router-link to="home">Home</router-link>
    <router-view></router-view>
  </div>
</template>

<style scoped></style>