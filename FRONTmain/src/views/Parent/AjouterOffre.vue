<template>
  <div class="modal-box flex flex-col gap-3">
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
              <span class="flex items-center gap-2 custom" style="margin-left: 140px;">Remplir le formulaire</span>
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
                <label for="product-name" class="flex items-center gap-2 custom">Choisir enfant</label>
                <select v-model="workshop.prenomEnfant" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
                  <option value="None" disabled selected>None</option>
                  <option v-for="enfant in enfants" :key="enfant.id" :value="enfant.id">{{enfant.prenom}}</option>
                </select>
              </div>
            </div>
            <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
              <div class="w-full px-2">
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
                      <select v-model="session.titreActivite" id="session-day" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
                        <option v-for="activity in offre.activities" :key="activity.idActivite" :value="activity.titre">{{ activity.titre }}</option>
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
    <select v-model="form.type" id="session-day" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
      <option value="None" disabled selected>Pack--</option>
      <option value="PackEnfant">PackEnfant</option>
      <option value="PackAtelier">PackAtelier</option>
    </select>

    <label class="flex items-center gap-2 custom">Options de paiement :</label>
    <select id="session-day" v-model="form.optionsPaiement" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
      <option value="" disabled selected>Option de paiement --</option>
      <option value="mensuel">mensuel</option>
      <option value="trimestriel">trimestriel</option>
      <option value="annuel">annuel</option>
    </select>
    <div class="modal-action">
      <form method="dialog" class="inline-flex justify-end gap-4">
        <button type="submit" class="btn1 btn btn-info" @click="submitForm()">Ajouter</button>
        <button  class="btn">Close</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'ajouterOffre',
  props: {
    offre: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      form: {
        type: '',
        idOffre: '',
        optionsPaiement: '',
        workshops: [],
      },
      showForm: true,
      enfants: [],
    };
  },
  mounted() {
    this.getEnfants();
  },
  methods: {
    async getEnfants() {
      try {
        const response = await axios.get('/parent/enfants');
        this.enfants = response.data.data;
      } catch (error) {
        console.error('Error fetching children:', error);
      }
    },
    async submitForm() {
      try {
        // Transformation des données du formulaire en l'objet désiré
        const transformedData = {
          optionsPaiement: this.form.optionsPaiement,
          type: this.form.type,
          idOffre: this.offre.offre.idOffre, // Assigner la valeur de l'offre
          enfants: this.form.workshops.map(workshop => {
            const enfant = this.enfants.find(e => e.id === workshop.prenomEnfant);
            return {
              nomEnfant: enfant ? enfant.nom : '',
              prenomEnfant: enfant ? enfant.prenom : '',
              Ateliers: workshop.sessions.map(session => ({
                titreActivite: session.titreActivite
              }))
            };
          })
        };
        
        // Envoi des données transformées
        console.log(transformedData);
        const response = await axios.post('http://127.0.0.1:8000/api/parent/demande-Inscriptions', transformedData);

        if (response.status === 201) {
          this.$emit('demandeEffectuee');
          alert('La demande a été ajoutée avec succès');
        } else {
          console.error('Erreur lors de l\'ajout de la demande:', response.data);
          alert('Erreur lors de l\'ajout de la demande. Veuillez réessayer.');
        }
      } catch (error) {
        console.error('Erreur de réseau ou serveur:', error);
        if (error.response && error.response.status === 422) {
          console.error('Détails de validation:', error.response.data);
          alert('Erreur de validation. Veuillez vérifier vos données.');
        } else {
          alert('Erreur de réseau ou serveur. Veuillez réessayer.');
        }
      }
    },
    addWorkshop() {
      this.form.workshops.push({
        prenomEnfant: '',
        sessions: []
      });
    },
    addSession(workshopIndex) {
      this.form.workshops[workshopIndex].sessions.push({
        titreActivite: ''
      });
    },
    removeWorkshop(index) {
      this.form.workshops.splice(index, 1);
    },
    removeSession(workshopIndex, sessionIndex) {
      this.form.workshops[workshopIndex].sessions.splice(sessionIndex, 1);
    }
  }
}
</script>

<style>
h3 {
  color: #A3B18A;
  font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  font-size: 1.7rem;
}
.custom {
  color: rgba(67, 65, 65, 0.874);
  font-weight: bold;
}
.btn1 {
  background-color: #A3B18A;
  border: #A3B18A;
}
</style>
