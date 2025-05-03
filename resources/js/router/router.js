import { createRouter, createWebHistory } from "vue-router"
import Login from "../views/user/Login.vue"
import Registration from "../views/user/Registration.vue"
import Personal from "../views/user/Personal.vue"
import axios from "axios"

const routes = [
  {
    path: '/user/login',
    name: 'user.login',
    component: Login,
  },
  {
    path: '/user/registration',
    name: 'user.registration',
    component: Registration,
  },
  {
    path: '/user/personal',
    name: 'user.personal',
    component: Personal,
  },
]

const router = createRouter({
  routes,
  history: createWebHistory(import.meta.env.BASE_URL),
})

router.beforeEach(async (to, from, next) => {
  const protectedRoutes = [ 'user.personal' ]
  if (protectedRoutes.includes(to.name)) {
    const token = localStorage.getItem('token')
    if (token) {
      try {
        await axios.get('/api/user', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        next()
      } catch (error) {
        next({ name: 'user.login' })
      }
    } else {
      next({ name: 'user.login' })
    }
  } else {
    next()
  }
})

export default router
