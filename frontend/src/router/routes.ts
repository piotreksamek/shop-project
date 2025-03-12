export default [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/HomeView.vue')
  },
  {
    path: '/product/list',
    name: 'ProductList',
    component: () => import('../views/product/list/ProductList.vue'),
  },
  {
    path: '/product/:id',
    name: 'DetailProduct',
    component: () => import('../views/product/DetailProduct.vue'),
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/security/Register.vue'),
    meta: { requiresGuest: true },
  },
  {
    path: '/register/address',
    name: 'SetupProfileAddress',
    component: () => import('../views/security/SetupProfile.vue'),
    meta: { requiresAuth: true },
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
    path: '/user',
    name: 'SetupProfile',
    component: () => import('../views/user/Profile.vue'),
    children: [
      { path: "profile/setup", component: () => import('../views/user/UserDetail.vue'), },
      { path: "product/create", component: () => import('../views/product/CreateProduct.vue'), },
      { path: "", redirect: "/user/profile/setup" },
    ],
    meta: { requiresAuth: true },
  },
]
