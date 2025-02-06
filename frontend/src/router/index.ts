import {createRouter, createWebHistory} from "vue-router";

import routes from './routes';
import { isAuthenticated } from "@/stores/authStore.ts";

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated()) {
    next({ name: 'Login' });

    return;
  }

  if (to.matched.some(record => record.meta.requiresGuest) && isAuthenticated()) {
    next({name: 'Home'});

    return;
  }

  next();
});

export default router;
