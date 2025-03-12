import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import { createBootstrap } from 'bootstrap-vue-next';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import router from './router'
import { createI18n } from 'vue-i18n'
import pl from './locales/pl.json'

const i18n = createI18n({
  locale: "pl",
  fallbackLocale: "pl",
  messages: { pl },
});

createApp(App)
  .use(createBootstrap())
  .use(createPinia())
  .use(router)
  .use(i18n)
  .mount('#app')
