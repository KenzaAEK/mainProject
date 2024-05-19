<template>
<div class="border border=black fix" style="width: 300px;">
hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
                    </div>
                    
                    <div>
                        <h1 class="text-4xl font-bold">Atelier Programmation</h1>
                        <p class="py-6">Dans cet atelier interactif et ludique, les enfants découvriront les bases de la programmation à travers des activités amusantes et des jeux. Ils apprendront à créer leurs propres jeux vidéo, animations et histoires interactives, tout en développant des compétences essentielles en résolution de problèmes et en logique.</p>
                        <div class="flex ">
                          <div>
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
                              <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M12 6V12" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M16.24 16.24L12 12" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                          <div class="text-base text-slate-900 font-semibold dark:text-slate-200 ml-2">
                            Horaires d'intervention
                          </div>

                        </div>
                        <div class="bg-gradient-sel  ml-20 px-6 py-4 mb-5 mt-5 " style="border-radius: 20px;width: 210px;">
                            <div  class="items-center justify-between font-semibold ">
                                Lundi de 16:30 à 18:30 
                            </div>
                            <div  class="items-center justify-between font-semibold">
                                Lundi de 16:30 à 18:30 
                            </div>
                        </div>
                    </div>
</template>
<script>
export default {
    name : 'atelierAssocie'
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
  .bg-gradient-sel {
    background-color: #CAD2C5; 
  }</style>