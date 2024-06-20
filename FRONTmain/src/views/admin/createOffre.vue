<template>
  <div v-if="user" class="relative top-20 mx-auto shadow-xl rounded-md bg-custom-color" style="margin-left: 100px; margin-right: 100px; border-radius: 10px;">
    <div class="p-6 space-y-6">
      <div>
        <h1 class="text-center text-4xl font-semibold custom-hover-text">L'ajout d'une offre</h1>
      </div>
      <form @submit.prevent="submitForm">
        <div class="grid grid-cols-6 gap-6">
          <div class="col-span-6 sm:col-span-3">
            <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Nom de l'offre :</label>
            <input type="text" v-model="form.titre" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nom de l'offre" required>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="product-remise" class="text-sm font-medium text-gray-900 block mb-2">Remise :</label>
            <input type="number" v-model="form.remise" id="product-remise" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Remise" required>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="dateDebutOffre" class="text-sm font-medium text-gray-900 block mb-2">Date de début de l'offre :</label>
            <input type="date" v-model="form.dateDebutOffre" id="dateDebutOffre" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
          </div>
          <div class="col-span-6 sm:col-span-3">
            <label for="dateFinOffre" class="text-sm font-medium text-gray-900 block mb-2">Date de fin de l'offre :</label>
            <input type="date" v-model="form.dateFinOffre" id="dateFinOffre" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
          </div>
          <div class="col-span-full">
            <label for="product-details" class="text-sm font-medium text-gray-900 block mb-2">Description de l'offre :</label>
            <textarea v-model="form.description" id="product-details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4" placeholder="Description"></textarea>
          </div>
          <div class="col-span-12 sm:col-span-6">
            <div class="flex">
              <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Ajouter Activité</label>
              <button @click.prevent="addActivity">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 5px">
                  <g id="Edit / Add_Plus_Circle">
                    <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </g>
                </svg>
              </button>
            </div>
            <details v-for="(activity, index) in form.activites" :key="index" class="group shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 mt-2">
              <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                <span class="flex items-center custom-hover-text" style="margin-left: 350px;">Remplir les informations de l'activité</span>
                <span class="transition group-open:rotate-180">
                  <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                    <path d="M6 9l6 6 6-6"></path>
                  </svg>
                </span>
              </summary>
              <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
                <div  class="w-full sm:w-1/3 px-2">
                  <label for="activity-name" class="text-sm font-medium text-gray-900 block mb-2">Nom de l'activité</label>
                  <select  v-model="activity.titre" class="grow input input-bordered flex items-center gap-2" name="Niveau d'études"  required>
                    <option value="" disabled selected>Activité --</option>
                    <option v-for="atelier in ateliers" :key="atelier.id" :value="atelier.titre">{{ atelier.titre }}</option>
                  </select>
                </div>
                <div class="w-full sm:w-1/3 px-2">
                  <label for="activity-tarif" class="text-sm font-medium text-gray-900 block mb-2">Tarif :</label>
                  <input type="number" v-model="activity.tarif" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Tarif" required>
                </div>
                <div class="w-full sm:w-1/3 px-2">
                  <label for="activity-effmax" class="text-sm font-medium text-gray-900 block mb-2">Effectif maximum :</label>
                  <input type="number" v-model="activity.effmax" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Effectif maximum" required>
                </div>
              </div>
              <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
                <div class="w-full sm:w-1/3 px-2">
                  <label for="activity-effmin" class="text-sm font-medium text-gray-900 block mb-2">Effectif minimum :</label>
                  <input type="number" v-model="activity.effmin" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Effectif minimum" required>
                </div>
                <div class="w-full sm:w-1/3 px-2">
                  <label for="activity-age_max" class="text-sm font-medium text-gray-900 block mb-2">Age maximum :</label>
                  <input type="number" v-model="activity.age_max" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Age maximum" required>
                </div>
                <div class="w-full sm:w-1/3 px-2">
                  <label for="activity-age_min" class="text-sm font-medium text-gray-900 block mb-2">Age minimum :</label>
                  <input type="number" v-model="activity.age_min" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Age minimum" required>
                </div>
              </div>
              <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
                <div class="w-full sm:w-1/3 px-2">
                  <label for="activity-nbrSeance" class="text-sm font-medium text-gray-900 block mb-2">Nombre de séances :</label>
                  <input type="number" v-model="activity.nbrSeance" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nombre de séances" required>
                </div>
                <div class="w-full sm:w-1/3 px-2">
                  <label for="activity-Duree_en_heure" class="text-sm font-medium text-gray-900 block mb-2">Durée par séance (heures) :</label>
                  <input type="number" v-model="activity.Duree_en_heure" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Durée par séance (heures)" required>
                </div>
              </div>
              <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
                <div class="w-full px-2">
                  <label for="activity-days" class="text-sm font-medium text-gray-900 block mb-2">Jours de l'activité :</label>
                  <button @click.prevent="addDay(index)">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 5px">
                      <g id="Edit / Add_Plus_Circle">
                        <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </g>
                    </svg>
                  </button>
                  <div v-for="(day, dayIndex) in activity.jours" :key="dayIndex" class="flex items-center space-x-4 mt-2">
                    <div class="w-full sm:w-1/3 px-2">
                      <label for="day-JourAtelier" class="text-sm font-medium text-gray-900 block mb-2">Jour :</label>
                      <input type="text" v-model="day.JourAtelier" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Jour" required>
                    </div>
                    <div class="w-full sm:w-1/3 px-2">
                      <label for="day-heureDebut" class="text-sm font-medium text-gray-900 block mb-2">Heure de début :</label>
                      <input type="time" v-model="day.heureDebut" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    </div>
                    <div class="w-full sm:w-1/3 px-2">
                      <label for="day-heureFin" class="text-sm font-medium text-gray-900 block mb-2">Heure de fin :</label>
                      <input type="time" v-model="day.heureFin" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                    </div>
                    <button @click.prevent="deleteDay(index, dayIndex)" class="text-red-600">Supprimer</button>
                  </div>
                </div>
              </div>
              <button @click.prevent="deleteActivity(index)" class="mt-3 text-red-600">Supprimer l'activité</button>
            </details>
          </div>
        </div>
        <div class="flex mt-4">
        <div class="p-6 border-t border-gray-200 rounded-b">
          <button type="submit" class="text-white bg-gradient-selected font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">Ajouter</button>
        </div>
        <div class="p-6 border-t border-gray-200 rounded-b">
          <button onclick="closeModal('modelConfirm')" class="text-black bg-custom-color font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
            Annuler
          </button>
        </div>
      </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';
export default {
  data() {
    return {
      form: {
        titre: '',
        remise: '',
        dateDebutOffre: '',
        dateFinOffre: '',
        description: '',
        activites: []
      },
      ateliers: [],
      showForm: true
    };
  },
  mounted() {
    this.getAteliers();
  },
  computed: {
    ...mapGetters(['user']),
  },
  methods: {
    addActivity() {
      this.form.activites.push({
        tarif: '',
        titre: '',
        effmax: '',
        effmin: '',
        age_min: '',
        age_max: '',
        nbrSeance: '',
        Duree_en_heure: '',
        jours: []
      });
    },
    async getAteliers() {
      try {
        const response = await axios.get('/admin/activites');
        this.ateliers = response.data;
        console.log(response);
      } catch (error) {
        console.error('Error fetching Ateliers:', error);
      }
    },
    deleteActivity(index) {
      this.form.activites.splice(index, 1);
    },
    addDay(activityIndex) {
      this.form.activites[activityIndex].jours.push({
        JourAtelier: '',
        heureDebut: '',
        heureFin: ''
      });
    },
    deleteDay(activityIndex, dayIndex) {
      this.form.activites[activityIndex].jours.splice(dayIndex, 1);
    },
    async submitForm() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/admin/offres', this.form);
        if (response.status === 200) {
          this.$emit('offreAdded');
          this.closeModal('modelConfirm');
          alert('Offre ajoutée avec succès ');
        } else {
          console.error('Erreur lors de l\'ajout de l\'offre:', response.data);
          alert('Erreur lors de l\'ajout de l\'offre. Veuillez réessayer.');
        }
        
      } catch (error) {
        console.error('Erreur de réseau:', error);
        alert('Erreur de réseau. Veuillez réessayer.');
      }
    },
    closeModal(modalId) {
      document.getElementById(modalId).style.display = 'none';
      document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden');
    },
    resetForm() {
      this.form = {
        titre: '',
        remise: '',
        dateDebutOffre: '',
        dateFinOffre: '',
        description: '',
        activites: []
      };
    }
  }
};
window.closeModal = function(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden');
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
  