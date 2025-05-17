import { createRouter, createWebHistory } from "vue-router"
import Login from "../views/user/Login.vue"
import Registration from "../views/user/Registration.vue"
import Personal from "../views/user/Personal.vue"
import axios from "axios"
import Index from "../views/user/Index.vue"
import Show from "../views/user/Show.vue"

const routes = [
  {
    path: '/users/list',
    name: 'user.index',
    component: Index,
  },
  {
    path: '/users/:id',
    name: 'user.show',
    component: Show,
  },
  {
    path: '/users/login',
    name: 'user.login',
    component: Login,
  },
  {
    path: '/users/registration',
    name: 'user.registration',
    component: Registration,
  },
  {
    path: '/users/personal',
    name: 'user.personal',
    component: Personal,
  },
]

const router = createRouter({
  routes,
  history: createWebHistory(import.meta.env.BASE_URL),
})

router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('token')

  const isAuthRoute = [ 'user.login', 'user.registration' ].includes(to.name)
  const isProtectedRoute = [ 'user.personal', 'user.index', 'user.show' ].includes(to.name)

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
