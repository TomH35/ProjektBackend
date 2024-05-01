import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/AdminRegistration',
      name: 'AdminRegistration',
      component: () => import('../views/AdminRegistrationView.vue')
    },
  ]
})

export default router
