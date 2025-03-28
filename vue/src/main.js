import { createApp } from 'vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import './style.css'
import 'uno.css'
import 'tailwindcss'
import App from './App.vue'
import router from './router'
import {createPinia} from 'pinia'

const app = createApp(App)
app.use(ElementPlus)
app.use(router)
app.use(createPinia())
app.mount('#app')
