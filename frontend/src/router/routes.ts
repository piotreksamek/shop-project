export default [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/HomeView.vue')
  },
  {
    path: '/product/create',
    name: 'CreateProduct',
    component: () => import('../views/product/CreateProduct.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/security/Register.vue'),
    meta: { requiresGuest: true },
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/security/Login.vue'),
    meta: { requiresGuest: true },
  },
  {
    path: '/email/verify/:token',
    name: 'VerifyEmail',
    component: () => import('../views/security/VerifiedEmail.vue'),
  },
  {
    path: '/user/profile/setup',
    name: 'SetupProfile',
    component: () => import('../views/user/SetupProfile.vue'),
    meta: { requiresAuth: true },
  },
]
