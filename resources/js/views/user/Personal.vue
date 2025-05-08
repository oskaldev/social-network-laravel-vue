<script>
  import axios from 'axios'

  export default {
    components: {
    },
    data() {
      return {
        title: '',
        content: '',
        image: null
      }
    },
    methods: {
      store() {
        const imageId = this.image?.id ?? null
        axios.post('/api/posts', { title: this.title, content: this.content, image_id: imageId })
          .then(res => {
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
    <div>
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
  </div>
</template>

<style scoped></style>