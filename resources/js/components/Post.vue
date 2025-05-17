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
        axios.post(`/api/posts/${post.id}/toggle_like`)
          .then(res => {
            post.is_liked = res.data.is_liked
            post.likes_count = res.data.likes_count
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
      <p class="mt-2 text-right text-slate-500 text-sm">{{ post.created_at }}</p>
    </div>
  </div>
</template>

<style scoped></style>
