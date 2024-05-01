import './assets/style.css';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import VueHighlightJS from 'vue-highlightjs'
import 'highlight.js/styles/default.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import mavonEditor from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'

import App from './App.vue'
import router from './router'

const app = createApp(App)
app.use(VueHighlightJS)
app.use(createPinia())
app.use(router)
app.use(mavonEditor)

app.mount('#app')
