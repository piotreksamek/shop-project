// import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import 'bootstrap/dist/css/bootstrap.css'
import BootstrapVue3 from 'bootstrap-vue-3'
import router from './router'
import { createI18n } from 'vue-i18n'
import pl from './locales/pl.json'

const i18n = createI18n({
  locale: "pl",
  fallbackLocale: "pl",
  messages: { pl },
});

createApp(App)
  .use(createPinia())
  .use(router)
  .use(i18n)
  .use(BootstrapVue3)
  .mount('#app')
