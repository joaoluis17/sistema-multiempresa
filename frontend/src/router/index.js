import Home from '@/views/Home.vue';
import Login from '@/views/Login.vue';
import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
      meta: { requiresAuth: true }
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: { guest: true }
    }
  ]
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('jwt_token');
  
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      next('/login');
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.guest)) {
    if (isAuthenticated) {
      next('/');
    } else {
      next();
    }
  } else {
    next();
  }
});

const originalPush = router.push
router.push = function push(location) {
  return originalPush.call(this, location).catch(err => {
    if (!err.message.includes('Avoided redundant navigation')) {
      throw err
    }
  })
}

export default router;