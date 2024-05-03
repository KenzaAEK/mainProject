<template>
    <div class="flex h-screen">
      <!-- Left Pane -->
      <div class="image left hidden lg:flex items-center justify-center flex-1  text-black">
        <div class="max-w-md text-center">
          <div class="">
            <img src="../assets/images/Login-amico.png" alt="">
        </div>
        </div>
      </div>
      <!-- Right Pane -->
      <div class="w-full  lg:w-1/2 flex items-center justify-center">
        <div class="max-w-md w-full p-6">
          <h1 class="text-3xl  mb-6 conn text-center">Se Connecter</h1> 
          <form @submit.prevent="login"  class="space-y-4">
            <!-- Your form elements go here -->
            <div>
              <input placeholder="Adresse e-mail" type="email" id="Email" v-model="email" name="Email" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
            <div>
              <input placeholder="Mot de passe" type="password" id="password" v-model="password" name="password" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
            <div>
              <button type="submit" class="w-full btt bg-black text-white p-2 rounded-md  focus:outline-none focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-300">Se Connecter</button>
            </div>
          </form>
          <div class="mt-4 text-sm text-gray-600 text-center">
            <p>Vous n'avez pas de compte ? <router-link to="/signup" class="conn hover:underline">S'inscrire maintenant</router-link>
            </p>
          </div>
        </div>
      </div>
    </div> 
  </template>
  <script>
  import axios from 'axios';
  export default {
    name: 'Login',
    data() {
      return {
        email: '',
        password: ''
      }
    },
    methods: {
        async login()
        {
           try {
            await this.$store.dispatch('auth/login', {
              email: this.email,
              password: this.password
            });
            this.$router.push('/');
           } catch (error) {
            console.error('Login failed:', error);
           }
        },
    }
  }
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
  