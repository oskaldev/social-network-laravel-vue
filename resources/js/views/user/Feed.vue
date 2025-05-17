<script>
  import Post from "../../components/Post.vue"
  export default {

    data() {
      return {
        posts: []
      }
    },

    components: {
      Post
    },
    mounted() {
      this.getPosts()
    },

    methods: {
      getPosts() {
        axios.get(`/api/users/following/posts`)
          .then(res => {
            this.posts = res.data.data
          })
      },


    }
  }
</script>

<template>
  <div class="w-96 mx-auto">
    <!-- <Stat :stats="stats"></Stat> -->

    <div v-if="posts">
      <!-- <h1 class="mb-8 pb-8 border-b border-gray-400">Posts</h1> -->
      <Post v-for="post in posts" :post="post"></Post>
    </div>

  </div>
</template>

<style scoped></style>
