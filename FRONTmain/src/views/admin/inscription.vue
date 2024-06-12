<template>
    <div class="flex flex-wrap items-center justify-between ">
        <h4 class="mr-10 text-4xl font-bold leading-none md:text-3xl" style="margin-top: 5px;">
            Demande inscription :
        </h4>
    </div>
    <div class="max-w-screen-xl" style="margin-top: 20px; height: 600px; width: 1000px;">
        <div class="bg-white shadow-lg p-6 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prenom</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enfant</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Offre</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pack</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Option de paiement</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>

        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">Jane Doe</td>
            <td class="px-6 py-4 whitespace-nowrap">jane@example.com</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>           
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-selected text-green-800">Active</span>
            </td>
        </tr>
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">John Doe</td>
            <td class="px-6 py-4 whitespace-nowrap">john@example.com</td>
            <td class="px-6 py-4 whitespace-nowrap">User</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
            </td>
        </tr>
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">John Doe</td>
            <td class="px-6 py-4 whitespace-nowrap">john@example.com</td>
            <td class="px-6 py-4 whitespace-nowrap">User</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>
            <td class="px-6 py-4 whitespace-nowrap">Admin</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <button onclick="openModal('status')" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-custom-color custom-hover-text">En cours</button>
            </td>
        </tr>
    </tbody>
</table>        

        </div>
    </div>
    <div id="status" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <status />
    </div>
</template>
<script>

import status from './status.vue'
export default{
    name :'inscription',
    components:{
        status,
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
  .bg-custom-colorrr {
    background-color: #CEDCB6 ;
  }
</style>x

