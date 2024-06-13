<template>
    <div class="col-span-4 sm:col-span-9" v-if="user">
      <div v-for="(groupedActivite, index) in groupedActivites" :key="index" class="mb-10">
        <div class="hero-content flex-col">
          <div class="flex lg:flex-row mb-8">
            <div class="flex-shrink-0" style="width: 300px; height: 300px;">
              <img src="@/assets/images/offre1.png" alt="" class="w-full h-full object-cover rounded-lg">
            </div>
            <div class="ml-10 flex flex-col justify-between">
              <div>
                <h1 class="text-4xl font-bold">{{ groupedActivite.titre_activite }}</h1>
                <p class="py-6">{{ groupedActivite.description_atelier }}</p>
              </div>
              <div>
                <div class="flex items-center">
                  <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 6V12" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16.24 16.24L12 12" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <div class="text-base text-slate-900 font-semibold dark:text-slate-200 ml-2">
                    Horaires d'intervention
                  </div>
                </div>
                <div v-for="horaire in groupedActivite.horaires" :key="horaire.jour_activite + horaire.heure_debut" class="flex bg-gradient-sel px-6 py-4 mb-5 mt-5 rounded-2xl" style="width: 200px;">
                  <div class="font-semibold">
                    {{ horaire.jour_activite }} de {{ horaire.heure_debut }} à {{ horaire.heure_fin }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full overflow-x-auto">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
              <h2 class="mr-10 ml-4 text-2xl font-bold leading-none md:text-3xl">Liste des élèves :</h2>
              <div class="overflow-hidden">
                <table class="min-w-full">
                  <thead class="bg-white border-b">
                    <tr>
                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Nom</th>
                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Prénom</th>
                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Age</th>
                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Niveau d'études</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(enfant, i) in groupedActivite.enfants" :key="i" class="bg-white border-b">
                      <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ enfant.nom_enfant }}</td>
                      <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ enfant.prenom_enfant }}</td>
                      <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ enfant.age }} ans</td>
                      <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ enfant.niveau_etude }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  
  <script>
  import { mapGetters } from 'vuex';
  import axios from 'axios';
  
  export default {
    name: 'atelierAssocie',
    computed: {
      ...mapGetters(['user']),
    },
    data() {
      return {
        activites: [],
        groupedActivites: [],
      };
    },
    mounted() {
      this.getActivite();
    },
    methods: {
      async getActivite() {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/animateur/AnimateursEnf?page=1');
          this.activites = response.data.data;
          this.groupActivites();
        } catch (error) {
          console.error('Error fetching activites:', error);
        }
      },
      calculateAge(dateNaissance) {
        const birthDate = new Date(dateNaissance);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
          age--;
        }
        return age;
      },
      groupActivites() {
  const grouped = this.activites.reduce((acc, activite) => {
    const { titre_activite, jour_activite, heure_debut, heure_fin, prenom_enfant, nom_enfant, date_naissance, niveau_etude, description_atelier } = activite;
    if (!acc[titre_activite]) {
      acc[titre_activite] = {
        titre_activite,
        description_atelier,
        horaires: [],
        enfants: new Set(),
      };
    }
    const horaireString = `${jour_activite}-${heure_debut}-${heure_fin}`;
    if (!acc[titre_activite].horaires.some(h => h.horaireString === horaireString)) {
      acc[titre_activite].horaires.push({ jour_activite, heure_debut, heure_fin, horaireString });
    }
    const age = this.calculateAge(date_naissance);
    acc[titre_activite].enfants.add(JSON.stringify({ prenom_enfant, nom_enfant, age, niveau_etude }));
    return acc;
  }, {});

  this.groupedActivites = Object.values(grouped).map(activity => {
    return {
      ...activity,
      enfants: Array.from(activity.enfants).map(e => JSON.parse(e))
    };
  });
},

    },
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
  
  .bg-gradient-sel {
    background-color: #CAD2C5;
  }
  </style>
  