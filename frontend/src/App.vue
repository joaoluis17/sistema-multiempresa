<template>
  <div id="app">
    <h1>📋 Lista de Tarefas</h1>

    <!-- Formulário de nova tarefa -->
    <form @submit.prevent="addTask">
      <input v-model="newTask" placeholder="Nova tarefa..." />
      <button type="submit">Adicionar</button>
    </form>

    <!-- Lista de tarefas -->
    <ul>
      <li v-for="task in tasks" :key="task.id">
        <input type="checkbox" :checked="task.completed" @change="toggleTask(task)">
        <span :style="{ textDecoration: task.completed ? 'line-through' : 'none' }">
          {{ task.title }}
        </span>
        <button @click="deleteTask(task.id)">🗑️</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'App',
  data() {
    return {
      tasks: [],
      newTask: ''
    }
  },
  created() {
    this.fetchTasks()
  },
  methods: {
    async fetchTasks() {
      try {
        const res = await axios.get('http://localhost:8000/api/tasks')
        this.tasks = res.data.data // depende do formato que sua API está retornando
      } catch (err) {
        console.error('Erro ao buscar tarefas:', err)
      }
    },
    async addTask() {
      if (!this.newTask) return
      try {
        const res = await axios.post('http://localhost:8000/api/tasks', {
          title: this.newTask,
          completed: false
        })
        this.tasks.push(res.data.data)
        this.newTask = ''
      } catch (err) {
        console.error('Erro ao adicionar tarefa:', err)
      }
    },
    async deleteTask(id) {
      try {
        await axios.delete(`http://localhost:8000/api/tasks/${id}`)
        this.tasks = this.tasks.filter(t => t.id !== id)
      } catch (err) {
        console.error('Erro ao excluir tarefa:', err)
      }
    },
    async toggleTask(task) {
      try {
        const res = await axios.put(`http://localhost:8000/api/tasks/${task.id}`, {
          title: task.title,
          completed: !task.completed
        })
        task.completed = res.data.data.completed
      } catch (err) {
        console.error('Erro ao atualizar tarefa:', err)
      }
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
