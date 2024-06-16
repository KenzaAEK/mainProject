<template>
  <div class="flex flex-wrap items-center justify-between" v-if="user">
    <h2 class="mr-10 text-4xl font-bold leading-none md:text-3xl">Offres :</h2>
    <button
      onclick="openModal('modelConfirm')"
      href="#"
      class="block pb-1 mt-2 text-base font-black text-black uppercase border-b border-transparent custom-hover-text"
      style="margin-right: 30px;"
    >
      Ajouter offre ->
    </button>
  </div>

  <div v-if="user" class="max-w-screen-xl" style="margin-top: 20px;" v-for="offre in offres" :key="offre.id">
    <div class="bg-white shadow-lg p-6 rounded-lg">
      <div class="flex justify-between">
        <h1 class="text-3xl font-bold">{{ offre.offre.titre }}</h1>
        <div class="offre">
          valable de <span>{{ offre.offre.dateDebutOffre }}</span> jusqu'au <span>{{ offre.offre.dateFinOffre }}</span>
          avec remise de <span>{{ offre.offre.remise }} %</span>
        </div>
        <span class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">
          <button @click="confirmDelete(offre.offre.idOffre)">
            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          
            <svg @click="openUpdateModal(offre)" width="15px" height="15px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 121.96" style="enable-background:new 0 0 122.88 121.96" xml:space="preserve">
              <g>
                <path class="st0" d="M107.73,1.31c-0.96-0.89-2.06-1.37-3.29-1.3c-1.23,0-2.33,0.48-3.22,1.44l-7.27,7.54l20.36,19.67l7.33-7.68c0.89-0.89,1.23-2.06,1.23-3.29c0-1.23-0.48-2.4-1.37-3.22L107.73,1.31L107.73,1.31L107.73,1.31z M8.35,5.09h50.2v13.04H14.58c-0.42,0-0.81,0.18-1.09,0.46c-0.28,0.28-0.46,0.67-0.46,1.09v87.71c0,0.42,0.18,0.81,0.46,1.09c0.28,0.28,0.67,0.46,1.09,0.46h87.71c0.42,0,0.81-0.18,1.09-0.46c0.28-0.28,0.46-0.67,0.46-1.09V65.1h13.04v48.51c0,2.31-0.95,4.38-2.46,5.89c-1.51,1.51-3.61,2.46-5.89,2.46H8.35c-2.32,0-4.38-0.95-5.89-2.46C0.95,118,0,115.89,0,113.61V13.44c0-2.32,0.95-4.38,2.46-5.89C3.96,6.04,6.07,5.09,8.35,5.09L8.35,5.09z M69.62,75.07c-2.67,0.89-5.42,1.71-8.09,2.61c-2.67,0.89-5.35,1.78-8.09,2.67c-6.38,2.06-9.87,3.22-10.63,3.43c-0.75,0.21-0.27-2.74,1.3-8.91l5.07-19.4l0.42-0.43l20.02,20.02L69.62,75.07L69.62,75.07L69.62,75.07z M57.01,47.34L88.44,14.7l20.36,19.6L77.02,67.35L57.01,47.34L57.01,47.34z"/>
              </g>
            </svg>
          
        </span>
      </div>
      <div v-if="user" style="margin-bottom: 8px">{{ offre.offre.description }}.</div>
      <div v-if="user" class="sm:grid lg:grid-cols-3 sm:grid-cols-2 gap-10">
        <div
          v-for="activity in offre.activities"
          :key="activity.idActivite"
          class="custom-hover-bg hover:text-white transition duration-300 max-w-sm rounded overflow-hidden shadow-lg"
        >
          <div class="py-4 px-8">
            <a :href="activity.lienYtb">
              <h4 class="text-lg mb-3 font-semibold">{{ activity.titre }}</h4>
            </a>
            <p class="mb-2 text-sm text-gray-600">{{ activity.description }}</p>
            <a :href="formatLienYtb(activity.lienYtb)" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Read more</a>
            <img :src="activity.imagePub" class="w-100" />
            <hr class="mt-4" />
            <div class="flex justify-between" style="margin-top: 10px">
              <button onclick="openModal('listeEA')" class="block font-semibold text-l">Details</button>
              <button class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">Programme</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div v-if="user" id="my_modal_1" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
  <modifierOffre :offre="selectedOffre" @offre-updated="getOffres"/>
</div>
  <div v-if="user" id="modelConfirm" class="fixed hidden inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
    <createOffre @offreAdded="getOffres"/>
  </div>
  

  <div v-if="user" id="sure" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
    <supprimerOffre @onDeleteConfirmed="deleteOffre" />
  </div>
  <div v-if="user" id="listeEA" class="fixed hidden inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
    <listeEA />
  </div>
</template>

  
<script type="text/javascript">
import createOffre from './createOffre.vue';
import supprimerOffre from './supprimerOffre.vue';
import listeEA from './listeEA.vue';
import modifierOffre from './modifierOffre.vue';
import { mapGetters } from 'vuex';
import axios from 'axios';

export default {
  name: 'offre',
  data() {
    return {
      offres: [],
      offreIdToDelete: null,
      selectedOffre: null
    };
  },
  mounted() {
    this.getOffres();
  },
  watch: {
    user(newUser) {
      if (newUser) {
        this.getOffres();
      } else {
        this.offres = [];
      }
    }
  },
  methods: {
    async getOffres() {
      try {
        const response = await axios.get('/admin/offres');
        this.offres = response.data.data;
        console.log(response.data.data);
      } catch (error) {
        console.error('Error fetching Ateliers:', error);
      }
    },
    formatLienYtb(lienYtb) {
      if (!/^https?:\/\//i.test(lienYtb)) {
        return `http://${lienYtb}`;
      }
      return lienYtb;
    },
    confirmDelete(id) {
      this.offreIdToDelete = id;
      openModal('sure');
    },
    async deleteOffre() {
      try {
        await axios.delete(`/admin/offres/${this.offreIdToDelete}`);
        this.getOffres();
        this.offreIdToDelete = null;
        closeModal('sure');
      } catch (error) {
        console.error('Error deleting offre:', error);
      }
    },
    openModal(modalId) {
      document.getElementById(modalId).style.display = 'block';
      document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden');
    },
    openUpdateModal(offre) {
      this.selectedOffre = offre;
      console.log('1')

      openModal('my_modal_1');
      console.log('defe')
    },
    handleOffreUpdated(updatedOffre) {
      const index = this.offres.findIndex(a => a.idOffre === updatedAtelier.idOffre);
      if (index !== -1) {
        this.offres.splice(index, 1, updatedOffre);
      }
      this.message = 'Offre updated successfully!';
      setTimeout(() => {
        this.message = '';
      }, 3000);
    }
  },
  computed: {
    ...mapGetters(['user']),
  },
  components: {
    createOffre,
    supprimerOffre,
    listeEA,
    modifierOffre,
  },
};

window.openModal = function (modalId) {
  document.getElementById(modalId).style.display = 'block';
  document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden');
};

window.closeModal = function (modalId) {
  document.getElementById(modalId).style.display = 'none';
  document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden');
};
</script>

  
  <style scoped>
  .custom-hover-bg {
    background-color: #fff; /* Set default background color */
  }
  .offre {
    font-size: 1.2rem;
    font-weight: 800;
    color: #585858;
    text-align: left;
    margin-left: 6rem;
    margin-top: 0.5rem;
    margin-bottom: 1.5rem;
  }
  .offre span {
    font-size: 1.6rem;
    font-weight: 800;
    margin-top: -8rem;
    color: #2b963f;
    text-align: center;
  }
  .custom-hover-bg:hover {
    background-image: linear-gradient(to right, #A3B18A, #BECBA5); /* Set gradient background on hover */
    color: #fff; /* Change text color on hover */
  }
  .custom-hover-text:hover {
    color: #A3B18A;
  }
  .custom-hover-text {
    color: #A3B18A;
  }
  
  .bg-gradient-selected {
    background-color: #A3B18A;
  }
  
  .bg-custom-color {
    background-color: #F6F5F4;
  }
  </style>
  