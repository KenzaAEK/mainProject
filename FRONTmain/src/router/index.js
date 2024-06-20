import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'
import reset from '@/views/reset.vue'
import forgotpassword from '@/views/forgotpassword.vue'
import LandingPage from '@/views/LandingPage.vue'
import InterfaceParent from '@/views/Parent/InterfaceParent.vue'
import sideBar from '@/views/admin/sideBar.vue'
import interfaceAnim from '@/views/animateur/interfaceAnim.vue'


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
      path: '/reset/:token',
      name: 'reset',
      component: reset
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
      path: '/forgotpassword',
      name: 'forgotpassword',
      component: forgotpassword
    },
    {
      path: '/test',
      name: 'test',
      component: sideBar,
      children: [
        {
          path: '/offre', 
          component: () => import('../views/admin/offre.vue'),
          children:
          [
            {
              path: '/createOffre',
              name: 'createOffre',
              component: () => import('../views/admin/createOffre.vue')
            },
            {
              path: '/supprimerOffre',
              name: 'supprimerOffre',
              component: () => import('../views/admin/supprimerOffre.vue')
            },
            {
              path: '/listeEA',
              name: 'listeEA',
              component: () => import('../views/admin/listeEA.vue')
            },
            {
              path: '/modifierOffre',
              name: 'modifierOffre',
              component: () => import('../views/admin/modifierOffre.vue')
            },
          ]
        },
        {
          path: '/atelier',
          component: () => import('../views/admin/atelier.vue'),
          children:[
            {
              path: '/createAtelier',
              name: 'createAtelier',
              component: () => import('../views/admin/createAtelier.vue')
            },
            {
              path: '/supprimerAtelier',
              name: 'supprimerAtelier',
              component: () => import('../views/admin/supprimerAtelier.vue')
            },
            
          ]
        },
        {
          path: '/inscription',
          // name: 'inscription',
          component: () => import('../views/admin/inscription.vue'),
          children :[
            {
              path: '/status',
              name: 'status',
              component: () => import('../views/admin/status.vue')
            },
          ]
        },
        {
          path: '/packs',        
          component: () => import('../views/admin/packs.vue'),
          children:[
            {
              path: '/ajouterPacks',
              name: 'ajouterPacks',
              component: () => import('../views/admin/ajouterPacks.vue')
            },
            {
              path: '/modifierPack',
              name: 'modifierPack',
              component: () => import('../views/admin/modifierPack.vue')
            },
            {
              path: '/supprimerPack',
              name: 'supprimerPack',
              component: () => import('../views/admin/supprimerPack.vue')
            },
          ]
        },
        {
          path: '/test',
          // name: 'inscription',
          component: () => import('../views/admin/profileAdmin.vue'),
        },

        
      ]
    },
    {
      path: '/interfaceAnim',
      name: 'interfaceAnim',
      component: interfaceAnim,
      children:[
        {
          path: '/profilAnim',
          name: 'profilAnim',
          component: () => import('../views/animateur/profilAnim.vue')
        },
        {
          path: '/atelierAssocie',
          name: 'atelierAssocie',
          component: () => import('../views/animateur/atelierAssocie.vue')
        },
        
      ]
    }
    

  ]
})

export default router
