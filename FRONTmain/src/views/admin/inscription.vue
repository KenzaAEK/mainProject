<template>
    <div>
      <div v-if="user" class="flex flex-wrap items-center justify-between">
        <h4 class="mr-10 text-4xl font-bold leading-none md:text-3xl" style="margin-top: 5px;">
          Demande inscription :
        </h4>
      </div>
      <div class="max-w-screen-xl" style="margin-top: 20px; height: 600px; width: 1000px;">
        <div class="bg-white shadow-lg p-6 rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prenom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pack</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date demande</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Option de paiement</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="demande in demandes" :key="demande.id_demande" class="bg-white divide-y divide-gray-200">
                <td class="px-6 py-4 whitespace-nowrap">{{ demande.nom_tuteur}}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ demande.prenom_tuteur }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ demande.email_tuteur }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ demande.nom_pack }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ demande.date_demande }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ demande.options_paiement }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <button @click="openUpdateModal(demande)">
                    <span :class="getStatusClass(demande.status)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                      {{ demande.status }}
                    </span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  
      <!-- Modal -->
      <div v-if="selectedDemande" id="status" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60">
        <status :demande="selectedDemande" @accepter="getDemandes" @refuser="getDemandes" @close="selectedDemande = null" />
      </div>
    </div>
  </template>
  
  <script>
  import { mapGetters } from 'vuex';
  import axios from 'axios';
  import status from './status.vue';
  
  export default {
    name: 'Inscription',
    components: {
      status,
    },
    data() {
      return {
        demandes: [],
        selectedDemande: null,
      };
    },
    computed: {
      ...mapGetters(['user']),
    },
    mounted() {
      this.getDemandes();
    },
    methods: {
      async getDemandes() {
        try {
          const response = await axios.get('/admin/show-demande');
          this.demandes = response.data.data;
        } catch (error) {
          console.error('Error fetching demandes:', error);
        }
      },
      openUpdateModal(demande) {
        if (demande.status === 'en attente') {
          this.selectedDemande = demande;
        }
      },
      getStatusClass(status) {
        if (status === 'acceptée') {
          return 'bg-custom-color text-black';
        } else if (status === 'refusée') {
          return 'bg-red-500 text-white';
        } else {
          return 'bg-gradient-selected text-green-800';
        }
      },
    },
  };
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
    background-color: #F6F5F4 ;
  }
  .bg-custom-colorrr {
    background-color: #CEDCB6 ;
  }
</style>x

