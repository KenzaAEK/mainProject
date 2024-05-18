<template>
    <div class="modal-box w-11/12 max-w-5xl">
        <h3 class="font-bold text-lg">Notification</h3>
        <h4 onclick="my_modal_8.showModal()">devis : Le nom de l’offre </h4>
        <dialog id="my_modal_8" class="modal" >
            <devis/>
          </dialog>
        <div class="modal-action">
            
            <form method="dialog">
                <!-- if there is a button, it will close the modal -->
                    
                
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
</template>
<script>

import devis from './Devis.vue'
export default {
    name: 'App',
    components: { 
        devis
    }
  }

import { mapGetters } from 'vuex';
export default {
    name: 'NotifBar',
    computed: {
      ...mapGetters(['user'])
    }
}

</script>
<style scoped>
h4{
    color: #FFFFFF;
    background-color: #A3B18A;
    padding: 1rem 1rem;
    border-radius: 1rem;
    text-align: left;
    margin-top: 1rem;
}
</style>