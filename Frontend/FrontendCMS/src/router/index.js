import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import StageManagerView from '../views/StageManagerView.vue'
import SponsorManagerView from '@/views/SponsorManagerView.vue'
import WebsiteCreateView from '@/views/WebsiteCreateView.vue'
import WebsiteView from '@/views/WebsiteView.vue'
import GalleryManagerView from '@/views/GalleryManagerView.vue'
import GalleryCreate from '@/components/GalleryCreate.vue'
import GalleryView from '@/views/GalleryView.vue'
import GalleryDetail from '@/components/GalleryDetail.vue'
import GalleryEditView from '@/views/GalleryEditView.vue'
import AboutUsManagerView from '@/views/AboutUsManagerView.vue'
import AboutUsCreate from '@/components/AboutUsCreate.vue'
import AboutUsEdit from '@/components/AboutUsEdit.vue'
import HomePageView from '@/views/HomePageView.vue'
import RegisteredUsers from '@/components/RegisteredUsers.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/admin-login',
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
      path: '/Blog',
      name: 'WebsiteView',
      component: WebsiteView
    },
    {
      path: '/galleries',
      name: 'GalleryManager',
      component: GalleryManagerView
    },
    {
      path: '/galleries/create',
      name: 'GalleryCreate',
      component: GalleryCreate
    },
    {
      path: '/galleries/:id',
      name: 'GalleryView',
      component: GalleryView,
      props: true
    },
    {
      path: '/galleries/:id',
      name: 'GalleryDetail',
      component: GalleryDetail,
    },
    {
      path: '/galleries/edit/:id',
      name: 'GalleryEdit',
      component: GalleryEditView,
      props: true
    },
    {
      path: '/about-us',
      name: 'AboutUsManager',
      component: AboutUsManagerView,
    },
    {
      path: '/about-us/create',
      name: 'AboutUsCreate',
      component: AboutUsCreate,
    },
    {
      path: '/about-us/edit/:id',
      name: 'AboutUsEdit',
      component: AboutUsEdit,
      props: true,
    },
    {
      path: '/',
      name: 'HomePageView',
      component: HomePageView,
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
    },
    {
      path: '/event-registration',
      name: 'EventRegistration',
      component: () => import('../views/EventRegistrationView.vue')
    },
    {
      path: '/registered-users',
      name: 'RegisteredUsers',
      component: RegisteredUsers
    },
  ]
})

export default router
