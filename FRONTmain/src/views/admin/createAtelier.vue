<template>
<div class="relative top-20 mx-auto shadow-xl rounded-md bg-custom-color" style="margin-left: 100px; margin-right:100px; border-radius: 10px;">
    

    <div class="p-6 space-y-6">
        <div >
            <h1 class="text-center text-4xl font-semibold custom-hover-text">L'ajout d'une atelier</h1>
        </div>
        <form action="#">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="titre" class="text-sm font-medium text-gray-900 block mb-2">Nom de l'atelier</label>
                    <input type="text" name="titre" id="titre" v-model="formData.titre" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nom de l'offre" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="objectif" class="text-sm font-medium text-gray-900 block mb-2">Objectif</label>
                    <input type="text" name="objectif" id="objectif" v-model="formData.objectif" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Objectif" required="">
                </div>
                <div class="col-span-full">
                    <label for="description" class="text-sm font-medium text-gray-900 block mb-2">Description de l'offre</label>
                    <textarea id="description" rows="2" v-model="formData.description" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4" placeholder="Description"></textarea>
                </div>
                <div class="col-span-full">
                    <label for="lienYtb" class="text-sm font-medium text-gray-900 block mb-2">Lien YouTube</label>
                    <input type="text" name="lienYtb" id="lienYtb" v-model="formData.lienYtb" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Lien YouTube" required="">
                </div>
                <!-- <div class="col-span-6 sm:col-span-3">
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Plage d'ages</label>
                    <input type="text" name="product-name" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Plage d'ages" required="">
                </div> -->
                <div class="col-span-6 sm:col-span-3">
                    <label for="imagePub" class="text-sm font-medium text-gray-900 block mb-2">Choisir une photo</label>
                    <input type="file" name="imagePub" id="imagePub"  class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nom de l'offre" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="effectif" class="text-sm font-medium text-gray-900 block mb-2">Effectif</label>
                    <input type="text" name="effectif" id="effectif" v-model="formData.effectif" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Effectif" required="">
                </div>
            </div>
        </form>
    </div>

    <div class="flex" style="margin-left: 370px;">
        <div class="p-6 border-t border-gray-200 rounded-b">
            <a href="#"  @click="submitForm" class="text-white bg-gradient-selected font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
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
//import { mapGetters } from 'vuex';
import axios from 'axios';
export default{
    name :'createAtelier',
    // computed: {
    //   ...mapGetters(['user']),

    //   },
      data(){
        return {
            formData:{
                titre:'',
                objectif:'',
                description:'',
                lienYtb:'',
                imagePub:'',
                effectif:''
            }
        }
      },
      methods: {
    
    async submitForm() {
        //console.log(this.formData.type)
        let result = await axios.post('/http://localhost:3000/atelier',{
            titre :  this.formData.titre, 
            objectif : this.formData.objectif,
            description : this.formData.description,
            lienYtb : this.formData.lienYtb,  
            imagePub : this.formData.imagePub,
            effectif : this.formData.effectif
          
        })        
        .then(()=>{
           this.formData.titre = '' 
           this.formData.objectif = ''
           this.description = ''
           this.formData.lienYtb = ''
           this.formData.imagePub = ''
           this.formData.effectif = ''
        })
    }
}};

      

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