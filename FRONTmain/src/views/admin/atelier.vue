<template>
    <div v-if="user" class="flex flex-wrap items-center justify-between ">
      <h2 class="mr-10 text-4xl font-bold leading-none md:text-3xl">
        Ateliers : {{ user.nom }}
      </h2>
      <button onclick="openModal('modelConfirm')" href="#" class="block pb-1 mt-2 text-base font-black text-black uppercase border-b border-transparent custom-hover-text">
        Ajouter Atelier ->
      </button>
    </div>
    <div class="max-w-screen-xl" style="margin-top: 20px;" v-if="this.ateliers.length > 0">
      <div class="bg-white shadow-lg p-6 rounded-lg">
        <div class="sm:grid lg:grid-cols-3 sm:grid-cols-2 gap-10">
          <div v-for="atelier in ateliers" :key="atelier.id" class="custom-hover-bg hover:text-white transition duration-300 max-w-sm rounded overflow-hidden shadow-lg">
            <div class="py-4 px-8">
              <a href="#">
                <h4 class="text-lg mb-3 font-semibold">{{ atelier.titre }}</h4>
              </a>
              <p class="mb-2 text-sm text-gray-600">{{ atelier.description }}</p>
              <a :href="formatLienYtb(atelier.lienYtb)" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Read more</a>
              <img :src="getImageSrc(atelier.imagePub)" class="w-100" alt="Atelier image" style="margin-top: 20px; border-radius: .5rem;">
              <hr class="mt-4">
              <div class="flex justify-between" style="margin-top: 10px">
                <span class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">
                  <button @click="deleteAtelier(atelier.idActivite)"><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg></button>
                </span>
                <button class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">Programme</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="modelConfirm" class="fixed hidden inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
      <createAtelier/>
    </div>
    <div id="sure" class="fixed hidden inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
      <div class="bg-white p-6 rounded-lg max-w-md m-auto mt-20">
        <h2 class="text-xl font-bold mb-4">Êtes-vous sûr de vouloir supprimer cet atelier ?</h2>
        <div class="flex justify-end">
          <button @click="deleteConfirmed" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Confirmer</button>
          <button @click="closeModal('sure')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuler</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { mapGetters } from 'vuex';
  import createAtelier from './createAtelier.vue'
  
  import axios from 'axios';
  export default {
    name: 'atelier',
    data() {
      return {
        ateliers: [],
        idToDelete: null
      }
    },
    mounted() {
      this.getAteliers();
    },
    methods: {
      async getAteliers() {
        try {
          const response = await axios.get('/admin/activites');
          this.ateliers = response.data;
          console.log(response)
        } catch (error) {
          console.error('Error fetching Ateliers:', error);
        }
      },
      async deleteAtelier(id) {
        openModal('sure');
        this.idToDelete = id;
        console.log(id)
        },
      async deleteConfirmed() {
        if (!this.idToDelete) {
          console.error('Aucun atelier à supprimer');
          return;
        }
  
        try {
          await axios.delete(`/admin/activites/${this.idToDelete}`);
          this.ateliers = this.ateliers.filter(atelier => atelier.id !== this.idToDelete);
          console.log('Atelier deleted:', this.idToDelete);
        } catch (error) {
          console.error('Error deleting Atelier:', error);
        } finally {
          this.idToDelete = null;
          closeModal('sure');
        }
      },
      formatLienYtb(lienYtb) {
        if (!/^https?:\/\//i.test(lienYtb)) {
          return `http://${lienYtb}`;
        }
        return lienYtb;
      },
      getImageSrc(imagePub) {
        return `src/assets/images/${imagePub}`;
      },
      openModal,
      closeModal
    },
    components: {
      createAtelier
    },
    computed: {
      ...mapGetters(['user']),
    }
  }
  window.openModal = function(modalId) {
    document.getElementById(modalId).style.display = 'block'
    document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden')
  }
  
  window.closeModal = function(modalId) {
    document.getElementById(modalId).style.display = 'none'
    document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
  }
  </script>
  
  <style scoped>
  .custom-hover-bg {
    background-color: #fff; /* Set default background color */
  }
  
  .custom-hover-bg:hover {
    background-image: linear-gradient(to right, #A3B18A, #BECBA5); /* Set gradient background on hover */
    color: #fff; /* Change text color on hover */
  }
  .custom-hover-text:hover {
    color:#A3B18A ;
  }
  .custom-hover-text {
    color:#A3B18A ;
  }
  .bg-gradient-selected {
    background-color: #A3B18A;
  }
  
  .bg-custom-color {
    background-color: #F6F5F4;
  }
  </style>
  