<template>
  <div class="home">
    <h1>Lista de Tarefas</h1>
    
    <form @submit.prevent="addTask">
      <input v-model="newTask.title" placeholder="Título" required />
      <textarea v-model="newTask.description" placeholder="Descrição"></textarea>
      <select v-model="newTask.priority">
        <option value="low">Baixa</option>
        <option value="medium">Média</option>
        <option value="high">Alta</option>
      </select>
      <input type="date" v-model="newTask.due_date">
      <button type="submit">Adicionar</button>
    </form>

    <div class="filters">
      <select v-model="statusFilter">
        <option value="">Todos</option>
        <option value="pending">Pendentes</option>
        <option value="in_progress">Em progresso</option>
        <option value="completed">Concluídas</option>
      </select>
    </div>

    <ul>
      <li v-for="task in filteredTasks" :key="task.id">
        <div class="task-header">
          <input type="checkbox" :checked="task.status === 'completed'" 
                 @change="updateTaskStatus(task)">
          <span class="priority" :class="task.priority">{{ task.priority }}</span>
          <span class="due-date" v-if="task.due_date">{{ formatDate(task.due_date) }}</span>
        </div>
        <h3>{{ task.title }}</h3>
        <p>{{ task.description }}</p>
        <button @click="deleteTask(task.id)">Excluir</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      tasks: [],
      newTask: {
        title: '',
        description: '',
        status: 'pending',
        priority: 'medium',
        due_date: null
      },
      statusFilter: ''
    }
  },
  computed: {
    filteredTasks() {
      if (!this.statusFilter) return this.tasks;
      return this.tasks.filter(t => t.status === this.statusFilter);
    }
  },
  async created() {
    await this.fetchTasks();
  },
  methods: {
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString();
    },
    async fetchTasks() {
      try {
        const response = await this.$http.get('/tasks');
        this.tasks = response.data;
      } catch (error) {
        console.error('Erro ao buscar tarefas:', error);
        if (error.response.status === 401) {
          this.$router.push('/login');
        }
      }
    },
    async addTask() {
      try {
        const response = await this.$http.post('/tasks', this.newTask);
        this.tasks.push(response.data);
        this.resetForm();
      } catch (error) {
        console.error('Erro ao adicionar tarefa:', error);
      }
    },
    resetForm() {
      this.newTask = {
        title: '',
        description: '',
        status: 'pending',
        priority: 'medium',
        due_date: null
      };
    },
    async updateTaskStatus(task) {
      try {
        const newStatus = task.status === 'completed' ? 'pending' : 'completed';
        await this.$http.put(`/tasks/${task.id}`, { status: newStatus });
        task.status = newStatus;
      } catch (error) {
        console.error('Erro ao atualizar tarefa:', error);
      }
    },
    async deleteTask(id) {
      try {
        await this.$http.delete(`/tasks/${id}`);
        this.tasks = this.tasks.filter(t => t.id !== id);
      } catch (error) {
        console.error('Erro ao excluir tarefa:', error);
      }
    }
  }
}
</script>