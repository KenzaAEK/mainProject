<template>
<div class="flex flex-wrap items-center justify-between ">
            <h2 class="mr-10 text-4xl font-bold leading-none md:text-3xl">
                Ateliers : 
            </h2>
            <button onclick="openModal('modelConfirm')" href="#" class="block pb-1 mt-2 text-base font-black text-black uppercase border-b border-transparent custom-hover-text " >
                Ajouter Atelier ->
            </button>
        </div>
        <div class="max-w-screen-xl" style="margin-top: 20px;">
            <div class="bg-white shadow-lg p-6 rounded-lg">                
                <div class="sm:grid lg:grid-cols-3 sm:grid-cols-2 gap-10">
                    <div class="custom-hover-bg hover:text-white transition duration-300 max-w-sm rounded overflow-hidden shadow-lg">
                        <div class="py-4 px-8">
                            <a href="#">
                                <h4 class="text-lg mb-3 font-semibold">How to be effective at working remotely?</h4>
                            </a>
                            <p class="mb-2 text-sm text-gray-600">Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                            <img src="https://images.pexels.com/photos/461077/pexels-photo-461077.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=1&amp;w=500" class="w-100">
                            <hr class="mt-4">
                            <div class="flex justify-between " style="margin-top: 10px">
                                <span class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">
                        <button onclick="openModal('sure')"><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg></button>
                        <button style="margin-left: 8px;"><svg width="15px" height="15px"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 121.96" style="enable-background:new 0 0 122.88 121.96" xml:space="preserve"><g><path class="st0" d="M107.73,1.31c-0.96-0.89-2.06-1.37-3.29-1.3c-1.23,0-2.33,0.48-3.22,1.44l-7.27,7.54l20.36,19.67l7.33-7.68 c0.89-0.89,1.23-2.06,1.23-3.29c0-1.23-0.48-2.4-1.37-3.22L107.73,1.31L107.73,1.31L107.73,1.31z M8.35,5.09h50.2v13.04H14.58 c-0.42,0-0.81,0.18-1.09,0.46c-0.28,0.28-0.46,0.67-0.46,1.09v87.71c0,0.42,0.18,0.81,0.46,1.09c0.28,0.28,0.67,0.46,1.09,0.46 h87.71c0.42,0,0.81-0.18,1.09-0.46c0.28-0.28,0.46-0.67,0.46-1.09V65.1h13.04v48.51c0,2.31-0.95,4.38-2.46,5.89 c-1.51,1.51-3.61,2.46-5.89,2.46H8.35c-2.32,0-4.38-0.95-5.89-2.46C0.95,118,0,115.89,0,113.61V13.44c0-2.32,0.95-4.38,2.46-5.89 C3.96,6.04,6.07,5.09,8.35,5.09L8.35,5.09z M69.62,75.07c-2.67,0.89-5.42,1.71-8.09,2.61c-2.67,0.89-5.35,1.78-8.09,2.67 c-6.38,2.06-9.87,3.22-10.63,3.43c-0.75,0.21-0.27-2.74,1.3-8.91l5.07-19.4l0.42-0.43l20.02,20.02L69.62,75.07L69.62,75.07 L69.62,75.07z M57.01,47.34L88.44,14.7l20.36,19.6L77.02,67.35L57.01,47.34L57.01,47.34z"/></g></svg>
                        </button>
                    </span>
                                <button class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">Programme</button>
                            </div>
                        </div>
                    </div>
                    <div class="custom-hover-bg hover:text-white transition duration-300 max-w-sm rounded overflow-hidden shadow-lg">
                        <div class="py-4 px-8">
                            <a href="#">
                                <h4 class="text-lg mb-3 font-semibold">How to be effective at working remotely?</h4>
                            </a>
                            <p class="mb-2 text-sm text-gray-600">Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                            <img src="https://images.pexels.com/photos/461077/pexels-photo-461077.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=1&amp;w=500" class="w-100">
                            <hr class="mt-4">
                            <div class="flex justify-between " style="margin-top: 10px">
                                <span class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">
                        <button onclick="openModal('sure')"><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg></button>
                        <button style="margin-left: 8px;"><svg width="15px" height="15px"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 121.96" style="enable-background:new 0 0 122.88 121.96" xml:space="preserve"><g><path class="st0" d="M107.73,1.31c-0.96-0.89-2.06-1.37-3.29-1.3c-1.23,0-2.33,0.48-3.22,1.44l-7.27,7.54l20.36,19.67l7.33-7.68 c0.89-0.89,1.23-2.06,1.23-3.29c0-1.23-0.48-2.4-1.37-3.22L107.73,1.31L107.73,1.31L107.73,1.31z M8.35,5.09h50.2v13.04H14.58 c-0.42,0-0.81,0.18-1.09,0.46c-0.28,0.28-0.46,0.67-0.46,1.09v87.71c0,0.42,0.18,0.81,0.46,1.09c0.28,0.28,0.67,0.46,1.09,0.46 h87.71c0.42,0,0.81-0.18,1.09-0.46c0.28-0.28,0.46-0.67,0.46-1.09V65.1h13.04v48.51c0,2.31-0.95,4.38-2.46,5.89 c-1.51,1.51-3.61,2.46-5.89,2.46H8.35c-2.32,0-4.38-0.95-5.89-2.46C0.95,118,0,115.89,0,113.61V13.44c0-2.32,0.95-4.38,2.46-5.89 C3.96,6.04,6.07,5.09,8.35,5.09L8.35,5.09z M69.62,75.07c-2.67,0.89-5.42,1.71-8.09,2.61c-2.67,0.89-5.35,1.78-8.09,2.67 c-6.38,2.06-9.87,3.22-10.63,3.43c-0.75,0.21-0.27-2.74,1.3-8.91l5.07-19.4l0.42-0.43l20.02,20.02L69.62,75.07L69.62,75.07 L69.62,75.07z M57.01,47.34L88.44,14.7l20.36,19.6L77.02,67.35L57.01,47.34L57.01,47.34z"/></g></svg>
                        </button>
                    </span>
                                <button class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">Programme</button>
                            </div>
                        </div>
                    </div>
                    <div class="custom-hover-bg hover:text-white transition duration-300 max-w-sm rounded overflow-hidden shadow-lg">
                        <div class="py-4 px-8">
                            <a href="#">
                                <h4 class="text-lg mb-3 font-semibold">How to be effective at working remotely?</h4>
                            </a>
                            <p class="mb-2 text-sm text-gray-600">Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                            <img src="https://images.pexels.com/photos/461077/pexels-photo-461077.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=1&amp;w=500" class="w-100">
                            <hr class="mt-4">
                            <div class="flex justify-between " style="margin-top: 10px">
                                <span class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">
                        <button onclick="openModal('sure')"><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg></button>
                        <button style="margin-left: 8px;"><svg width="15px" height="15px"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 121.96" style="enable-background:new 0 0 122.88 121.96" xml:space="preserve"><g><path class="st0" d="M107.73,1.31c-0.96-0.89-2.06-1.37-3.29-1.3c-1.23,0-2.33,0.48-3.22,1.44l-7.27,7.54l20.36,19.67l7.33-7.68 c0.89-0.89,1.23-2.06,1.23-3.29c0-1.23-0.48-2.4-1.37-3.22L107.73,1.31L107.73,1.31L107.73,1.31z M8.35,5.09h50.2v13.04H14.58 c-0.42,0-0.81,0.18-1.09,0.46c-0.28,0.28-0.46,0.67-0.46,1.09v87.71c0,0.42,0.18,0.81,0.46,1.09c0.28,0.28,0.67,0.46,1.09,0.46 h87.71c0.42,0,0.81-0.18,1.09-0.46c0.28-0.28,0.46-0.67,0.46-1.09V65.1h13.04v48.51c0,2.31-0.95,4.38-2.46,5.89 c-1.51,1.51-3.61,2.46-5.89,2.46H8.35c-2.32,0-4.38-0.95-5.89-2.46C0.95,118,0,115.89,0,113.61V13.44c0-2.32,0.95-4.38,2.46-5.89 C3.96,6.04,6.07,5.09,8.35,5.09L8.35,5.09z M69.62,75.07c-2.67,0.89-5.42,1.71-8.09,2.61c-2.67,0.89-5.35,1.78-8.09,2.67 c-6.38,2.06-9.87,3.22-10.63,3.43c-0.75,0.21-0.27-2.74,1.3-8.91l5.07-19.4l0.42-0.43l20.02,20.02L69.62,75.07L69.62,75.07 L69.62,75.07z M57.01,47.34L88.44,14.7l20.36,19.6L77.02,67.35L57.01,47.34L57.01,47.34z"/></g></svg>
                        </button>
                    </span>
                                <button class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">Programme</button>
                            </div>
                        </div>
                    </div>
                    <div class="custom-hover-bg hover:text-white transition duration-300 max-w-sm rounded overflow-hidden shadow-lg">
                        <div class="py-4 px-8">
                            <a href="#">
                                <h4 class="text-lg mb-3 font-semibold">How to be effective at working remotely?</h4>
                            </a>
                            <p class="mb-2 text-sm text-gray-600">Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                            <img src="https://images.pexels.com/photos/461077/pexels-photo-461077.jpeg?auto=compress&amp;cs=tinysrgb&amp;dpr=1&amp;w=500" class="w-100">
                            <hr class="mt-4">
                            <div class="flex justify-between " style="margin-top: 10px">
                                <span class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">
                        <button onclick="openModal('sure')"><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg></button>
                        <button style="margin-left: 8px;"><svg width="15px" height="15px"  version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 121.96" style="enable-background:new 0 0 122.88 121.96" xml:space="preserve"><g><path class="st0" d="M107.73,1.31c-0.96-0.89-2.06-1.37-3.29-1.3c-1.23,0-2.33,0.48-3.22,1.44l-7.27,7.54l20.36,19.67l7.33-7.68 c0.89-0.89,1.23-2.06,1.23-3.29c0-1.23-0.48-2.4-1.37-3.22L107.73,1.31L107.73,1.31L107.73,1.31z M8.35,5.09h50.2v13.04H14.58 c-0.42,0-0.81,0.18-1.09,0.46c-0.28,0.28-0.46,0.67-0.46,1.09v87.71c0,0.42,0.18,0.81,0.46,1.09c0.28,0.28,0.67,0.46,1.09,0.46 h87.71c0.42,0,0.81-0.18,1.09-0.46c0.28-0.28,0.46-0.67,0.46-1.09V65.1h13.04v48.51c0,2.31-0.95,4.38-2.46,5.89 c-1.51,1.51-3.61,2.46-5.89,2.46H8.35c-2.32,0-4.38-0.95-5.89-2.46C0.95,118,0,115.89,0,113.61V13.44c0-2.32,0.95-4.38,2.46-5.89 C3.96,6.04,6.07,5.09,8.35,5.09L8.35,5.09z M69.62,75.07c-2.67,0.89-5.42,1.71-8.09,2.61c-2.67,0.89-5.35,1.78-8.09,2.67 c-6.38,2.06-9.87,3.22-10.63,3.43c-0.75,0.21-0.27-2.74,1.3-8.91l5.07-19.4l0.42-0.43l20.02,20.02L69.62,75.07L69.62,75.07 L69.62,75.07z M57.01,47.34L88.44,14.7l20.36,19.6L77.02,67.35L57.01,47.34L57.01,47.34z"/></g></svg>
                        </button>
                    </span>
                                <button class="block bg-white rounded-full text-black text-xs font-bold px-3 py-2 leading-none flex items-center">Programme</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div id="modelConfirm" class="fixed hidden  inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4 ">
        <createAtelier/>
    </div>

    <div id="sure" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <supprimerAtelier />
    </div>
</template>
<script>
 import { mapGetters } from 'vuex';
import createAtelier from './createAtelier.vue'
import supprimerAtelier from './supprimerAtelier.vue'

export default{
    name:'atelier',
    components:{
        createAtelier,
        supprimerAtelier,
       
    },
    computed: {
      ...mapGetters(['user']),

      }
}
window.openModal = function(modalId) {
        document.getElementById(modalId).style.display = 'block'
        document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden')
    }

    window.closeModal = function(modalId) {
        document.getElementById(modalId).style.display = 'none'
        document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
    }
</script>
<style scoped>
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
</style>