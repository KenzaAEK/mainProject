<template>
    <div v-if="user" class="relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">
        <div class="flex justify-end p-2">
            <button @click="closeModal('pack')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <div class="p-6 pt-0">
            <form @submit.prevent="updatePack" class="space-y-6">
                <div class="text-center">
                    <h1 class="text-3xl font-semibold text-gray-900">Modifier pack</h1>
                </div>
                <div class="relative mt-6">
                    <input v-model="type" type="text" name="type" id="type" placeholder="Nom de Pack" class="peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" autocomplete="off" />
                    <label for="type" class="absolute top-0 left-0 -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Nom de Pack</label>
                </div>
                <div class="relative mt-6">
                    <input v-model="remise" type="number" name="remise" id="remise" placeholder="Remise" class="peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" />
                    <label for="remise" class="absolute top-0 left-0 -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Remise</label>
                </div>
                <div class="relative mt-6">
                    <input v-model="limite" type="date" name="limite" id="limite" placeholder="Limite" class="peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" />
                    <label for="limite" class="absolute top-0 left-0 -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Limite</label>
                </div>
                <div class="flex">
                    <button @click="updatePack"  onclick="closeModal('modifier')" type="submit" class="w-full bg-gradient-selected text-white font-bold py-2 px-4 rounded-lg">
                        Modifier Pack
                    </button>
                    <button type="button" @click="closeModal('modifier')" class="w-full bg-gradient-selected text-white font-bold py-2 px-4 rounded-lg">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from 'axios';

export default {
    name: 'modifierPack',
    props: {
        pack: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            type: this.pack.type, // Initialisez les champs avec les valeurs du pack à modifier
            remise: this.pack.remise, // Assurez-vous que remise est convertie en string pour le v-model
            limite: this.pack.limite,
        }
    },
    computed: {
        ...mapGetters(['user']),
    },
    methods: {
        async updatePack() {
            try {
                const response = await axios.put(`/admin/packs/${this.pack.idPack}`, {
                    type: this.type,
                    remise: parseFloat(this.remise),  // Convertit remise en float si nécessaire
                    limite: this.limite
                });

                console.log('Response from API:', response.data);
                this.$emit('packUpdated'); // Émet un événement vers le composant parent
                this.closeModal('modifier'); // Ferme la modal après la mise à jour réussie
            } catch (error) {
                console.error('Error updating pack:', error);
                if (error.response) {
                    console.error('Server response:', error.response.data);
                }
            }
        },
        closeModal(modalId) {
            this.$emit('closeModal', modalId); // Émet un événement pour fermer la modal
        }
    }
}
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