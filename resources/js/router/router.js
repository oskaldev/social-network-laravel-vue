
import { createRouter, createWebHistory } from "vue-router"
import Login from "../views/user/Login.vue"
import Registration from "../views/user/Registration.vue"
import Personal from "../views/user/Personal.vue"


const routes = [
  {
    path: '/user/login',
    name: 'user.login',
    component: Login,
    meta: { guestOnly: true }
  },
  {
    path: '/user/registration',
    name: 'user.registration',
    component: Registration,
    meta: { guestOnly: true }
  },
  {
    path: '/user/personal',
    name: 'user.personal',
    component: Personal,
    meta: { requiresAuth: true }
  },
]

function getCookie(name) {
  const value = `; ${document.cookie}`
  const parts = value.split(`; ${name}=`)
  if (parts.length === 2) return parts.pop().split(';').shift()
}

const router = createRouter({
  routes,
  history: createWebHistory(import.meta.env.BASE_URL),
})
router.beforeEach((to, from, next) => {
  const xsrfToken = getCookie('XSRF-TOKEN')

  if (to.meta.requiresAuth && !xsrfToken) {
    next({ name: 'user.login' })
  } else if (to.meta.guestOnly && xsrfToken) {
    next({ name: 'user.personal' })
  } else {
    next()
  }
})

export default router