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
import { useLoginStore } from '../stores/loginStore'

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
      component: StageManagerView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/sponsor-manager',
      name: 'SponsorManager',
      component: SponsorManagerView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/editor',
      name: 'WebsiteCreateView',
      component: WebsiteCreateView,
      meta: {
        requiresAuth: true
      }
    },

    {
     path: '/tab/:id',
     name: 'WebsiteView',
     component: WebsiteView,
     props: true, 
    },

    {
      path: '/galleries',
      name: 'GalleryManager',
      component: GalleryManagerView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/galleries/create',
      name: 'GalleryCreate',
      component: GalleryCreate,
      meta: {
        requiresAuth: true
      }
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
      component: GalleryDetail
    },
    {
      path: '/galleries/edit/:id',
      name: 'GalleryEdit',
      component: GalleryEditView,
      props: true,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/about-us',
      name: 'AboutUsManager',
      component: AboutUsManagerView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/about-us/create',
      name: 'AboutUsCreate',
      component: AboutUsCreate,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/about-us/edit/:id',
      name: 'AboutUsEdit',
      component: AboutUsEdit,
      props: true,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/',
      name: 'HomePageView',
      component: HomePageView,
    },
    {
      path: '/main-menu',
      name: 'MainMenu',
      component: () => import('../views/MainMenuView.vue'),
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/admin-registration',
      name: 'AdminRegistration',
      component: () => import('../views/AdminRegistrationView.vue')
    },
    {
      path: '/speaker-manager',
      name: 'SpeakerManager',
      component: () => import('../views/SpeakerManagerView.vue'),
      meta: {
        requiresAuth: true
      }
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

  ],
  scrollBehavior (to, from, savedPosition) {
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        resolve({ left: 0, top: 0 })
      }, 10)
    })
  }
})

router.beforeEach((to, from, next) => {
  const store = useLoginStore();
  if (to.matched.some(record => record.meta.requiresAuth) && !store.userAuthorised) {
    next({ name: 'home' });
  } else {
    next();
  }
});


export default router
