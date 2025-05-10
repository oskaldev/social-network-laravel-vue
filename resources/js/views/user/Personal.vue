<script>
  import axios from 'axios'

  export default {
    components: {
    },
    data() {
      return {
        title: '',
        content: '',
        image: null,
        posts: []
      }
    },
    mounted() {
      this.getPosts()
    },
    methods: {
      getPosts() {
        axios.get('/api/posts').then(res => {
          this.posts = res.data.data
        })
      },
      store() {
        const imageId = this.image?.id ?? null
        axios.post('/api/posts', { title: this.title, content: this.content, image_id: imageId })
          .then(res => {
            this.title = ''
            this.content = ''
            this.image = null
            this.posts.unshift(res.data.data)
            console.log(res)
          })
      },
      selectFile() {
        this.fileInput = this.$refs.file
        this.fileInput.click()
      },
      storeImage(e) {
        const file = e.target.files[ 0 ]
        const formData = new FormData()
        formData.append('image', file)

        axios.post('/api/post/images', formData)
          .then(res => {
            this.image = res.data.data
          })
      }
    },
  }
</script>

<template>
  <div class="w-96 mx-auto mt-8">
    <div class="mb-4">
      <div>
        <input v-model="title" class="w-96 mb-3 rounded-3xl border p-2 border-slate-300" type="text" placeholder="title">
      </div>
      <div>
        <textarea v-model="content" class="w-96 mb-3 rounded-3xl border p-2 border-slate-300" placeholder="content"></textarea>
      </div>
      <div class="flex mb-3 items-center">
        <div>
          <input @change="storeImage" ref="file" type="file" class="hidden">
          <a href="#" class="block p-2 w-16 text-center text-sm rounded-3xl bg-sky-500 text-white" @click.prevent="selectFile()">Image</a>
        </div>
        <div>
          <a v-if="image" @click.prevent="image = null" class="ml-3" href="#">Cancel</a>
        </div>
      </div>
      <div v-if="image">
        <img :src="image.url" alt="preview">
      </div>
      <div>
        <a @click.prevent="store" class="block ml-auto p-2 w-32 rounded-3xl cursor-pointer f
ocus:outline-none text-white text-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
          placeholder="content">Publish</a>
      </div>
    </div>

    <div v-if="posts">
      <h1 class="mb-8 pb-8 border-b border-gray-500">Posts</h1>
      <div v-for="(post, index) in posts" :key="index" class="mb-8 pb-8 rounded-2xl border-b  border-gray-500">
        <h1 class="text-xl">{{ post.title }}</h1>
        <img class="my-3 mx-auto" v-if="post.image_url" :src="post.image_url" :alt="post.title" />
        <p class="my-3">{{ post.content }}</p>
        <p class="mt-2 text-right text-slate-500 text-sm">{{ post.created_at }}</p>
      </div>
    </div>

  </div>
</template>

<style scoped></style>