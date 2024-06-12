<template>
  <div class="flex" v-if="user">
    <div class="navbar bg-base-100">
      <div class="flex-1">
        <a class="btn btn-ghost text-xl"> 
          <div class="image" style="width: 130px; height: 30px;">
                <img src="@/assets/images/logobg.png" alt="">
                
              </div></a>
      </div>
      <div class="flex-none gap-2">
        <button class="btn btn-ghost btn-circle">
          <div class="indicator">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="badge badge-xs badge-primary indicator-item"></span>
          </div>
        </button>
        <div class="dropdown dropdown-end">
          <div class="navbar-end">
            <a class="btn1 btn" @click.prevent="logout">Déconnexion</a>
          </div>
        </div>
      </div>
    </div>
    <!-- <profilAnim /> -->
    <div class="bg-custom-color flex max-w-screen-xl mx-auto p-4" style="margin-top: 50px;">
      <div class="bg-custom-color">
        <div class="container mx-auto py-8">
          <div class="grid grid-cols-4 sm:grid-cols-12 gap-6 px-4">
            <div class="bg-white col-span-4 sm:col-span-9" style="border-radius: 10px">
              <atelierAssocie/>
              <!-- <div class="bg-white shadow rounded-lg p-6">
                <div class="hero-content flex-col lg:flex-row">
                  <atelierAssocie/>
                </div>
                <liste/>
              </div>  -->
            </div>
            <profilAnim/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import profilAnim from './profilAnim.vue'
import atelierAssocie from './atelierAssocie.vue'
import { mapGetters } from 'vuex';

export default{
    name :'interfaceAnim',
    components:{
        profilAnim,
        atelierAssocie,
        
    },
    methods:{
      logout(){
        localStorage.removeItem('token');
        this.$store.dispatch('user', null);
        this.$router.push('/');
      }
    },
    computed: {
      ...mapGetters(['user'])
    }
}

</script>
<style scoped>


.btn1{
    color: #FFFFFF;
    background-color: #A3B18A;
    padding: 1rem 1rem;
    border-radius: 1rem;
}
.navbar{
    background-color: #F6F5F4;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: .7s ease;
    position: fixed;
    z-index: 999;
    display: flex;
    
    
}
.navbar a:hover {
    background-color: #A3B18A; /* Change this to the desired hover color */
  }
  .custom-hover-bg {
    background-color: #fff; /* Set default background color */
}

.custom-hover-bg:hover {
    background-image: linear-gradient(to right, #A3B18A, #BECBA5); /* Set gradient background on hover */
    color: #fff; /* Change text color on hover */
}
.custom-hover-text:hover {
    color:#A3B18A ;
}
.custom-hover-text {
    color:#A3B18A ;
}

  .bg-gradient-selected {
    background-color: #A3B18A; 
  }
 
  .bg-custom-color {
    background-color: #F6F5F4 ;
  }
  .bg-gradient-sel {
    background-color: #CAD2C5; 
  }

</style>