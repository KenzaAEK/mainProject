<template>
  <div class="modal-box flex flex-col gap-3" v-if="user">
    <h3 class="font-bold text-lg">Demande Insciption</h3>
    <form @submit.prevent="submitForm">
      <div class="grid grid-cols-6 gap-6">
        <div class="col-span-12 sm:col-span-6">
          <div class="flex">
            <label for="product-name" class="flex items-center gap-2 custom">Selectionnez vos enfants :</label>
            <button @click.prevent="addWorkshop">
              <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 5px">
                <g id="Edit / Add_Plus_Circle">
                  <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
              </svg>
            </button>
          </div>
          <details v-for="(workshop, index) in form.workshops" :key="index" class="group shadow-sm bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 mt-2">
            <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
              <span class="flex items-center gap-2 custom" style="margin-left: 140px;">Remplir la formulaire</span>
              <span class="flex transition group-open:rotate-180">
                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                  <path d="M6 9l6 6 6-6"></path>
                </svg>
                <button @click.prevent="removeWorkshop(index)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-3 h-5 w-5 text-black hover:text-black" style="margin-left: 3px; margin-top: 2px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
              </span>
            </summary>
            <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
              <div class="w-full  px-2">
                <div class="flex">
                  <label for="product-name" class="flex items-center gap-2 custom">Choisir enfant</label>
                  
                </div>
                <select  v-model="idEnfant" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
                  <option value="None" selected>None</option>
                  <option value="Enfant1"  v-for="enfant in enfants" :key="enfant.id">{{ enfant.nom }} {{ enfant.prenom }}</option>
                </select>
              </div>
            </div>
            <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
              <div class="w-full  px-2">
                <div class="flex">
                  <label for="product-name" class="flex items-center gap-2 custom">Ajouter atelier</label>
                  <button @click.prevent="addSession(index)">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 5px">
                      <g id="Edit / Add_Plus_Circle">
                        <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </g>
                    </svg>
                  </button>
                </div>
                <div v-for="(session, sIndex) in workshop.sessions" :key="sIndex" class="mt-2">
                  <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
                    <div class="w-full px-2">
                      <div class="flex">
                        <label for="session-day" class="flex items-center gap-2 custom">Atelier</label>
                        <button @click.prevent="removeSession(index, sIndex)">
                          <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-3 h-5 w-5 text-black hover:text-black" style="margin-left: 3px; margin-top: 1px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                        </button>
                      </div>
                      <select v-model="idActivite" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
                        <option value="None" disabled selected>Choisir une activité</option>
                        <option v-for="activite in activites" :key="activite.idActivite">{{ activite.titre }}</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </details>
        </div>
      </div>
    </form>

    <label class="flex items-center gap-2 custom">Packs d’inscription :</label>
    <select v-model="type" id="session-day" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
        <option value="None" disabled selected>Pack--</option>
        <option value="Pack 1">PackEnfant </option>
        <option value="Pack 2">PackAtelier</option>
    </select>

    <label class="flex items-center gap-2 custom">Options de paiement :</label>
    <select  id="session-day" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
      <option value="" disabled selected>Option de paiement --</option>
      <option value="primaire">mensuel</option>
      <option value="collège">trimestriel</option>
      <option value="secondaire">annuel</option>
    </select>
    <div class="modal-action">
      <form method="dialog" class="inline-flex justify-end gap-4">
        <button @click="saveInscription" class="btn1 btn btn-info">Ajouter</button>
        <button class="btn">Close</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';
export default {
  name: 'ajouterOffre',
  data() {
    return {
      activites: [] ,
      enfants: [],
      idActivite:'',
      idEnfant:'',
      type :'',
      idOffre:'1',
      //option :'',
      form: {
        workshops: []
      },
      
     

    };
  },
  mounted() {
      this.getActivites();
      this.getEnfants();
    },
  methods: {
    async saveInscription() {
      try {
        await axios.post('http://127.0.0.1:8000/api/demande-Inscriptions', {
          idActivite: this.idActivite,
          idEnfant: this.idEnfant,
          type: this.type,
          idOffre: this.idOffre,
        });
        //this.$emit('enfantAdded');
      } catch (error) {
        console.error('Error adding demande inscription:', error);
      }
    },
    async getActivites() {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/activites');
          this.activites = response.data; // Assurez-vous que les données sont correctement affectées ici
        } catch (error) {
          console.error('Erreur lors de la récupération des activités :', error);
        }
      },
      async getEnfants() {
      try {
        const response = await axios.get('/parent/enfants');
        this.enfants = response.data.data;
      } catch (error) {
        console.error('Error fetching children:', error);
      }
    },
    addWorkshop() {
      this.form.workshops.push({
        type: '',
        ageRange: '',
        sessions: []
      });
    },
    addSession(workshopIndex) {
      this.form.workshops[workshopIndex].sessions.push({
        day: '',
        time: ''
      });
    },
    removeWorkshop(index) {
      this.form.workshops.splice(index, 1);
    },
    removeSession(workshopIndex, sessionIndex) {
      this.form.workshops[workshopIndex].sessions.splice(sessionIndex, 1);
    },
    submitForm() {
      // Handle form submission
    }
  },
  computed: {
    ...mapGetters(['user']),
  },
};
</script>

<style scoped>
h3 {
  color: #A3B18A;
  font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  font-size: 1.7rem;
}
.btn1 {
  background-color: #A3B18A;
  border: #A3B18A;
}
.custom {
  color: rgba(67, 65, 65, 0.874);
  font-weight: bold;
}
</style>
