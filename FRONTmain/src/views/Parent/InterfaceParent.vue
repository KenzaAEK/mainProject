<template>
    <navbar/>
    <profil/>
    <Offre/>
    <Footer/>

</template>
<script>
import navbar from './navbar.vue'
import profil from './profil.vue';
import Offre from './Offre.vue';
import Footer from './Footer.vue';

export default {
    name: 'App',
    components: { 
        navbar,
        profil,
        Offre,
        Footer
    }
  }
</script>