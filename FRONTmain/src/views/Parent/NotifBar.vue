<template>
    <div class="modal-box w-11/12 max-w-5xl" v-if="user">
        <h3 class="font-bold text-lg">Notifications</h3>
        <div v-for="notif in notifications" :key="notif.id">
            <h4 @click="openUpdateModal(notif)">{{ notif.contenu }}</h4>
        </div>
        <dialog id="my_modal_8" class="modal">
            
                <div  class="modal-box" style="background-color: #F6F5F4 ;">
                    <div v-if="message" class="accepter">{{ message }}</div>
                    <div v-if="responseMessage">
                        <p class="refuserr">{{ responseMessage }}</p>
                      </div>
                  <div class="navbar ">
                    <div class="flex-1">
                      <a class="btn btn-ghost text-xl">{{ dateDevis }}</a>
                    </div>
                    <div class="flex-none">
                      <ul class="menu menu-horizontal px-1">
                        <h4 style="cursor: text;">Devis N°  {{ devisNmr }}</h4>
                      </ul>
                    </div>
                  </div>
                  <div class="modal-action">
                    <form method="dialog">
                      <div class="overflow-x-auto">
                        <div class="recu">
                          <h2> {{ nomc }}</h2> <br>
                          <h2>{{ emailc }}</h2> <br>
                          <h2>{{ telc }}</h2>
                        </div>
                      </div>
                      <div class="recu1">
                        <h2>Total HT :{{ htc }} DHS  </h2> <br>
                        <h2>TVA :{{ tva }} DHS</h2> <br>
                        <h2>Total TTC :{{ ttc }} DHS</h2>
                      </div>
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Ateliers</th>
                            <th>nombre d’enfants</th>
                            <th>Pack Ateliers</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Chess </td>
                            <td>1</td>
                            <td>Pack Atelier</td>
                          </tr>
                          <tr>
                            <td>Programmation</td>
                            <td>2</td>
                            <td>Pack Ateliers</td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="btns">
                        <h5 class="valable"></h5>
                        <a  class="btn btn-success" style="border-radius: 1.2rem; margin-right:.2rem" @click="acceptDevis(devisNmr)">accepter</a>
                        <a class="btn btn-error" style="margin-right: -18rem;border-radius: 1.2rem;" @click="showRefusalModal" >refuser</a>
                        <dialog id="my_modal_re" class="modal">
                            <div class="modal-box flex flex-col gap-3">
                                <h3 class="font-bold text-lg">Motif de refus</h3>
                                <div v-if="responseMessage">
                                    <p>{{ responseMessage }}</p>
                                  </div>
                                <input type="text" v-model="reason" id="reason" class="grow input input-bordered flex items-center gap-2" />
                                <div class="modal-action">
                                    <form   method="dialog" class="inline-flex justify-end gap-4">
                                        <button type="submit" class="btn1 btn btn-info " @click="rejectDevis(devisNmr)" >Envoyer</button>
                                        <button class="btn">Close</button>
                                
                                    </form>
                                </div>
                            </div>
                          </dialog>
                        <dialog id="my_modal_re" class="modal">
                          <Refus/>
                        </dialog>
                      </div>
                      <a class="btn" style="background-color:#3A5A40; border-radius: 1.2rem;margin-right: 12rem;margin-top: 2rem;" @click="downloadInvoice(devisNmr)">Devis PDF </a>
                      
                      <button class="btn" style="margin-top:2rem; background-color:black; color:antiquewhite;border-radius: 1.2rem;">Close</button>
                    </form>
                  </div>
                </div>
             
        </dialog>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
</template>

<script>
import Refus from './Refus.vue';
import { mapGetters } from 'vuex';
import axios from 'axios';

export default {
    name: 'NotifBar',
    components: { 
        Refus
    },
    data() {
        return {
            notifications: [],
            selectedNotif: null,
            devisNmr:'',
            nomc:'',
            telc:'',
            emailc:'',
            htc:'',
            tva:'',
            ttc:'',
            dateDevis:'',
            message: '',
            reason: '',
            responseMessage: ''
        }
    },
    mounted() {
        this.getNotifications();
        
    },
    computed: {
        ...mapGetters(['user'])
    },
    methods: {
        async rejectDevis(devisNmr) {
      try {
        const response = await axios.post(`http://127.0.0.1:8000/api/parent/reject-devis/${devisNmr}`, {
          reason: this.reason
        }, {
          headers: {
            
          }
        });
        this.responseMessage = response.data.message;
      } catch (error) {
        if (error.response) {
          this.responseMessage = error.response.data.message || 'Erreur lors du rejet du devis';
        } else {
          this.responseMessage = 'Erreur lors de la connexion à l\'API';
        }
      }
    },
        async acceptDevis(devisNmr) {
        try {
            const response = await axios.post(`http://127.0.0.1:8000/api/parent/accept-devis/${devisNmr}`, {}, {
            headers: {
                
            }
            });
            this.message = response.data.message;
        } catch (error) {
            console.error("Il y a eu une erreur!", error);
            this.message = "Erreur lors de l'acceptation du devis.";
        }
        },
        async downloadInvoice(devisNmr) {
       const token = localStorage.getItem('token'); // Utilisez un token valide ici
      // L'identifiant de la facture à télécharger

      try {
        const response = await axios({
          method: 'post',
          url: `http://127.0.0.1:8000/api/parent/facture-download/${devisNmr}`,
          responseType: 'blob', // Important pour traiter la réponse en tant que fichier
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });

        // Créer un lien pour le téléchargement
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `facture_${devisNmr}.pdf`); // Nom du fichier téléchargé
        document.body.appendChild(link);
        link.click();

        // Nettoyer
        window.URL.revokeObjectURL(url);
        document.body.removeChild(link);
      } catch (error) {
        console.error('Erreur lors du téléchargement de la facture:', error);
      }
    },
        async getDevis(id) {
        console.log('test')
        
        try {
            const response = await axios.get(`/parent/devis/${id}`);
            this.devisNmr = response.data.data.devis.idDevis;
            this.nomc = response.data.data.devis.demande_inscription.tuteur.user.nom;
            this.telc = response.data.data.devis.demande_inscription.tuteur.user.tel;
            this.emailc = response.data.data.devis.demande_inscription.tuteur.user.email;
            this.htc = response.data.data.devis.facture.totalHT;
            this.tva = response.data.data.devis.TVA;
            this.ttc = response.data.data.devis.facture.totalTTC;
            this.dateDevis = response.data.data.devis.dateDevis;
            console.log(response.data.data)
        } catch (error) {
            console.error('Error fetching devis:', error);
        }
        },
        async getNotifications() {
            try {
                const response = await axios.get('/notifications');
                this.notifications = response.data.data;
                console.log(response.data.data);
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        },
        openUpdateModal(notif) {
            this.selectedNotif = notif;
            console.log('Selected Notif:', this.selectedNotif);

            const modal = this.$el.querySelector('#my_modal_8');
            if (modal) {
                modal.showModal();
            }
            this.getDevis(this.selectedNotif.idNotification);
        },
        showRefusalModal() {
      const modal = this.$el.querySelector('#my_modal_re');
        if (modal) {
            modal.showModal();
        }
        },
    }
}
</script>

<style scoped>
table {
    margin-bottom: 2rem;
    margin-left: 5rem;
    margin-right: 1rem;
    width: 26rem;
}

.refuserr{
    color: red;
}
.accepter {
    color: #479c0a;
}
h3{
    color: #A3B18A;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    font-size: 1.7rem;
  }
  .btn1{
    background-color: #A3B18A;
    border: #A3B18A;
  }
h4 {
    color: #FFFFFF;
    background-color: #A3B18A;
    padding: 1rem 1rem;
    border-radius: 1rem;
    text-align: left;
    margin-top: 1rem;
}
.valable {
    margin-top: -5rem;
    margin-left: -15rem;
    padding-bottom: 4rem;
  }
  
  .table {
    border-collapse: collapse;
    border: 1px solid rgb(164, 154, 154);
  }
  
  .table th, .table td {
    border: 1px solid rgb(164, 154, 154);
    padding: 8px;
  }
  
  .table th {
    background-color: #A3B18A;
  }
  
  .recu1 {
    padding: 1rem;
    padding-right: 0rem;
    background-color: #A3B18A;
    text-align: left;
    width: 11rem;
    border-radius: .5rem;
    margin-left: 20rem;
    margin-bottom: 3rem;
    margin-top: -7.4rem;
  }
  
  .recu {
    padding: 1rem;
    padding-right: 10rem;
    background-color: #eaebe9;
    text-align: left;
    width: 8rem;
    margin-left: 5rem;
    margin-bottom: 1rem;
  }
</style>
