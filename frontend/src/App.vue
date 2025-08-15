<template>
  <div id="app">
    <Navbar v-if="isAuthenticated" />
    <router-view />
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue';

export default {
  components: {
    Navbar
  },
  computed: {
    isAuthenticated() {
      return this.$route.meta.requiresAuth;
    }
  },
  watch: {
    $route(to) {
      if (to.meta.requiresAuth && !localStorage.getItem('jwt_token')) {
        this.$router.push('/login');
      }
    }
  }
}
</script>
