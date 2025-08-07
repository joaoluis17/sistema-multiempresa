<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <input v-model="email" placeholder="Email" />
      <input v-model="password" type="password" placeholder="Senha" />
      <button type="submit">Entrar</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    async login() {
      try {
        // 1. Obter o cookie CSRF
        await axios.get('/sanctum/csrf-cookie')

        // 2. Fazer login
        await axios.post('/login', {
          email: this.email,
          password: this.password
        })

        // ✅ 3. Buscar dados do usuário logado
        const profile = await axios.get('/api/user-profile')
        console.log('Usuário logado:', profile.data)

        // 4. Redirecionar
        this.$router.push('/')
      } catch (error) {
        console.error('Erro ao fazer login:', error)
      }
    }
  }
}
</script>
