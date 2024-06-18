<template>
  <div v-if="user" class="flex flex-wrap items-center justify-between">
    <h2 class="mr-10 text-4xl font-bold leading-none md:text-3xl">
      Ateliers : {{ user.nom }}
    </h2>
    <button @click="openModal('modelConfirm')" class="block pb-1 mt-2 text-base font-black text-black uppercase border-b border-transparent custom-hover-text">
      Ajouter Atelier ->
    </button>
  </div>
  <div v-if="message" class="alert alert-success">
    {{ message }}
  </div>
  <div class="max-w-screen-xl" style="margin-top: 20px;" v-if="ateliers.length > 0">
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
                <button @click="confirmDelete(atelier.idActivite)">
                  <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </button>
                <svg @click="openUpdateModal(atelier)" class="h-6 w-6 text-gray-900 cursor-pointer" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z"/>
                  <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"/>
                  <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"/>
                  <line x1="16" y1="5" x2="19" y2="8"/>
              </svg>
              </span>
              <button class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">Programme</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Open the modal using ID.showModal() method -->

<dialog id="my_modal_1" class="modal">
  <UpdateAtelier :atelier="selectedAtelier" @atelier-updated="getAteliers"/>
</dialog>
  <div id="modelConfirm" class="fixed hidden inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
    <createAtelier @atelier-added="getAteliers"/>
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
import createAtelier from './createAtelier.vue';
import UpdateAtelier from './UpdateAtelier.vue';
import axios from 'axios';

export default {
  name: 'atelier',
  data() {
    return {
      ateliers: [],
      idToDelete: null,
      message: '',
      selectedAtelier: null // New data property for the selected atelier
    };
  },
  mounted() {
    this.getAteliers();
  },
  methods: {
    async getAteliers() {
      try {
        const response = await axios.get('/admin/activites');
        this.ateliers = response.data;
        console.log(response);
      } catch (error) {
        console.error('Error fetching Ateliers:', error);
      }
    },
    handleAtelierAdded(newAtelier) {
      console.log('New Atelier added:', newAtelier);
      if (newAtelier && newAtelier.titre && newAtelier.description) {
        this.ateliers.push(newAtelier);
      } else {
        console.error('Received atelier data does not have the expected structure:', newAtelier);
      }
      this.message = 'Atelier added successfully!';
      this.closeModal('modelConfirm');
      setTimeout(() => {
        this.message = '';
      }, 3000);
    },
    confirmDelete(id) {
      this.idToDelete = id;
      this.openModal('sure');
    },
    async deleteConfirmed() {
      if (!this.idToDelete) {
        console.error('Aucun atelier à supprimer');
        return;
      }

      try {
        await axios.delete(`/admin/activites/${this.idToDelete}`);
        this.ateliers = this.ateliers.filter(atelier => atelier.idActivite !== this.idToDelete);
        console.log('Atelier deleted:', this.idToDelete);
      } catch (error) {
        console.error('Error deleting Atelier:', error);
      } finally {
        this.idToDelete = null;
        this.closeModal('sure');
      }
    },
    formatLienYtb(lienYtb) {
      if (!/^https?:\/\//i.test(lienYtb)) {
        return `http://${lienYtb}`;
      }
      return lienYtb;
    },
    getImageSrc(imagePub) {
      return imagePub;
    },
    openModal(modalId) {
      document.getElementById(modalId).style.display = 'block';
      document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden');
    },
    closeModal(modalId) {
      document.getElementById(modalId).style.display = 'none';
      document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden');
    },
    openUpdateModal(atelier) {
      this.selectedAtelier = atelier;
      openModal('my_modal_1');
    },
    handleAtelierUpdated(updatedAtelier) {
      const index = this.ateliers.findIndex(a => a.idActivite === updatedAtelier.idActivite);
      if (index !== -1) {
        this.ateliers.splice(index, 1, updatedAtelier);
      }
      this.message = 'Atelier updated successfully!';
      setTimeout(() => {
        this.message = '';
      }, 3000);
    }
  },
  computed: {
    ...mapGetters(['user']),
  },
  watch: {
    user(newUser) {
      if (newUser) {
        this.getAteliers();
      } else {
        this.ateliers = [];
      }
    }
  },
  components: {
    createAtelier,
    UpdateAtelier
  }
};
</script>

<style scoped>
.custom-hover-bg {
  background-color: #fff;
}
.custom-hover-bg:hover {
  background-image: linear-gradient(to right, #A3B18A, #BECBA5);
  color: #fff;
}
.custom-hover-text:hover {
  color: #A3B18A;
}
</style>
