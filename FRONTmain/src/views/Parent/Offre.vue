<template>
  <section class="package" id="offres" v-if="user">
    <h1><span>Nos</span> Offres</h1>
    <div v-if="offres.length > 0">
      <div v-for="offre in offres" :key="offre.offre.idOffre" class="offre">
        <div class="offre"> {{ offre.offre.titre }} <span>valable jusqu'au {{ new Date(offre.offre.dateFinOffre).toLocaleDateString() }}</span></div>
        <p>{{ offre.offre.description }}</p>
        <div class="box-container">
          <div class="box" v-for="activite in offre.activites" :key="activite.idActivite">
            <div class="image">
              <img src="@/assets/images/offre1.png" alt="">
            </div>
            <h3>{{ activite.titre }}</h3>
            <p>{{ activite.description }}</p>
            <p class="sm:text-sm">Objectif de cette atelier : {{ activite.objectif }}</p>
  
            <div class="age">
              <template v-for="offreActivite in offre.offre.offre_activite" :key="offreActivite.idOffre">
                <span v-if="offreActivite.idActivite === activite.idActivite">
                  Plage d’âge : <span>{{ offreActivite.age_min }} ans - {{ offreActivite.age_max }} ans</span>
                </span>
              </template>
            </div>
            <a :href="activite.programmePdf" class="btnn">Programme</a>
          </div>
        </div>
    
        <a href="#" class="btn1 btn" @click.prevent="showModal(offre)">Inscrivez votre enfant</a>
        <dialog id="my_modal_2" class="modal">
          <AjouterOffre :offre="selectedOffre"/>
        </dialog>
      </div>
    </div>
  </section>
</template>

<script>
import AjouterOffre from './AjouterOffre.vue';
import { mapGetters } from 'vuex';
import axios from 'axios';

export default {
  name: 'Offre',
  components: {
    AjouterOffre
  },
  data() {
    return {
      offres: [],
      selectedOffre: null,
    };
  },
  computed: {
    ...mapGetters(['user'])
  },
  mounted() {
    this.getOffres();
  },
  methods: {
    async getOffres() {
      try {
        const response = await axios.get('/offres');
        this.offres = response.data.data;
        console.log(response.data.data);
      } catch (error) {
        console.error('Error fetching Ateliers:', error);
      }
    },
    showModal(offre) {
      this.selectedOffre = offre;
      document.getElementById('my_modal_2').showModal();
    }
  }
};
</script>

<style scoped>

.btn1 {
  margin-top: 1rem;
  color: #FFFFFF;
  background-color: #A3B18A;
  padding: .5rem .8rem;
  border-radius: 2rem;
  transition: .7s ease;
  margin-left: 30rem;
}

.btn1:hover {
  transform: scale(1.03);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

section {
  padding-top: 8rem;
  background-color: #F6F5F4;
  padding-bottom: 5rem;
}

.package p {
  margin-left: 5rem;
  margin-right: 5rem;
  font-size: 1.1rem;
  font-weight: 600;
}

.package h1 {
  font-size: 3rem;
  font-weight: 800;
  margin-top: -8rem;
  color: #A3B18A ;
  text-align: center;
}

.package h1 span {
  color: #2E2E2E;
}

.package .box-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(15rem, .6fr));
  gap: 1.5rem;
  margin-left: 5rem;
  margin-right: 5rem;
  margin-bottom: 5rem;
}

.package .box-container .box {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  margin-top: 0.8rem;
  padding: 0rem 0;
  text-align: center;
  border: .1rem solid #F6F5F4;
  transition: .7s ease;
  border-radius: 1.2rem;
  padding-bottom: 1rem;
}

.package .box-container .box .image {
  padding: 0;
  margin: 0;
}

.package .box-container .box .image img {
  height: 23rem;
  width: 55rem;
  border-radius: 1.2rem;
}

.package .box-container .box h3 {
  font-size: 1.5rem;
  padding-top: 1rem;
  font-weight: 600;   
}

.package .box-container .box p {
  font-size: 1.1rem;
  font-weight: 400;
  text-align: left;
  margin-left: 1rem;
  margin-right: 1rem;
  height: 9rem;
}

.package .box-container .box .age {
  color: #585858;
  font-size: 1.1rem;
  padding: 1rem 0;
  margin-left: -0.2rem;  
}

.package .box-container .box .age span {
  font-size: 1.55rem;
  color: #A3B18A;
}

.package .box-container .box:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.package .offre {
  font-size: 1.7rem;
  font-weight: 800;
  color: #585858 ;
  text-align: left;
  margin-left: 6rem;
  margin-top: 1rem;
}

.package .offre span {
  font-size: 2.1rem;
  font-weight: 800;
  margin-top: -8rem;
  color: #2f6639 ;
  text-align: center;
}

.btnn {
  color: #FFFFFF;
  background-color: #2E2E2E;
  padding: 0.5rem 1.2rem;
  border-radius: 5rem;
  transition: .7s ease;
  cursor: pointer;
}

.btnn:hover {
  color: #2E2E2E;
  background-color: #A3B18A;
  transform: scale(1.05);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
