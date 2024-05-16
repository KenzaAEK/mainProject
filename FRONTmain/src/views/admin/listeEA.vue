<template>
<div class="relative top-20 mx-auto shadow-xl rounded-md bg-white" style="margin-left: 100px; margin-right:100px">
    
    <div class="flex flex-col" >
         
    
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
        
            <div class="flex flex-wrap items-center justify-between" style="margin-top: 12px;margin-bottom: 12px;">
                <h2 class="mr-10 ml-10 text-2xl font-bold leading-none md:text-3xl">
                    Liste des eleves :
                </h2>
                
                    <h2 class="mr-10 ml-10   leading-none md:text-l">
                        Encadre par : Animateur
                    </h2>
                    <div class="mr-10">
                        <div class="flex justify-end p-2">
                <button onclick="closeModal('listeEA')" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd">
                        </path>
                    </svg>
                </button>
            </div>
                    </div>
                
        </div>
            <div class="overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-white border-b">
                        <tr>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Nom</th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Prenom</th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Age</th>
                            <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Niveau d'etudes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">Mark</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">Otto</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">@mdo</td>
                        </tr>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">2</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">Jacob</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">Thornton</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">@fat</td>
                        </tr>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">3</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">Larry</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">Wild</td>
                            <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <div class="flex" >
        <div class="bg-gradient-sel  ml-20 px-6 py-4 mb-5 mt-5 " style="border-radius: 20px;">
            <div  class="items-center justify-between font-semibold ">
                Lundi de 16:30 à 18:30 
            </div>
            <div  class="items-center justify-between font-semibold">
                Lundi de 16:30 à 18:30 
            </div>
        </div>
        <div class="px-6 py-4 mb-5 mt-5 " style="margin-left: 500px;">
            <ol class="flex justify-center text-xs font-medium space-x-1">
  <li>
    <a href="/?page=1" class="inline-flex items-center justify-center w-8 h-8 border border-gray-100 rounded">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
      </svg>
    </a>
  </li>

  <li>
    <a href="/?page=1" class="block w-8 h-8 text-center border border-gray-100 rounded leading-8"> 1 </a>
  </li>

  <li class="block w-8 h-8 text-center text-white bg-gradient-sel rounded leading-8">2</li>

  <li>
    <a href="/?page=3" class="block w-8 h-8 text-center border border-gray-100 rounded leading-8"> 3 </a>
  </li>

  <li>
    <a href="/?page=3" class="inline-flex items-center justify-center w-8 h-8 border border-gray-100 rounded">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
      </svg>
    </a>
  </li>
</ol>
        </div>
    </div>
</div>
</template>
<script>
export default{
    name :'listeEA'
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
<style>
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
  .bg-gradient-sel {
    background-color: #CAD2C5; 
  }
 
  .bg-custom-color {
    background-color: #F6F5F4 ;
  }
</style>