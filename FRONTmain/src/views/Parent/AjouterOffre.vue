<template>
  <div class="modal-box flex flex-col gap-3">
    <h3 class="font-bold text-lg">Demande Insciption</h3>
    
    <!-- <label class="flex items-center gap-2 custom">
      Selectionnez vos enfants :
    </label> -->
      <!-- <select class="grow input input-bordered flex items-center gap-2" name="Enfants" required multiple >
        <option value="" disabled selected>vos enfants --</option>
        <option value="enfant1">Enfant 1</option>
        <option value="enfant2">Enfant 2</option>
        <option value="enfant3">Enfant 3</option>
      </select> -->
      
      <!-- <label class="flex items-center gap-2 custom">
        Sélectionnez vos ateliers  :
      </label>
        <select class="grow input input-bordered flex items-center gap-2" name="Ateliers" required multiple >
          <option value="" disabled selected>Vos ateliers --</option>
          <option value="enfant1">Atelier 1</option>
          <option value="enfant2">Atelier 2</option>
          <option value="enfant3">Atelier 3</option>
        </select> -->
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
                  <span class="transition group-open:rotate-180">
                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                      <path d="M6 9l6 6 6-6"></path>
                    </svg>
                  </span>
                </summary>
                <div class="flex group-open:animate-fadeIn mt-3 text-neutral-600">
                  <div class="w-full  px-2">
                    <label for="product-name" class="flex items-center gap-2 custom">Choisir enfant</label>
                    <select v-model="workshop.type" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg f focus:border-black block w-full p-2.5">
                      <option value="None" selected>None</option>
                      <option value="Enfant1">Enfant 1</option>
                      <option value="Enfant2">Enfant 2</option>
                      <option value="Enfant3">Enfant 3</option>
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
                            <label for="session-day" class="flex items-center gap-2 custom">Atelier</label>
                            <select v-model="session.day" id="session-day" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:border-black block w-full p-2.5">
                              <option value="None" selected>None</option>
                              <option value="Programming">Atelier programmation</option>
                              <option value="Robotics">Atelier robotique</option>
                              <option value="AI">Atelier AI</option>
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

    <label class="flex items-center gap-2 custom">
      Packs d’inscription  :
    </label>
    <select class="grow input input-bordered flex items-center gap-2" name="Packs"  required multiple>
      <option value="" disabled selected>Packs --</option>
      <option value="primaire">Pack 1</option>
      <option value="collège">Pack 2</option>
      <option value="secondaire">Pack 3</option>
    </select>
    <label class="flex items-center gap-2 custom">
      Options de paiement  :
    </label>
    <select class="grow input input-bordered flex items-center gap-2" name="Packs"  required multiple>
      <option value="" disabled selected>Packs --</option>
      <option value="primaire">mensuel</option>
      <option value="collège">trimestriel</option>
      <option value="secondaire">annuel</option>
    </select>
    <div class="modal-action">
        <form method="dialog" class="inline-flex justify-end gap-4">
            <button class="btn1 btn btn-info " >Ajouter</button>
            <button class="btn">Close</button>
        </form>
    </div>
</div>

</template>
<script>
export default {
    name: 'ajouterOffre',
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
</script>
<style scoped>
h3{
  color: #A3B18A;
  font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  font-size: 1.7rem;
}
.btn1{
  background-color: #A3B18A;
  border: #A3B18A;
}
.custom{
  color: rgba(67, 65, 65, 0.874);
  font-weight: bold;
}
</style>