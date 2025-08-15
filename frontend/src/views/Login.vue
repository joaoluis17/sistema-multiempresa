<template>
  <div class="login-container">
    <div class="login-box">
      <h2 class="login-title">Login</h2>
      <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email" />
        <input v-model="password" type="password" placeholder="Senha" />
        <button type="submit">Entrar</button>
      </form>
    </div>
  </div>
</template>

<script>

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
        const response = await this.$http.post('/auth/login', {
          email: this.email,
          password: this.password
        })
        
        localStorage.setItem('jwt_token', response.data.access_token)
        this.$router.push('/')
        
      } catch (error) {
        console.error('Erro no login:', error.response)
        this.errorMessage = error.response?.data?.error || 'Erro ao fazer login'
      }
    }
  }
}
</script>

