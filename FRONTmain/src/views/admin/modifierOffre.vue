<template>
    <div class="relative top-20 mx-auto shadow-xl rounded-md bg-custom-color" style="margin-left: 100px; margin-right: 100px; border-radius: 10px;">
      <div class="p-6 space-y-6">
        <div>
          <h1 class="text-center text-4xl font-semibold custom-hover-text">Modifier l'offre</h1>
        </div>
        <form @submit.prevent="submitForm">
          <div class="grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
              <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Nom de l'offre</label>
              <input type="text" v-model="form.productName" id="product-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Nom de l'offre" required>
            </div>
            <div class="col-span-6 sm:col-span-3">
              <label for="category" class="text-sm font-medium text-gray-900 block mb-2">Valable jusqu'à</label>
              <div>
                <input type="date" v-model="form.validUntil" id="date" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
              </div>
            </div>
            <div class="col-span-full">
              <label for="product-details" class="text-sm font-medium text-gray-900 block mb-2">Description de l'offre</label>
              <textarea v-model="form.description" id="product-details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4" placeholder="Description"></textarea>
            </div>
            <div class="col-span-12 sm:col-span-6">
              <div class="flex">
                <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Ajouter Atelier</label>
                <button @click.prevent="addWorkshop">
                  <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left: 5px">
                    <g id="Edit / Add_Plus_Circle">
                      <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                  </svg>
                </button>
              </div>
              <details v-for="(workshop, index) in form.workshops" :key="index" class="group shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5 mt-2">
                <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                  <span class="flex items-center custom-hover-text" style="margin-left: 350px;">Remplir les informations de l'atelier</span>
                  <span class="transition group-open:rotate-180">
                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                      <path d="M6 9l6 6 6-6"></path>
                    </svg>
                  </span>
                </summary>
                <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
                  <div class="w-full sm:w-1/2 px-2">
                    <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Nom de l'atelier</label>
                    <select v-model="workshop.type" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg f focus:border-black block w-full p-2.5">
                      <option value="None" selected>None</option>
                      <option value="Programming">Atelier programmation</option>
                      <option value="Robotics">Atelier robotique</option>
                      <option value="AI">Atelier AI</option>
                    </select>
                  </div>
                  <div class="w-full sm:w-1/2 px-2">
                    <label for="category" class="text-sm font-medium text-gray-900 block mb-2">Plage d'âges</label>
                    <div>
                      <input type="text" v-model="workshop.ageRange" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Plage d'âges" required>
                    </div>
                  </div>
                </div>
                <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
                  <div class="w-full  px-2">
                    <div class="flex">
                      <label for="product-name" class="text-sm font-medium text-gray-900 block mb-2">Ajouter séance</label>
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
                            <div class="w-full sm:w-1/3 px-2">
                            <label for="session-day" class="text-sm font-medium text-gray-900 block mb-2">Jour</label>
                            <select v-model="session.day" id="session-day" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
                                <option value="Lundi">Lundi</option>
                                <option value="Mardi">Mardi</option>
                                <option value="Mercredi">Mercredi</option>
                                <option value="Jeudi">Jeudi</option>
                                <option value="Vendredi">Vendredi</option>
                                <option value="Samedi">Samedi</option>
                                <option value="Dimanche">Dimanche</option>
                            </select>
                            </div>
                            <div class="w-full sm:w-1/3 px-2">
                            <label for="session-time" class="text-sm font-medium text-gray-900 block mb-2">Heure</label>
                            <input type="time" v-model="session.time" id="session-time" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                            </div>
                            <div class="w-full sm:w-1/3 px-2">
                            <label for="session-duration" class="text-sm font-medium text-gray-900 block mb-2">Durée</label>
                            <input type="number" v-model="session.duration" id="session-duration" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Durée (minutes)" required>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </details>
            </div>
          </div>
          <div class="flex mt-4">
            <div class="p-6 border-t border-gray-200 rounded-b">
              <button type="submit" class="text-white bg-gradient-selected font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                Ajouter offre
              </button>
            </div>
            <div class="p-6 border-t border-gray-200 rounded-b">
              <button onclick="closeModal('modifier')" class="text-black bg-custom-color font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
                Annuler
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script >
  export default {
    name: 'modifierOffre',
    data() {
      return {
        form: {
          productName: '',
          validUntil: '',
          description: '',
          workshops: []
        }
      };
    },
    methods: {
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
    }
  }
    window.closeModal = function(modalId) {
        document.getElementById(modalId).style.display = 'none'
        document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
    }
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
  