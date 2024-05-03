<template>
    <div class="flex h-screen">
      <!-- Left Pane -->
      <div class="image left hidden lg:flex items-center justify-center flex-1  text-black">
        <div class="max-w-md text-center">
          <div class="">
            <img src="../assets/images/Parents-bro.png" alt="">
        </div>
        </div>
      </div>
      <!-- Right Pane -->
      <div class="w-full  lg:w-1/2 flex items-center justify-center">
        <div class="max-w-md w-full p-6">
          <h1 class="text-3xl  mb-6 conn text-center">S'inscrire</h1> 
          <form @submit.prevent="handleSubmit" enctype="multipart/form-data" class="space-y-4">
            <!-- Your form elements go here -->
            <div>
              <input placeholder="Nom" type="text" id="Nom" v-model="nom" name="Nom" class="mt-1 p-2 w-full border-b  focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
            <div>
              <input placeholder="Prénom" type="text" id="Prénom" v-model="prenom" name="Prénom" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
            <div>
              <input placeholder="Numéro de téléphone" type="text" id="Numero" v-model="numero" name="Numero" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
            <div>
              <input placeholder="Adresse e-mail" type="email" id="Email" v-model="email" name="Email" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
            <div>
              <input placeholder="Fonction" type="text" id="Fonction" v-model="fonction" name="Fonction" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
            <div>
              <input placeholder="Mot de passe" type="password" id="password" v-model="password" name="password" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
            <div>
              <input placeholder="Confirmer votre mot de passe" type="password" id="confirmPassword" v-model="confirmPassword" name="confirmPassword" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
  
            <div>
              <input type="file" id="photo" @change="handleFileUpload" accept="image/*" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
              <small class="text-gray-500">Téléchargez votre photo (formats acceptés : JPG, PNG, etc.)</small>
            </div>
            <div>
              <button type="submit" class="w-full btt bg-black text-white p-2 rounded-md  focus:outline-none focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-300">S'inscrire</button>
            </div>
          </form>
          <div class="mt-4 text-sm text-gray-600 text-center">
            <p>Vous avez déjà un compte? <router-link to="/login" class="conn hover:underline">Connectez-vous ici</router-link>
            </p>
          </div>
        </div>
      </div>
    </div> 
  </template>
  <script>
  import axios from 'axios';
  export default {
    name: 'Register',
    data() {
      return {
        nom: '',
        prenom: '',
        numero: '',
        email: '',
        fonction: '',
        password: '',
        confirmPassword: '',
        photo: null
      }
    },
    methods: {
      handleFileUpload(event) {
        this.photo = event.target.files[0];
      },
      async handleSubmit() {
        // Logique pour soumettre le formulaire
        try{
          if(this.password !== this.confirmPassword) {
            throw new Error('Les mots de passe ne correspondent pas');
          }
          await this.$store.dispatch('auth/register', {
            nom: this.nom,
            prenom: this.prenom,
            numero: this.numero,
            email: this.email,
            fonction: this.fonction,
            password: this.password,
            photo: this.photo,
          });
          this.$router.push('/login');
        } catch (error){
          console.error('Échec de lenregistrement:', error);
        }
      }
    }
  };
  </script>
  <style scoped>
  input[type="text"],
  input[type="email"],
  input[type="file"],
  input[type="password"] {
      background-color: transparent; /* Set background color to transparent */
      border: none; /* Remove the border */
      border-bottom: 1px solid #FFFFFF; /* Add a bottom border */
      outline: none; /* Remove the default focus outline */
  }
  .w-full{
    margin: auto;
    background-color: #F6F5F4;
    padding-bottom: 0%;
  }
  .btt{
    background-color: #A3B18A;
    cursor: pointer;
    transition: .7s ease;
    display: inline-block;
  }
  
  .btt:hover{
  
    transform: scale(1.03);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  .conn{
    color: #A3B18A;
  }
  h1.conn {
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  }
  .image{
    background-color: #A3B18A;
    border-radius: 1rem;
    
  }
  .flex{
    background-color: #F6F5F4;
  }
  </style>
  