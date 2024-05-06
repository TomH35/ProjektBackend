import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import StageManagerView from '../views/StageManagerView.vue'
import SponsorManagerView from '@/views/SponsorManagerView.vue'
import WebsiteCreateView from '@/views/WebsiteCreateView.vue'
import WebsiteView from '@/views/WebsiteView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/stage-manager',
      name: 'StageManager',
      component: StageManagerView
    },
    {
      path: '/sponsor-manager',
      name: 'SponsorManager',
      component: SponsorManagerView
    },
    {
      path: '/editor',
      name: 'WebsiteCreateView',
      component: WebsiteCreateView
    },
    {
      path: '/CustomWebsiteBrowser',
      name: 'WebsiteView',
      component: WebsiteView
    },
    {
      path: '/main-menu',
      name: 'MainMenu',
      component: () => import('../views/MainMenuView.vue')
    },
    {
      path: '/admin-registration',
      name: 'AdminRegistration',
      component: () => import('../views/AdminRegistrationView.vue')
    },
    {
      path: '/speaker-manager',
      name: 'SpeakerManager',
      component: () => import('../views/SpeakerManagerView.vue')
    }
  ]
})

export default router
