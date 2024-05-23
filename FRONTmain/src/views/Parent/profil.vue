<template>
    <section class="container" id="home" v-if="user">
        <div class="box-container">
            <div class="box">
                <div class="image">
                    <img src="https://img.freepik.com/premium-photo/happy-fathers-day-father-as-superhero-cartoon-family-with-superhero-dad-elegant-mom_409847-97.jpg" alt="">
                </div>
                <h3 > {{ user.nom }} {{ user.prenom }}</h3>
                    <div style="display: flex; align-items: center;">
                        <svg class="h-8 w-8 text-gray-700" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z"/>
                          <rect x="3" y="5" width="18" height="14" rx="2" />
                          <polyline points="3 7 12 13 21 7" />
                        </svg>
                        <span  style="margin-left: 17px;">{{ user.email }}</span>
                      </div>
                      <div style="display: flex; align-items: center;">
                        <svg class="h-8 w-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span  style="margin-left: 17px;">{{ user.tel }}</span>
                      </div>
            </div>
        
            <div class="box">
                <div class="image">
                    <h2 style="margin-left: -30px;">Mes enfants :</h2>
                </div>
                <div class="overflow-y-scroll enfant mx-9" v-if="this.enfants.length > 0">
                    <div style="margin-bottom: -1.05rem;" v-for="enfant in enfants" :key="enfant.id" class="flex items-center justify-between gap-3 mt-8 bg-gray-100 rounded-2xl p-2 hover:transform hover:scale-105 hover:shadow-md hover:text-gray-800 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10">
                                <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="@/assets/images/prfl.png" alt="" />
                            </div>
                            <div>
                                <div class="text-sm font-medium text-secondary-500">{{ enfant.nom }} {{ enfant.prenom }}</div>
                                <div class="text-xs text-secondary-400">{{ calculateAge(enfant.dateNaissance) }} ans</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div  class="flex items-center gap-2">
                                <svg @click="deleteEnfant(enfant.id)" class="h-6 w-6 text-gray-400 cursor-pointer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"/>
                                    <line x1="18" y1="6" x2="6" y2="18"/>
                                    <line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                                <svg @click="openUpdateModal(enfant)" class="h-6 w-6 text-gray-400 cursor-pointer" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z"/>
                                    <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"/>
                                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"/>
                                    <line x1="16" y1="5" x2="19" y2="8"/>
                                </svg>
                                <dialog id="my_modal_31" class="modal">
                                    <UpdateEnfant :enfant="selectedEnfant" @enfantUpdated="getEnfants"/>
                                </dialog>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="overflow-y-scroll enfant mx-9" v-else>
                    <div style="margin-bottom: -1.05rem;" 
                    class="flex flex-wrap items-center justify-start gap-3 mt-8 bg-gray-100 rounded-2xl p-2 pr-1 hover:transform hover:scale-105 hover:shadow-md hover:text-gray-800 transition-all duration-300">
                        <div class="h-10 w-10"></div>
                        <div>
                            <div class="text-sm font-medium text-secondary-500">tu n'as pas encore d'enfant</div>
                            <div class="text-xs text-secondary-400"></div>
                        </div>
                    </div>
                </div>
                
                <a class="btn1 btn" @click="showModal()">Ajouter enfant</a> 
                <dialog id="my_modal_1" class="modal">
                    <AjouterEnfant @enfantAdded="getEnfants"/>
                </dialog>  
            </div>   
        
            <div class="box">
                <div class="image">
                    <h2 style="margin-left: -30px;">Mes offres :</h2>
                </div>
                <div class="overflow-y-scroll enfant mx-9">
                    <div class="flex flex-wrap items-center justify-start gap-3 mt-8 bg-gray-100 rounded-2xl p-2 pr-1 hover:transform hover:scale-105 hover:shadow-md hover:text-gray-800 transition-all duration-300">
                        <div class="h-10 w-10">
                            <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="@/assets/images/offre1.png" alt="" />
                        </div>
                        <div>
                            <div class="text-sm font-medium text-secondary-500">offre1</div>
                            <div class="text-xs text-secondary-400">horaire</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-start gap-3 mt-4 bg-gray-100 rounded-2xl p-2 pr-1 hover:transform hover:scale-105 hover:shadow-md hover:text-gray-800 transition-all duration-300">
                        <div class="h-10 w-10">
                            <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="@/assets/images/offre2.png" alt="" />
                        </div>
                        <div>
                            <div class="text-sm font-medium text-secondary-500">offre2</div>
                            <div class="text-xs text-secondary-400">horaire</div>
                        </div>
                    </div>
                </div>
                <a class="btn1 btn" href="#offres">Ajouter offre</a>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Same styles as provided */
</style>
<style scoped>
.overflow-y-scroll {
    height: 10.5rem; /* Set a specific height */
    overflow-y: scroll; /* Ensure vertical scrolling */
    overflow-x: hidden; /* Hide horizontal scrolling if not needed */
    padding-left: 10px; /* Optional: space inside the div */
    padding-right: 10px; /* Optional: space inside the div */
    padding-top: 0px; /* Optional: space inside the div */
    padding-bottom: 10px; /* Optional: space inside the div */
    margin: 10px; /* Optional: space outside the div */
    background-color: #ffffff; /* Optional: background color */
    border: 1px solid #ffffff; /* Optional: border */
    border-radius: 5px; /* Optional: rounded corners */
    font-family: Arial, sans-serif; /* Optional: font family */
    font-size: 14px; /* Optional: font size */
    color: #333; /* Optional: text color */
    line-height: 1.5; /* Optional: line height */
}

/* Hide scrollbar by default */
.overflow-y-scroll::-webkit-scrollbar {
    width: 0;
}

/* On hover, show the scrollbar */
.overflow-y-scroll:hover::-webkit-scrollbar {
    width: 12px; /* Width of the scrollbar */
}

/* Style the scrollbar thumb */
.overflow-y-scroll::-webkit-scrollbar-thumb {
    background-color: #888; /* Color of the scrollbar thumb */
    border-radius: 6px; /* Rounded corners for the thumb */
}

.overflow-y-scroll:hover::-webkit-scrollbar-thumb {
    background-color: #555; /* Color of the scrollbar thumb when hovered */
}

/* Style the scrollbar track */
.overflow-y-scroll::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Color of the scrollbar track */
}
.container{
    padding-top: 2rem;
    padding-bottom: 4rem;
    background-color: #F6F5F4;
}

.container .box-container{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(10rem, .6fr));
    gap: -1rem;
    margin-top: 5rem;
    margin-left: 8rem;
    margin-right: 8rem;
    background-color: white;
    border-radius: 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.container .box-container .box{
    
    padding: 1rem 1rem;
    text-align: center;
    transition: .7s ease;
}


.container .box-container .box .image{
    padding: 1rem 4rem;    
}

.container .box-container .box .image h2{
    text-align: left;
    font-size: 1.6rem;
    font-weight: bolder;
    margin-bottom: -1rem;
}
.container .box-container .box .image img{
    height: 9rem;
    border-radius: 5rem;

}

.container .box-container .box h3{
    font-size: 2rem;
    font-weight: 600;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    color: black;
    margin-bottom: 1.rem;
}
.container .box-container .box div span{
    font-size: 1.1rem;
    font-weight: 500;
    color: rgb(90, 89, 89);
}
.container .box-container .box p{
    padding-top: 0rem;
}

.container .box-container .box p{
    font-size: var(--p-font);
    color: var(--second-color);
    margin-top: 1.5rem;
    font-weight: 550;
}
.btn1{
    margin-top: 1rem;
    color: #FFFFFF;
    background-color: #A3B18A;
    padding: .5rem .8rem;
    border-radius: 2rem;
    transition: .7s ease;
}
.btn1:hover {
    transform: scale(1.03);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
<script>
import AjouterEnfant from './AjouterEnfant.vue'
import UpdateEnfant from './UpdateEnfant.vue';
import { mapGetters } from 'vuex';
import axios from 'axios';

export default {
  name: 'profil',
  data() {
    return {
      enfants: [],
      selectedEnfant: null
    }
  },
  mounted() {
    this.getEnfants();
  },
  components: { 
    AjouterEnfant,
    UpdateEnfant
  },
  watch: {
    user(newUser) {
      if (newUser) {
        this.getEnfants();
      } else {
        this.enfants = [];
      }
    }
  },
  computed: {
    ...mapGetters(['user']),
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
    async deleteEnfant(enfantId) {
      try {
        await axios.delete(`/parent/enfants/${enfantId}`);
        this.enfants = this.enfants.filter(enfant => enfant.id !== enfantId);
      } catch (error) {
        console.error('Error deleting child:', error);
      }
    },
    calculateAge(dateNaissance) {
      const birthDate = new Date(dateNaissance);
      const ageDifMs = Date.now() - birthDate.getTime();
      const ageDate = new Date(ageDifMs); // milliseconds from epoch
      return Math.abs(ageDate.getUTCFullYear() - 1970);
    },
    showModal() {
      const modal = this.$el.querySelector('#my_modal_1');
      if (modal) {
        modal.showModal();
      }
    },
    openUpdateModal(enfant) {
      this.selectedEnfant = enfant;
      const modal = this.$el.querySelector('#my_modal_31');
      if (modal) {
        modal.showModal();
      }
    }
  },
}
</script>
