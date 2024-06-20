<template>
    <div>
        <div v-if="user" class="flex flex-wrap items-center justify-between">
            <h2 class="mr-10 text-4xl font-bold leading-none md:text-3xl">
                Les remises :
            </h2>
            <button @click="openModal('pack')" class="block pb-1 mt-2 text-base font-black text-black uppercase border-b border-transparent custom-hover-text">
                Ajouter Remise ->
            </button>
        </div>

        <!-- Tableau des packs -->
        <div class="max-w-screen-xl mt-20" style="height: 600px; width: 1000px;">
            <div class="bg-white shadow-lg p-6 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <!-- En-têtes de tableau -->
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom de Pack</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remise</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Limite</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <!-- Corps de tableau avec v-for -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="pack in packs" :key="pack.idPack">
                            <td class="px-6 py-4 whitespace-nowrap">{{ pack.type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ pack.remise }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ pack.limite }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button @click="deletePack(pack.idPack)" class="focus:outline-none">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                                </button>
                                <button @click="openUpdateModal(pack)" class="ml-2 focus:outline-none" >
                                    <svg width="15px" height="18px"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 121.96" style="enable-background:new 0 0 122.88 121.96" xml:space="preserve"><g><path class="st0" d="M107.73,1.31c-0.96-0.89-2.06-1.37-3.29-1.3c-1.23,0-2.33,0.48-3.22,1.44l-7.27,7.54l20.36,19.67l7.33-7.68 c0.89-0.89,1.23-2.06,1.23-3.29c0-1.23-0.48-2.4-1.37-3.22L107.73,1.31L107.73,1.31L107.73,1.31z M8.35,5.09h50.2v13.04H14.58 c-0.42,0-0.81,0.18-1.09,0.46c-0.28,0.28-0.46,0.67-0.46,1.09v87.71c0,0.42,0.18,0.81,0.46,1.09c0.28,0.28,0.67,0.46,1.09,0.46 h87.71c0.42,0,0.81-0.18,1.09-0.46c0.28-0.28,0.46-0.67,0.46-1.09V65.1h13.04v48.51c0,2.31-0.95,4.38-2.46,5.89 c-1.51,1.51-3.61,2.46-5.89,2.46H8.35c-2.32,0-4.38-0.95-5.89-2.46C0.95,118,0,115.89,0,113.61V13.44c0-2.32,0.95-4.38,2.46-5.89 C3.96,6.04,6.07,5.09,8.35,5.09L8.35,5.09z M69.62,75.07c-2.67,0.89-5.42,1.71-8.09,2.61c-2.67,0.89-5.35,1.78-8.09,2.67 c-6.38,2.06-9.87,3.22-10.63,3.43c-0.75,0.21-0.27-2.74,1.3-8.91l5.07-19.4l0.42-0.43l20.02,20.02L69.62,75.07L69.62,75.07 L69.62,75.07z M57.01,47.34L88.44,14.7l20.36,19.6L77.02,67.35L57.01,47.34L57.01,47.34z"/></g></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modales -->
        <div v-if="showAddModal" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
            <ajouterPacks @packAdded="getPacks" @closeModal="closeModal('pack')" />
        </div>
        <div v-if="showUpdateModal" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
            <modifierPack :pack="selectedPack" @packUpdated="getPacks" @closeModal="closeModal('modifier')" />
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from 'axios';
import ajouterPacks from './ajouterPacks.vue';
import modifierPack from './modifierPack.vue';

export default {
    name: 'packs',
    components: {
        ajouterPacks,
        modifierPack,
    },
    data() {
        return {
            packs: [],
            selectedPack: null,
            showUpdateModal: false,
            showAddModal: false,
        };
    },
    computed: {
        ...mapGetters(['user']),
    },
    methods: {
        async getPacks() {
            try {
                const response = await axios.get('/admin/packs');
                this.packs = response.data;
            } catch (error) {
                console.error('Error fetching Packs:', error);
            }
        },
        async deletePack(packID) {
            try {
                await axios.delete(`/admin/packs/${packID}`); // Corrected variable name
                this.packs = this.packs.filter(pack => pack.idPack !== packID);
            } catch (error) {
                console.error('Error deleting packs:', error);
            }
        },
        openUpdateModal(pack) {
            this.selectedPack = pack;
            this.showUpdateModal = true;
        },
        openModal(modalType) {
            if (modalType === 'pack') {
                this.showAddModal = true;
            }
        },
        closeModal(modalId) {
            if (modalId === 'modifier') {
                this.showUpdateModal = false;
            } else if (modalId === 'pack') {
                this.showAddModal = false;
            }
        },
    },
    mounted() {
        this.getPacks();
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
</style>