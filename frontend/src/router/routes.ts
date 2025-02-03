export default [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/HomeView.vue')
  },
  {
    path: '/product/create',
    name: 'CreateProduct',
    component: () => import('../views/product/CreateProduct.vue')
  },
]
