import './bootstrap'
import { createApp } from 'vue'
import HomePage from './views/HomePage.vue'
import router from './router/router'

const app = createApp(HomePage)
app
  .use(router)
  .mount('#app')