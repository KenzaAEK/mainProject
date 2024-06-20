
<template>
  <div v-if="user" class="modal-box" style="background-color: #F6F5F4 ;">
    <div class="navbar ">
      <div class="flex-1">
        <a class="btn btn-ghost text-xl">LOGO</a>
      </div>
      <div class="flex-none">
        <ul class="menu menu-horizontal px-1">
          <h4 style="cursor: text;">Devis N°</h4>
        </ul>
      </div>
    </div>
    <div class="modal-action">
      <form method="dialog">
        <div class="overflow-x-auto">
          <div class="recu">
            <h2>Nom de client</h2>
            <h2>num de telephone</h2>
            <h2>email</h2>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>Ateliers</th>
                <th>nombre d’enfants</th>
                <th>Pack inscription</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Cy Ganderton </td>
                <td>Quality Control Specialist</td>
                <td>Blue</td>
              </tr>
              <tr>
                <td>Hart Hagerty</td>
                <td>Desktop Support Technician</td>
                <td>Purple</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="recu1">
          <h2>Total HT  </h2>
          <h2>TVA</h2>
          <h2>Total TTC</h2>
        </div>
        <div class="btns">
          <h4 class="valable">Offre valable jusq’au ..../..../.....</h4>
          <a  class="btn btn-success" style="border-radius: 1.2rem; margin-right:.2rem">accepter</a>
          <a class="btn btn-error" style="margin-right: -18rem;border-radius: 1.2rem;" @click="showRefusalModal">refuser</a>
          <dialog id="my_modal_re" class="modal">
            <Refus/>
          </dialog>
        </div>
        <a class="btn" style="background-color:#3A5A40; border-radius: 1.2rem;margin-right: 17rem;margin-top: 2rem;">Devis PDF</a>
        <button class="btn" style="margin-top:2rem; background-color:black; color:antiquewhite;border-radius: 1.2rem;">Close</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Refus from './Refus.vue';
import { mapGetters } from 'vuex';

export default {
  name: 'Devis',
  props: ['notif'],
  data() {
    return {
      devis: [],
      test: 'tnotif',
      id: this.notif ? this.notif.idNotification : '',
      
    }
  },
  async mounted() {
    await this.getDevis();
  },
  watch: {
      notif(newNotif) {
        if (newNotif) {
          this.id = newNotif.idNotification;
          
        }
      }
    },
  
  components: {
    Refus
  },
  computed: {
    ...mapGetters(['user']),
  },
  methods: {
    async getDevis() {
      console.log('test')
      console.log(this.test)
      console.log(this.notif)
      try {
        const response = await axios.get(`/parent/devis/${this.notif.idNotification}`);
        this.devis = response.data.data;
        this.$emit('devisNotif');
        console.log(response)
      } catch (error) {
        console.error('Error fetching devis:', error);
      }
    },
    showRefusalModal() {
      const modal = this.$el.querySelector('#my_modal_re');
      if (modal) {
        modal.showModal();
      }
    },
    async downloadPDF() {
      try {
        const response = await axios.get('/generate-pdf', {
          responseType: 'blob'
        });

        const blob = new Blob([response.data], { type: 'application/pdf' });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'download.pdf');
        document.body.appendChild(link);
        link.click();

        window.URL.revokeObjectURL(url);
        document.body.removeChild(link);
      } catch (error) {
        console.error('Error downloading PDF:', error);
      }
    }
  }
};
</script>

<style scoped>
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
  background-color: #A3B18A;
  text-align: left;
  width: 8rem;
  border-radius: .5rem;
  margin-left: 20rem;
  margin-bottom: 3rem;
  margin-top: 2rem;
}

.recu {
  padding: 1rem;
  background-color: #eaebe9;
  text-align: left;
  width: 8rem;
  margin-left: 20rem;
  margin-bottom: 1rem;
}
</style>
