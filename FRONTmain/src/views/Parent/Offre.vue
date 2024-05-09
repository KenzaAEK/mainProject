<template>
    <section class="package" id="offres">
        <h1><span>Nos</span> Offres</h1>
        <div class="offre">Offre Inventeurs du Futur <span>     valable jusqu'au le 01/04/2024</span></div>
        <p>Plongez vos enfants dans une aventure technologique complète avec notre atelier "Inventeurs du Futur" ! Nous combinons la programmation, la robotique et les échecs pour développer leurs compétences techniques tout en stimulant leur créativité et leur esprit stratégique.</p>
        <div class="box-container">
            <div class="box">
                <div class="image">
                    <img src="@/assets/images/offre1.png" alt="">
                </div>
                <h3>Atelier de Programmation</h3>
                <p> Les enfants peuvent apprendre les bases de la programmation à travers des projets créatifs, comme la création de jeux, d'animations ou d'histoires interactives.</p>
                 <div class="age">Plage d’age : <span>8 ans-12 ans </span></div>
                 <a class="btnn ">programme</a>
            </div>
    
            <div class="box">
                <div class="image">
                    <img src="@/assets/images/offre2.png" alt="">
                </div>
                <h3>Atelier de Fabrication</h3>
                <p>  Les enfants deviennent de véritables créateurs en utilisant des outils de pointe tels que les imprimantes 3D, les découpeuses laser et les kits électroniques pour donner vie à leurs idées !</p>
                 <div class="age">Plage d’age : <span>8 ans-12 ans </span></div>
                 <a class="btnn ">programme</a>
            </div>
    
            <div class="box">
                <div class="image">
                    <img src="@/assets/images/offre3.png" alt="">
                </div>
                <h3>Atelier de robotiques</h3>
                <p>les enfants explorent la technologie en construisant et en programmant des robots, stimulant ainsi leur créativité et leur pensée logique</p>
                 <div class="age">Plage d’age : <span>8 ans-12 ans </span></div>
                 <a class="btnn ">programme</a>
            </div>
        </div>
        <a class="btn1 btn" onclick="my_modal_2.showModal()">Inscrivez votre enfant</a>
                <dialog id="my_modal_2" class="modal">
                    <AjouterOffre/>
                  </dialog>
        
    </section>
    
    
</template>
<script>
import AjouterOffre from './AjouterOffre.vue';

export default {
    name: 'App',
    components: { 
        AjouterOffre
    }
  }
</script>
<style scoped>
.btn1{
    margin-top: 1rem;
    color: #FFFFFF;
    background-color: #A3B18A;
    padding: .5rem .8rem;
    border-radius: 2rem;
    transition: .7s ease;
    margin-left: 34rem;
}
.btn1:hover {
    transform: scale(1.03);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
section{
    padding-top: 8rem;
    background-color: #F6F5F4;
    padding-bottom: 5rem;
}
.package p{
    margin-left: 5rem;
    margin-right: 5rem;
    font-size: 1.1rem;
    font-weight: 600;
}
.package h1{
    font-size: 3rem;
    font-weight: 800;
    margin-top: -8rem;
    color: #A3B18A ;
    text-align: center;
}
.package h1 span{
    color: #2E2E2E;
}
.package .box-container{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(15rem, .6fr));
    gap: 1.5rem;
    margin-left: 5rem;
    margin-right: 5rem;
    margin-bottom: 5rem;
    
}
.package .box-container .box{
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-top: 0.8rem;
    padding: 0rem 0;
    text-align: center;
    border: .1rem solid #F6F5F4;
    transition: .7s ease;
    border-radius: 1.2rem;
    padding-bottom: 1rem;
}
.package .box-container .box .image{
    padding: 0;
    margin: 0;
}
.package .box-container .box .image img{
    height: 23rem;
    width: 55rem;
    border-radius: 1.2rem;
}
.package .box-container .box h3{
    font-size: 1.5rem;
    padding-top: 1rem;
    font-weight: 600;   
}
.package .box-container .box p{
    font-size: 1.1rem;
    font-weight: 400;
    text-align: left;
    margin-left: 1rem;
    margin-right: 1rem;
    height: 9rem;
}
.package .box-container .box .age{
    color: #585858;
    font-size: 1.1rem;
    padding: 1rem 0;
    margin-left: -0.2rem;  
}

.package .box-container .box .age span{
    font-size: 1.55rem;
    color: #A3B18A;
}
.package .box-container .box:hover{
    transform: scale(1.05);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.package .offre{
    font-size: 1.7rem;
    font-weight: 800;
    color: #585858 ;
    text-align: left;
    margin-left: 6rem;
    margin-top: 1rem;
}
.package .offre span{
    font-size: 2.1rem;
    font-weight: 800;
    margin-top: -8rem;
    color: #2f6639 ;
    text-align: center;
}
.btnn{
    color: #FFFFFF;
    background-color: #2E2E2E;
    padding: 0.5rem 1.2rem;
    border-radius: 5rem;
    transition: .7s ease;
    cursor: pointer;
}
.btnn:hover{
    color: #2E2E2E;
    background-color: #A3B18A;
    transform: scale(1.05);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>