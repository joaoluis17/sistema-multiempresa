<template>
  <nav class="cabecalho">
    <div class="navbar-container">
      <span class="company-name" v-if="user && user.company">
        🏢 {{ user.company.name || 'Minha Empresa' }}
      </span>
      
      <span class="usuario" v-if="user">
        👤 {{ user.name || 'Usuário' }}
      </span>
      
      <div class="logout-container">
        <button class="logout" @click="logout">Sair</button>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      user: {
        name: '',
        company: {
          name: ''
        }
      }
    }
  },
  async mounted() {
    await this.fetchUser();
  },
  methods: {
    async fetchUser() {
      try {
        console.log('Buscando dados do usuário...'); // Debug
        const response = await this.$http.get('/auth/me');
        console.log('Dados recebidos:', response.data); // Debug
        this.user = response.data;
      } catch (error) {
        console.error('Erro ao carregar usuário:', error.response || error);
        // Fallback para dados de exemplo
        this.user = {
          name: 'Usuário Teste',
          company: {
            name: 'Empresa Teste'
          }
        };
      }
    },
    async logout() {
      try {
        await this.$http.post('/auth/logout');
      } catch (error) {
        console.error('Erro no logout:', error);
      } finally {
        this.clearAuthData();
        this.redirectToLogin();
      }
    },
    clearAuthData() {
      localStorage.removeItem('jwt_token');
      delete this.$http.defaults.headers.common['Authorization'];
      this.user = null;
    },
    redirectToLogin() {
      // Verifica se a rota atual não é login para evitar redundância
      if (this.$route.path !== '/login') {
        this.$router.push('/login').catch(err => {
          // Ignora erros de navegação redundante
          if (!err.message.includes('Avoided redundant navigation')) {
            console.error('Erro de navegação:', err);
          }
        });
      }
    }
  }
}
</script>