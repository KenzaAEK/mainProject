<template>
    <navbar />
    <profil />
    <Offre/>
    <Footer/>

</template>
<script>
import axios from 'axios';
import navbar from './navbar.vue'
import profil from './profil.vue';
import Offre from './Offre.vue';
import Footer from './Footer.vue';
import { mapGetters } from 'vuex';

export default {
    name: 'parent',
    components: { 
        navbar,
        profil,
        Offre,
        Footer
    },
    computed: {
      ...mapGetters(['user']),
      
    }
  }
</script>