<template>
    <div class="modal-box w-11/12 max-w-5xl" v-if="user">
        <h3 class="font-bold text-lg">Notifications</h3>
        <h4 v-for="notif in notifications" :key="notif.id" onclick="my_modal_8.showModal()">{{ notif.contenu }} </h4>
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
import { mapGetters } from 'vuex';
import axios from 'axios';

export default {
    name: 'NotifBar',
    components: { 
        devis
    },
    data() {
    return {
        notifications: []
    }
   },
   mounted() {
    this.getNotifications();
   },
    computed: {
      ...mapGetters(['user'])
    },
    methods: {
        async getNotifications() {
        try {
            const response = await axios.get('/notifications');
            this.notifications = response.data.data;
            console.log(response.data.data)
        } catch (error) {
            console.error('Error fetching notifivation:', error);
        }
        }
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