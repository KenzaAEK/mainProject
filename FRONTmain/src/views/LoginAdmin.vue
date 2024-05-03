<template>
    <div class="card1 bg-custom-color dark:bg-gray-800 h-screen overflow-hidden flex items-center justify-center">
      <div class="card bg-custom-color lg:w-5/12 md:w-6/12 w-10/12 shadow-lg rounded-xl">
        <div class="shadow shadow-gray-400 absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full p-4 md:p-8">
          <svg height="120" viewBox="0 0 20 20" width="120" xmlns="http://www.w3.org/2000/svg">
            <path d="m374 2009c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4m3.758.673c1.366-1.099 2.242-2.783 2.242-4.673 0-3.314-2.686-6-6-6s-6 2.686-6 6c0 1.89.876 3.574 2.242 4.673-3.659 1.375-6.242 4.772-6.242 9.327h2c0-5 3.589-8 8-8s8 3 8 8h2c0-4.555-2.583-7.952-6.242-9.327" fill-rule="evenodd" transform="translate(-364 -1999)"/>
          </svg>
        </div>
        <form @submit.prevent="loginFormSubmit" class="p-12 md:p-24">
          <div class="relative mt-6">
              <input type="email" name="email" id="email" v-model="email" placeholder="Email Address" class="bg-custom-color peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" autocomplete="NA" />
              <label for="email" class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Email Address</label>
          </div>
          <div class="relative mt-6">
              <input type="password" name="password" id="password" v-model="password" placeholder="Password" class="bg-custom-color peer peer mt-1 w-full border-b-2 border-gray-300 px-0 py-1 placeholder:text-transparent focus:border-gray-500 focus:outline-none" />
              <label for="password" class="pointer-events-none absolute top-0 left-0 origin-left -translate-y-1/2 transform text-sm text-gray-800 opacity-75 transition-all duration-100 ease-in-out peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:top-0 peer-focus:pl-0 peer-focus:text-sm peer-focus:text-gray-800">Password</label>
          </div>
          <button class="bg-custom-button-color from-gray-700 to-gray-900 font-medium p-2 md:p-4 text-white uppercase w-full rounded mt-10">Login</button>
        </form>
      </div>
    </div>
</template>
<script>
export default {
  name: 'LoginAdmin',
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async loginFormSubmit() {
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

<style>
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
</style>
    
    
    
    