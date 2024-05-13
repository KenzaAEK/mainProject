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
          <form @submit.prevent="submitlogin"  class="space-y-4">
            <!-- Your form elements go here -->
            <div>
              <input required placeholder="Adresse e-mail" type="email" id="Email" v-model="email" name="Email" class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
            </div>
            <div class="relative">
              <input required placeholder="Mot de passe" type="password" id="password" v-model="password" name="password" 
                     class="mt-1 p-2 w-full border-b focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
              <button @click="togglePasswordVisibility" type="button" class="absolute inset-y-0 right-0 flex items-center justify-center bg-transparent hover:bg-gray-200 focus:bg-gray-200 rounded-md px-3 py-2">
                <svg v-if="!showPassword1" class="h-6 text-gray-700" fill="none" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                  <path fill="currentColor"
                        d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                      </path>
                </svg>
                <svg v-else class="h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                  <path fill="currentColor"
                        d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                      </path>
                </svg>
              </button>
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
        password: '',
        showPassword1: false,
      }
    },
    methods: {
      togglePasswordVisibility() {
      this.showPassword1 = !this.showPassword1;
      const passwordInput = document.getElementById('password');
      passwordInput.type = this.showPassword1 ? 'text' : 'password';
      },
      async submitlogin()
        {
          const response = await axios.post('/login/', {
          email: this.email,
          password: this.password
        });
        console.log(response.data.data.user.role)
        if(response.data.data.user.role==="1"){
            localStorage.setItem('token', response.data.data.token);
            this.$store.dispatch('user', response.data.data.user)
            this.$router.push('/parent');
        }
            //localStorage.setItem('token', response.data.data.token);
            //this.$router.push('/parent');
            
        }
    }
  }
  </script>
  <style scoped>
  input::placeholder {
    color: rgb(66, 60, 60); /* Change the color to red */
  }
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
  