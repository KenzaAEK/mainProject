import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'
import LoginAdmin from '@/views/LoginAdmin.vue'
import LandingPage from '@/views/LandingPage.vue'
import InterfaceParent from '@/views/Parent/InterfaceParent.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [ 
    {
      path: '/',
      name: 'LandingPage',
      component: LandingPage
    },
    {
      path: '/parent',
      name: 'InterfaceParent',
      component: InterfaceParent
    },
    {
      path: '/signup',
      name: 'signup',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Signup.vue')
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/loginadmin',
      name: 'LoginAdmin',
      component: LoginAdmin
    }
  ]
})

export default router
