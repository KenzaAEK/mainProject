<script >
import { RouterLink, RouterView } from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
import axios from 'axios';

export default {
    name: 'App',
    async created() {
        const response = await axios.get('/users');
        this.$store.dispatch('user', response.data);
        
    }
  }
</script>

<template>
  

  <RouterView />
</template>

<style scoped>

</style>
