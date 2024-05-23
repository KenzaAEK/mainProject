<template>
    <div class="modal-box flex flex-col gap-3" v-if="user">
      <h3 class="font-bold text-lg">Modifier Enfant</h3>
      <label class="flex items-center gap-2">
        Nom : 
      </label>
      <input type="text" v-model="nom" class="grow input input-bordered flex items-center gap-2" placeholder="Entrez le nom" required />
      <label class="flex items-center gap-2">
        Prénom :
      </label>
      <input type="text" v-model="prenom" class="grow input input-bordered flex items-center gap-2" placeholder="Entrez le prénom" required />
      <label class="flex items-center gap-2">
        Niveau d'études :
      </label>
      <select v-model="niveau" class="grow input input-bordered flex items-center gap-2" name="Niveau d'études" required>
        <option value="" disabled selected>Niveau d'études --</option>
        <option value="primaire">primaire</option>
        <option value="collège">collège</option>
        <option value="secondaire">secondaire</option>
      </select>
      <label class="flex items-center gap-2">
        Date de naissance :
      </label>
      <input type="date" v-model="naissance" class="grow input input-bordered flex items-center gap-2" required />
      <div class="modal-action">
        <form method="dialog" class="inline-flex justify-end gap-4">
          <button @click="updateEnfant" class="btn1 btn btn-info">Modifier</button>
          <button class="btn">Fermer</button>
        </form>
      </div>
    </div>
  </template>
  
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
  </style>
  
  <script>
  import { mapGetters } from 'vuex';
  import axios from 'axios';
  
  export default {
    name: 'UpdateEnfant',
    props: ['enfant'],
    data() {
      return {
        nom: this.enfant ? this.enfant.nom : '',
        prenom: this.enfant ? this.enfant.prenom : '',
        niveau: this.enfant ? this.enfant.niveauEtude : '',
        naissance: this.enfant ? this.enfant.dateNaissance : ''
      }
    },
    watch: {
      enfant(newEnfant) {
        if (newEnfant) {
          this.nom = newEnfant.nom;
          this.prenom = newEnfant.prenom;
          this.niveau = newEnfant.niveauEtude;
          this.naissance = newEnfant.dateNaissance;
        }
      }
    },
    computed: {
      ...mapGetters(['user']),
    },
    methods: {
      async updateEnfant() {
        try {
          await axios.put(`/parent/enfants/${this.enfant.id}`, {
            prenom: this.prenom,
            nom: this.nom,
            dateNaissance: this.naissance,
            niveauEtude: this.niveau,
          });
          this.$emit('enfantUpdated');
        } catch (error) {
          console.error('Error updating child:', error);
        }
      }
    }
  }
  </script>
  