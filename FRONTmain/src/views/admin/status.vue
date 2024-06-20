<template>    
    <div v-if="user" id="status" class="relative  mx-auto shadow-xl rounded-md bg-white max-w-md">
      <div class="flex justify-end p-2">
        <button @click="closeModal" type="button"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
      <div class="p-6 pt-0 text-center">
        <div class="w-20 h-20 text-black mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <div style="width: 90px; height: 90px; margin-top: 10px;">
            <img src="@/assets/images/lampe.png" alt="">
          </div>
        </div>
        <h3 class="text-xl font-normal text-gray-500 mt-5 mb-6">Souhaitez-vous approuver cette inscription ?</h3>
        <a @click="accepter" href="#"
          class="text-white bg-gradient-selected  font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2">
          Oui, accepter
        </a>
        <a @click="refuser" href="#"
          class="text-gray-900 bg-white hover:bg-gray-100  border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center"
          data-modal-toggle="delete-user-modal">
          Non, refuser
        </a>
      </div>
    </div>
  </template>
  
  <script>
  import { mapGetters } from 'vuex';
  import axios from 'axios';
  
  export default {
    name: 'status',
    props: ['demande'],
    computed: {
      ...mapGetters(['user']),
    },
    methods: {
      closeModal() {
        this.$emit('close');
      },
      async accepter() {
        try {
          if (!this.demande || !this.demande.id_demande) {
            console.error('Demande or id_demande is undefined.');
            return;
          }
  
          await axios.post(`/admin/approve-demande/${this.demande.id_demande}`, {
            id_demande: this.demande.id_demande,
          });
  
          this.$emit('accepter');
          this.closeModal();
        } catch (error) {
          console.error('Error accepting demande:', error);
        }
      },
      async refuser() {
        try {
          if (!this.demande || !this.demande.id_demande) {
            console.error('Demande or id_demande is undefined.');
            return;
          }
  
          await axios.post(`/admin/reject-demande/${this.demande.id_demande}`, {
            id_demande: this.demande.id_demande,
           
          });
  
          this.$emit('refuser');
          this.closeModal();
        } catch (error) {
          console.error('Error refusing demande:', error);
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
</style>