<script>
  export default {

    props: [
      'post'
    ],

    data() {
      return {
        title: '',
        content: '',
        body: '',
        is_repost: false,
        repostedId: null,
        comments: [],
        isShowed: false,
        comment: null
      }
    },

    methods: {
      toggleLike(post) {
        if (!post || !post.id) {
          console.error('post или post.id отсутствует', post)
          return
        }

        axios.post(`/api/posts/${post.id}/toggle_like`)
          .then(res => {
            post.is_liked = res.data.is_liked
            post.likes_count = res.data.likes_count
          })
          .catch(err => {
            console.error('Ошибка при лайке поста:', err)
          })
      },

      setParentId(comment) {
        this.comment = comment
      },

      storeComment(post) {
        const commentId = this.comment ? this.comment.id : null
        axios.post(`/api/posts/${post.id}/comment`, { body: this.body, parent_id: commentId })
          .then(res => {
            this.body = ''
            this.comments.unshift(res.data.data)
            this.comment = null
            post.comments_count++
            this.isShowed = true
          })
      },

      getComments(post) {
        axios.get(`/api/posts/${post.id}/comment`)
          .then(res => {
            this.comments = res.data.data
            this.isShowed = true
          })
      },


      openRepost() {
        if (this.isPersonal()) return
        this.is_repost = !this.is_repost
      },

      repost(post) {
        if (this.isPersonal()) return
        axios.post(`/api/posts/${post.id}/repost`, { title: this.title, content: this.content })
          .then(res => {
            this.title = ''
            this.content = ''
          })
      },

      isPersonal() {
        return this.$route.name === 'user.personal'
      }
    }

  }
</script>

<template>
  <div class="mt-8 pt-8">
    <h1 class="mb-8 pb-8 border-b border-gray-500">Post</h1>
    <div class="mb-8 pb-8 rounded-2xl border-t border-b p-1 border-gray-500">
      <h1 class="text-xl">{{ post.title }}</h1>
      <img class="my-3 mx-auto" v-if="post.image_url" :src="post.image_url" :alt="post.title" />
      <p class="my-3">{{ post.content }}</p>
      <div class="flex justify-between mt-2 items-center">
        <svg @click.prevent="toggleLike(post)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          :class="['stroke-red-500 cursor-pointer hover:fill-red-500 w-6 h-6', post.is_liked ? 'fill-red-500' : 'fill-white']">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <p class="text-right text-slate-500 text-sm">{{ post.created_at }}</p>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
