<template>
  <div id="app">
    <Navbar v-if="showNavbar" />
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
    showNavbar() {
      return this.$route.path !== '/login'
    }
  }
}
</script>

<style>
body {
  font-family: sans-serif;
  background: #f2f2f2;
  padding: 20px;
}
#app {
  max-width: 600px;
  margin: auto;
  background: white;
  padding: 20px;
  border-radius: 8px;
}
form {
  margin-bottom: 20px;
}
input[type="text"] {
  padding: 8px;
  width: 70%;
}
button {
  padding: 8px 12px;
  margin-left: 5px;
}
ul {
  list-style: none;
  padding: 0;
}
li {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}
</style>
