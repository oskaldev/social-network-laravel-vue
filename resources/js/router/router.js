import { createRouter, createWebHistory } from "vue-router"
import Login from "../views/user/Login.vue"
import Registration from "../views/user/Registration.vue"
import Personal from "../views/user/Personal.vue"
import axios from "axios"
import Index from "../views/user/Index.vue"
import Show from "../views/user/Show.vue"
import Feed from "../views/user/Feed.vue"

const routes = [
  {
    path: '/users/list',
    name: 'user.index',
    component: Index,
    meta: { requiresAuth: true },
  },
  {
    path: '/users/:id',
    name: 'user.show',
    component: Show,
    meta: { requiresAuth: true },
  },
  { 
    path: '/users/feed',
    name: 'user.feed',
    component: Feed,
    meta: { requiresAuth: true },
  },
  {
    path: '/users/login',
    name: 'user.login',
    component: Login,
    meta: { guestOnly: true },
  },
  {
    path: '/users/registration',
    name: 'user.registration',
    component: Registration,
    meta: { guestOnly: true },
  },
  {
    path: '/users/personal',
    name: 'user.personal',
    component: Personal,
    meta: { requiresAuth: true },
  },
]

const router = createRouter({
  routes,
  history: createWebHistory(import.meta.env.BASE_URL),
})

router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('token')

  const isAuthRoute = to.meta.guestOnly
  const isProtectedRoute = to.meta.requiresAuth

  if (token) {
    try {
      await axios.get('/api/user', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })

      // Пользователь залогинен
      if (isAuthRoute) {
        return next({ name: 'user.personal' }) // запрет на login/registration
      }
      return next()
    } catch (error) {
      // Токен невалиден
      localStorage.removeItem('token')
      if (isProtectedRoute) return next({ name: 'user.login' })
      return next()
    }
  } else {
    // Нет токена
    if (isProtectedRoute) return next({ name: 'user.login' })
    return next()
  }
})


export default router
