<template>
  <div class="hello">
    <h1>Todos</h1>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'HelloWorld',
  mounted() {
    axios.get('http://localhost:8000/api/todos')
      .then(response => {
        console.log(response.data)
      })
      .catch(error => {
        console.error(error)
      })
  }
}
</script>
