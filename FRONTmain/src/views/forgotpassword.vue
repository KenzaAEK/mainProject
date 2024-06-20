<template>
    <div class="card1 bg-custom-color dark:bg-gray-800 h-screen overflow-hidden flex items-center justify-center">
      <div class="card bg-custom-color lg:w-5/12 md:w-6/12 w-10/12 shadow-lg rounded-xl">
        <div class="shadow shadow-gray-400 absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full p-4 md:p-8">
          <svg height="120" viewBox="0 0 24 24" width="120" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V12c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zm0 2c1.654 0 3 1.346 3 3v3H9V7c0-1.654 1.346-3 3-3zm0 11c.552 0 1 .448 1 1v3c0 .552-.448 1-1 1s-1-.448-1-1v-3c0-.552.448-1 1-1zm0-7c.552 0 1 .448 1 1 0 .384-.304.722-.707.883A1.004 1.004 0 0011 13a1 1 0 001 1 1 1 0 001 1 1 1 0 001-1c0-1.656-1.344-3-3-3a1 1 0 010-2z" fill="#A9A9A9"/>
          </svg>
           
        </div>
        <form @submit.prevent="handleSubmit" class="p-12 md:p-24">
          <h1>Problème de connexion?</h1>
          <p>Entrez votre email et nous vous enverrons un lien pour revenir à votre compte.</p>
          <div class="relative mt-6">
              <input type="email" name="email" id="email" v-model="email" placeholder="Email Address" class="bg-custom-color peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" autocomplete="NA" />
              <label for="email" class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-00 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Email Address</label>
          </div>
          <button class="bg-custom-button-color from-gray-700 to-gray-900 font-medium p-2 md:p-4 text-white uppercase w-full rounded mt-10">Login</button>
        </form>
      </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
  name: 'forgotpassword',
  data() {
    return {
      email: ''
    };
  },
  methods: {
    async handleSubmit() {
      const response = await axios.post('http://127.0.0.1:8000/api/forgot-password', {
        email: this.email
      });
      console.log(response.status)
      if (response.status === 200) {
        alert('Lien de réinitialisation envoyé à votre adresse e-mail. ');
      }
    },
  }
}
</script>

<style scoped>
      .bg-custom-color {
        background-color: #F6F5F4 ;
      }
      .bg-custom-button-color {
        background-color: #A3B18A;
      }
      .card1{
        padding-top: 8rem;
        margin: auto;
      }
      h1 {
        color: #425b17;
        font-weight: 600;
        font-size: 1.8em;
        text-align: center;
        font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
      }
      p {
        text-align: center;
      }
</style>
    
    
    
    