<template>
    <div class="relative top-20 mx-auto shadow-xl rounded-md bg-custom-color" style="margin-left: 100px; margin-right:100px; border-radius: 10px;">
        <div class="p-6 space-y-6">
            <div>
                <h1 class="text-center text-4xl font-semibold custom-hover-text">L'ajout d'une atelier</h1>
            </div>
            <form action="#">
                <div class="grid grid-cols-6 gap-6">
                    <!-- Autres champs -->
                    <div class="col-span-6 sm:col-span-3">
                        <label for="titre" class="text-sm font-medium text-gray-900 block mb-2">Nom de l'atelier</label>
                        <input type="text" name="titre" id="titre" v-model="formData.titre" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nom de l'offre" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="objectif" class="text-sm font-medium text-gray-900 block mb-2">Objectif</label>
                        <input type="text" name="objectif" id="objectif" v-model="formData.objectif" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Objectif" required>
                    </div>
                    <div class="col-span-full">
                        <label for="description" class="text-sm font-medium text-gray-900 block mb-2">Description de l'offre</label>
                        <textarea id="description" rows="2" v-model="formData.description" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4" placeholder="Description"></textarea>
                    </div>
                    <div class="col-span-full">
                        <label for="lienYtb" class="text-sm font-medium text-gray-900 block mb-2">Lien YouTube</label>
                        <input type="text" name="lienYtb" id="lienYtb" v-model="formData.lienYtb" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Lien YouTube" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="imagePub" class="text-sm font-medium text-gray-900 block mb-2">Choisir une photo</label>
                        <input type="file" name="imagePub" id="imagePub" @change="handleFileUpload($event, 'imagePub')" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nom de l'offre" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="programme" class="text-sm font-medium text-gray-900 block mb-2">Programme</label>
                        <input type="file" name="programme" id="programme" @change="handleFileUpload($event, 'programme')" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nom de l'offre" required>
                    </div>
                    <!-- Autres champs -->
                    <div class="col-span-6 sm:col-span-3">
                        <label for="agemax" class="text-sm font-medium text-gray-900 block mb-2">Age max</label>
                        <input type="text" name="agemax" id="agemax" v-model="formData.agemax" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Age max" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="agemin" class="text-sm font-medium text-gray-900 block mb-2">Age min</label>
                        <input type="text" name="agemin" id="agemin" v-model="formData.agemin" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Age min" required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="type" class="text-sm font-medium text-gray-900 block mb-2">Type</label>
                        <input type="text" name="type" id="type" v-model="formData.type" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Type" required>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex" style="margin-left: 370px;">
            <div class="p-6 border-t border-gray-200 rounded-b">
                <a @click="saveAtelier" class="text-white bg-gradient-selected font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                    Ajouter atelier
                </a>
            </div>  
            <div class="p-6 border-t border-gray-200 rounded-b">
                <a href="#" onclick="closeModal('modelConfirm')" class="text-black bg-custom-color font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                    Cancel
                </a>
            </div>  
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
            formData: {
                titre: '',
                objectif: '',
                description: '',
                lienYtb: '',
                imagePub: null,
                programme: null,
                agemax: '',
                agemin: '',
                type: ''
            }
        };
    },
    methods: {
        handleFileUpload(event, fieldName) {
            this.formData[fieldName] = event.target.files[0];
        },
        async saveAtelier() {
            try {
                const formData = new FormData();
                formData.append('titre', this.formData.titre);
                formData.append('objectif', this.formData.objectif);
                formData.append('description', this.formData.description);
                formData.append('lienYtb', this.formData.lienYtb);
                formData.append('imagePub', this.formData.imagePub);
                formData.append('programme', this.formData.programme);
                formData.append('agemax', this.formData.agemax);
                formData.append('agemin', this.formData.agemin);
                formData.append('type', this.formData.type);

                await axios.post('http://127.0.0.1:8000/api/admin/activites', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                this.$emit('AtelierAdded');
            } catch (error) {
                console.error('Error adding Atelier:', error.response.data.errors);
            }
        }
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