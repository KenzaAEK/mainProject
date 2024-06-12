<template>
    <div v-if="user" class="relative top-20 mx-auto shadow-xl rounded-md bg-custom-color" style="margin-left: 100px; margin-right:100px; border-radius: 10px;margin-top:-9rem;">
      <div class="p-6 space-y-6">
        <div>
          <h1 class="text-center text-4xl font-semibold custom-hover-text">Edit d'une atelier</h1>
        </div>
        <form method="dialog">
          <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
              <label for="titre" class="text-sm font-medium text-gray-900 block mb-2">Nom de l'offre</label>
              <input v-model="titre" type="text" name="titre" id="titre" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nom de l'offre" required>
            </div>
            <div class="col-span-6 sm:col-span-3">
              <label for="objectif" class="text-sm font-medium text-gray-900 block mb-2">Objectif</label>
              <input v-model="objectif" type="text" name="objectif" id="objectif" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Objectif" required>
            </div>
            <div class="col-span-full">
              <label for="description" class="text-sm font-medium text-gray-900 block mb-2">Description de l'offre</label>
              <textarea v-model="description" id="description" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4" placeholder="Description"></textarea>
            </div>
            <div class="col-span-full">
              <label for="lienYtb" class="text-sm font-medium text-gray-900 block mb-2">Lien YouTube</label>
              <input v-model="lienYtb" type="text" name="lienYtb" id="lienYtb" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Lien YouTube" required>
            </div>
            <div class="col-span-6 sm:col-span-3">
              <label for="type" class="text-sm font-medium text-gray-900 block mb-2">Type</label>
              <input v-model="type" type="text" name="type" id="type" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Type" required>
            </div>
          </div>
          <div class="flex justify-center mt-4">
            <button @click="updateAtelier" class="text-white bg-gradient-selected font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
              Mettre à jour l'atelier
            </button>
            <button type="button" @click="closeModal('my_modal_1')" class="text-black bg-custom-color font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
              Annuler
            </button>
          </div>
        </form>
      </div>
    </div>
    <div v-else>
      Loading...
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { mapGetters } from 'vuex';
  
  export default {
    name: 'UpdateAtelier',
    props: ['atelier'],
    data() {
        return {
            titre: this.atelier ? this.atelier.titre : '',
            description: this.atelier ? this.atelier.description : '',
            objectif: this.atelier ? this.atelier.objectif : '',
            lienYtb: this.atelier ? this.atelier.lienYtb : '',
            type: this.atelier ? this.atelier.type : ''
        }
    },
    watch: {
        atelier(newAtelier) {
        if (newAtelier) {
          this.titre = newAtelier.titre;
          this.description = newAtelier.description;
          this.objectif = newAtelier.objectif;
          this.lienYtb = newAtelier.lienYtb;
          this.type = newAtelier.type;
        }
      }
    },
    computed: {
      ...mapGetters(['user']),
    },
    methods: {
      async updateAtelier() {
        try {
          const response = await axios.put(`/admin/activites/${this.atelier.idActivite}`, {
            titre: this.titre,
            description: this.description,
            objectif: this.objectif,
            lienYtb: this.lienYtb,
            type: this.type,
          });
          this.$emit('atelier-updated');
          this.closeModal('my_modal_1');
        } catch (error) {
          console.error('Error updating atelier:', error);
        }
      },
      closeModal(modalId) {
        document.getElementById(modalId).close();
        document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden');
      }
    }
  };
  
  window.openModal = function(modalId) {
    document.getElementById(modalId).showModal();
    document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden');
  };
  
  window.closeModal = function(modalId) {
    document.getElementById(modalId).close();
    document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden');
  };
  </script>
  
  <style>
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
  