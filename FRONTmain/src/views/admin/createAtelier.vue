<template>
    <div class="relative top-20 mx-auto shadow-xl rounded-md bg-custom-color" style="margin-left: 100px; margin-right:100px; border-radius: 10px;">
        <div class="p-6 space-y-6">
            <div>
                <h1 class="text-center text-4xl font-semibold custom-hover-text">L'ajout d'une atelier</h1>
            </div>
            <form @submit.prevent="addAtelier" id="atelierForm">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="titre" class="text-sm font-medium text-gray-900 block mb-2">Nom de l'offre</label>
                        <input v-model="atelier.titre" type="text" name="titre" id="titre" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nom de l'offre" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="objectif" class="text-sm font-medium text-gray-900 block mb-2">Objectif</label>
                        <input v-model="atelier.objectif" type="text" name="objectif" id="objectif" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Objectif" required>
                    </div>
                    <div class="col-span-full">
                        <label for="description" class="text-sm font-medium text-gray-900 block mb-2">Description de l'offre</label>
                        <textarea v-model="atelier.description" id="description" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4" placeholder="Description"></textarea>
                    </div>
                    <div class="col-span-full">
                        <label for="lienYtb" class="text-sm font-medium text-gray-900 block mb-2">Lien YouTube</label>
                        <input v-model="atelier.lienYtb" type="text" name="lienYtb" id="lienYtb" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Lien YouTube" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="imagePub" class="text-sm font-medium text-gray-900 block mb-2">Choisir une photo</label>
                        <input @change="handleFileUpload($event, 'imagePub')" type="file" name="imagePub" id="imagePub" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="programmePdf" class="text-sm font-medium text-gray-900 block mb-2">Programme</label>
                        <input @change="handleFileUpload($event, 'programmePdf')" type="file" name="programmePdf" id="programmePdf" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="type" class="text-sm font-medium text-gray-900 block mb-2">Type</label>
                        <input v-model="atelier.type" type="text" name="type" id="type" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Type" required>
                    </div>
                </div>
                <div class="flex justify-center mt-4">
                    <button type="submit" class="text-white bg-gradient-selected font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                        Ajouter atelier
                    </button>
                    <button type="button" @click="closeModal('modelConfirm')" class="text-black bg-custom-color font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
    
<script>
import { mapGetters } from 'vuex';
import axios from 'axios';

export default {
  name: 'createAtelier',
  computed: {
    ...mapGetters(['user']),
  },
  data() {
    return {
      atelier: {
        titre: '',
        description: '',
        objectif: '',
        lienYtb: '',
        type: '',
      },
      imagePub: null,
      programmePdf: null
    };
  },
  methods: {
    async addAtelier() {
      const formData = new FormData();
      formData.append('titre', this.atelier.titre);
      formData.append('description', this.atelier.description);
      formData.append('objectif', this.atelier.objectif);
      formData.append('lienYtb', this.atelier.lienYtb);
      formData.append('type', this.atelier.type);
      formData.append('imagePub', this.imagePub);
      formData.append('programmePdf', this.programmePdf);

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/admin/activites', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        console.log(response.data);
        this.$emit('atelier-added', response.data); // Emitting the correct event with response data
        this.closeModal('modelConfirm');
      } catch (error) {
        console.error(error.response.data);
      }
    },
    handleFileUpload(event, field) {
      if (field === 'imagePub') {
        this.imagePub = event.target.files[0];
      } else if (field === 'programmePdf') {
        this.programmePdf = event.target.files[0];
      }
    },
    closeModal(modalId) {
      document.getElementById(modalId).style.display = 'none';
      document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden');
    }
  }
};

window.openModal = function(modalId) {
    document.getElementById(modalId).style.display = 'block';
    document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden');
};

window.closeModal = function(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden');
};
</script>

<style>
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
    background-color: #F6F5F4 ;
}
</style>
