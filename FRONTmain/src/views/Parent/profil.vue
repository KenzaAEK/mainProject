<template>
    <section class="container" id="home">
        <div class="box-container">
            <div class="box">
                <div class="image">
                    <img src="@/assets/images/pro2.png" alt="">
                </div>
                <h3>Nom Animateur</h3>
                    <div style="display: flex; align-items: center;">
                        <svg class="h-8 w-8 text-gray-700" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z"/>
                          <rect x="3" y="5" width="18" height="14" rx="2" />
                          <polyline points="3 7 12 13 21 7" />
                        </svg>
                        <span style="margin-left: 17px;">example@example.com</span>
                      </div>
                      <div style="display: flex; align-items: center;">
                        <svg class="h-8 w-8 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span style="margin-left: 17px;">+212 675092736</span>
                      </div>
            </div>
        
            <div class="box">
                <div class="image">
                    <h2 style="margin-left: -30px;">Mes enfants :</h2>
                </div>
                <div class="enfant mx-9"> <!-- Reduced left and right margin from mx-8 to mx-4 -->
                    <div class="flex flex-wrap items-center justify-start gap-3 mt-8 bg-gray-100 rounded-2xl p-2 pr-1 hover:transform hover:scale-105 hover:shadow-md hover:text-gray-800 transition-all duration-300"> <!-- Changed rounded-lg to rounded-2xl for 2rem border radius -->
                        <div class="h-10 w-10">
                            <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                        </div>
                        <div>
                            <div class="text-sm font-medium text-secondary-500">Enfant 1</div>
                            <div class="text-xs text-secondary-400">17 ans</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-start gap-3 mt-4 bg-gray-100 rounded-2xl p-2 pr-1 hover:transform hover:scale-105 hover:shadow-md hover:text-gray-800 transition-all duration-300"> <!-- Changed rounded-lg to rounded-2xl for 2rem border radius -->
                        <div class="h-10 w-10">
                            <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                        </div>
                        <div>
                            <div class="text-sm font-medium text-secondary-500">Enfant 2</div>
                            <div class="text-xs text-secondary-400">9 Ans</div>
                        </div>
                    </div>
                </div>
                <a class="btn1 btn" onclick="my_modal_1.showModal()">Ajouter enfant</a> 
                <dialog id="my_modal_1" class="modal">
                    <AjouterEnfant/>
                  </dialog>  
            </div>   
        
            <div class="box">
                <div class="image">
                    <h2 style="margin-left: -30px;">Mes offres :</h2>
                </div>
                <div class="enfant mx-9"> <!-- Reduced left and right margin from mx-8 to mx-4 -->
                    <div class="flex flex-wrap items-center justify-start gap-3 mt-8 bg-gray-100 rounded-2xl p-2 pr-1 hover:transform hover:scale-105 hover:shadow-md hover:text-gray-800 transition-all duration-300"> <!-- Changed rounded-lg to rounded-2xl for 2rem border radius -->
                        <div class="h-10 w-10">
                            <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="@/assets/images/offre1.png" alt="" />
                        </div>
                        <div>
                            <div class="text-sm font-medium text-secondary-500">offre1</div>
                            <div class="text-xs text-secondary-400">horaire</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-start gap-3 mt-4 bg-gray-100 rounded-2xl p-2 pr-1 hover:transform hover:scale-105 hover:shadow-md hover:text-gray-800 transition-all duration-300"> <!-- Changed rounded-lg to rounded-2xl for 2rem border radius -->
                        <div class="h-10 w-10">
                            <img class="h-full w-full rounded-full object-cover object-center ring ring-white" src="@/assets/images/offre2.png" alt="" />
                        </div>
                        <div>
                            <div class="text-sm font-medium text-secondary-500">offre2</div>
                            <div class="text-xs text-secondary-400">horaire</div>
                        </div>
                    </div>
                </div>
                <a class="btn1 btn" onclick="my_modal_2.showModal()">Ajouter offre</a>
                <dialog id="my_modal_2" class="modal">
                    <AjouterOffre/>
                  </dialog>   
            </div>
        </div>
    </section>
</template>
<style scoped>

.container{
    padding-top: 2rem;
    padding-bottom: 4rem;
    background-color: #F6F5F4;
}

.container .box-container{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(10rem, .6fr));
    gap: -1rem;
    margin-top: 5rem;
    margin-left: 8rem;
    margin-right: 8rem;
    background-color: white;
    border-radius: 1.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.container .box-container .box{
    
    padding: 1rem 1rem;
    text-align: center;
    transition: .7s ease;
}


.container .box-container .box .image{
    padding: 1rem 4rem;    
}

.container .box-container .box .image h2{
    text-align: left;
    font-size: 1.6rem;
    font-weight: bolder;
    margin-bottom: -1rem;
}
.container .box-container .box .image img{
    height: 9rem;
    border-radius: 5rem;

}

.container .box-container .box h3{
    font-size: 2rem;
    font-weight: 600;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    color: black;
    margin-bottom: 1.rem;
}
.container .box-container .box div span{
    font-size: 1.1rem;
    font-weight: 500;
    color: rgb(90, 89, 89);
}
.container .box-container .box p{
    padding-top: 0rem;
}

.container .box-container .box p{
    font-size: var(--p-font);
    color: var(--second-color);
    margin-top: 1.5rem;
    font-weight: 550;
}
.btn1{
    margin-top: 1rem;
    color: #FFFFFF;
    background-color: #A3B18A;
    padding: .5rem .8rem;
    border-radius: 2rem;
    transition: .7s ease;
}
.btn1:hover {
    transform: scale(1.03);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
<script>
import AjouterEnfant from './AjouterEnfant.vue'
import AjouterOffre from './AjouterOffre.vue';

export default {
    name: 'App',
    components: { 
        AjouterEnfant,
        AjouterOffre
    }
  }
</script>