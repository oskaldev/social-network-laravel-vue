
import { createRouter, createWebHistory } from "vue-router"
import App from "../App.vue"
import Home from "../views/HomePage.vue"


const routes = [
  {
    path: '/home',
    component: Home
  },
  {
    path: '/index',
    component: App
  },
]

const router = createRouter({
  routes,
  history: createWebHistory(import.meta.env.BASE_URL)
})

export default router