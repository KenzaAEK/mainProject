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
                                <button @click="openModal('sure')" class="focus:outline-none">
                                    Supprimer
                                </button>
                                <button @click="openUpdateModal(pack)" class="ml-2 focus:outline-none">
                                    Modifier
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
        <div v-if="showDeleteModal" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
            <supprimerPack @closeModal="closeModal('sure')" />
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from 'axios';
import ajouterPacks from './ajouterPacks.vue';
import modifierPack from './modifierPack.vue';
import supprimerPack from './supprimerPack.vue';

export default {
    name: 'packs',
    components: {
        ajouterPacks,
        modifierPack,
        supprimerPack,
    },
    data() {
        return {
            packs: [],
            selectedPack: null,
            showUpdateModal: false,
            showAddModal: false,
            showDeleteModal: false,
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
        openUpdateModal(pack) {
            this.selectedPack = pack;
            this.showUpdateModal = true;
        },
        openModal(modalType) {
            if (modalType === 'pack') {
                this.showAddModal = true;
            } else if (modalType === 'sure') {
                this.showDeleteModal = true;
            }
        },
        closeModal(modalId) {
            if (modalId === 'modifier') {
                this.showUpdateModal = false;
            } else if (modalId === 'pack') {
                this.showAddModal = false;
            } else if (modalId === 'sure') {
                this.showDeleteModal = false;
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