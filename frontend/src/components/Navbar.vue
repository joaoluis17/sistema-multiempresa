<template>
  <nav class="cabecalho">
    <span class="usuario" v-if="user">
      👤 {{ user.name }} | 🏢 {{ user.company.name }}
    </span>
    <button class="logout" @click="logout">Sair</button>
  </nav>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Navbar',
  data() {
    return {
      user: null
    }
  },
  async created() {
    try {
      const res = await axios.get('/api/user-profile')
      this.user = res.data
    } catch (error) {
      console.error('Erro ao carregar perfil do usuário:', error)
    }
  },
  methods: {
    async logout() {
      try {
        await axios.post('/logout')
        this.$router.push('/login')
      } catch (err) {
        console.error('Erro ao fazer logout:', err)
      }
    }
  }
}
</script>

<style>

</style>
