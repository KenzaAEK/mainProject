<template>
    <div class="navbar bg-base-100 fixed top-0 left-0 w-full z-500">
        <div class="navbar-start">
          <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
              <li><a href="#home">Home</a></li>
              <li><a href="#offres">Offres</a></li>
              <li><a href="#about">About Us</a></li>
              <li><a href="#contact">Contact Us</a></li>
            </ul>
          </div>
          <a href="#home" class="btn btn-ghost text-xl">LOGO</a>
        </div>
        <div class="navbar-center hidden lg:flex">
          <ul class="menu menu-horizontal px-1">
            <li><a href="#home">Home</a></li>
            <li><a href="#offres">Offres</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#contact">Contact Us</a></li>
          </ul>
        </div>
        <div class="navbar-end">
            <router-link to="/login" class="btn2 ">Login →</router-link>
            <router-link to="/signup" class="btn1 btn">Sign Up</router-link>
            
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
              
              
        </div>
    </div>
<div class="bd">
    <!--home section starts-->
<section class="home" id="home">

    <div class="row">
        <div class="content">
            <h4>Excellence Technologique: <br> Libérez le Potentiel de Votre Enfant</h4>
            <p>Ready to unlock this opportunity <br> for your child?
            </p>
            <div class="btns">
                <a class="btn2 ">Login →</a>
                <a class="btn1 btn">Sign Up</a>
            </div>
        </div>

        <div class="image">
            <img class="image1" src="../assets/images/image.png" alt="">
            <img class="image2" src="../assets/images/image1.png" alt="">
        </div>
    </div>
    <div class="">
        <img class="image3" src="../assets/images/image3.png" alt="">
        <div class="remise">
            <h3>Des remises jusqu'à 20 % : <br>
                Inscrivez vos enfants dès maintenant !</h3>
            <p> Profitez de nos offres exceptionnelles pour donner à vos  enfants la meilleure expérience éducative possible ! Avec  nos remises allant jusqu'à 20 % sur nos packs sur mesure,  c'est le moment idéal pour inscrire vos enfants.</p>
        </div>
    </div>

</section>
<!--offres section starts-->
<section class="package" id="offres">
    <h1><span>Nos</span> Offres</h1>
    <div class="offre">Offre Inventeurs du Futur <span>     valable jusqu'au le 01/04/2024</span></div>
    <div class="box-container">
        <div class="box">
            <div class="image">
                <img src="../assets/images/offre1.png" alt="">
            </div>
            <h3>Atelier de Programmation</h3>
             <div class="age">Plage d’age : <span>8 ans-12 ans </span></div>
             <a class="btnn ">programme</a>
        </div>

        <div class="box">
            <div class="image">
                <img src="../assets/images/offre2.png" alt="">
            </div>
            <h3>Atelier de Fabrication</h3>
             <div class="age">Plage d’age : <span>8 ans-12 ans </span></div>
             <a class="btnn ">programme</a>
        </div>

        <div class="box">
            <div class="image">
                <img src="../assets/images/offre3.png" alt="">
            </div>
            <h3>Atelier de robotiques</h3>
             <div class="age">Plage d’age : <span>8 ans-12 ans </span></div>
             <a class="btnn ">programme</a>
        </div>
    </div>
    <a class="btnnn ">voir plus</a>
</section>

<!--About us section starts-->
<section class="about" id="about">
    <h1><span>About</span> Us</h1>
    <div class="row">
        <h2 style="line-height: 1.4;">Autonomiser <br> l'avenir de <br> votre enfant  <br>
            <span>Notre plus !</span></h2>
        <div class="image">
            <img src="../assets/images/about1.png" alt="">
        </div>
    
    <div class="content1">
        <div class="p-4 mt-4">
            <div class="container">
              <div class="flex flex-col md:grid grid-cols-12 text-gray-800">
                <div class="flex md:contents">
                  <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                    <div class="h-full w-6 flex items-center justify-center">
                        <div class="h-full w-1 bg-black pointer-events-none"></div>
                    </div>
                    <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-black shadow text-center">
                      <i class="fas fa-check-circle text-white"></i>
                    </div>
                  </div>
                  <div class=" col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full">
                    <h3 class="font-semibold text-lg mb-1">Ateliers Pour Tous les Âges:</h3>
                    <p class="leading-tight text-justify text-gray-800 w-full">
                        Des activités conçues pour les enfants de 6 à 17 ans  adaptées à chaque étape de la croissance.
                    </p>
                  </div>
                </div>
                <div class="flex md:contents">
                  <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                    <div class="h-full w-6 flex items-center justify-center">
                      <div class="h-full w-1 bg-black pointer-events-none"></div>
                    </div>
                    <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-black shadow text-center">
                      <i class="fas fa-check-circle text-white"></i>
                    </div>
                  </div>
                  <div class=" col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full">
                    <h3 class="font-semibold text-lg mb-1">Promotions Imbattables:</h3>
                    <p class="leading-tight text-justify">
                        Des prix avantageux pour une éducation de qualité.
                    </p>
                  </div>
                </div>
                <div class="flex md:contents">
                  <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                    <div class="h-full w-6 flex items-center justify-center">
                      <div class="h-full w-1 bg-black pointer-events-none"></div>
                    </div>
                    <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-black shadow text-center">
                      <i class="fas fa-times-circle text-white"></i>
                    </div>
                  </div>
                  <div class=" col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full">
                    <h3 class="font-semibold text-lg mb-1 text-gray-800">Formations de Premier Ordre:</h3>
                    <p class="leading-tight text-justify">
                        Des programmes conçus pour exceller.
                    </p>
                  </div>
                </div>
                <div class="flex md:contents">
                  <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                    <div class="h-full w-6 flex items-center justify-center">
                      <div class="h-full w-1 bg-black pointer-events-none"></div>
                    </div>
                    <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-black shadow text-center">
                      <i class="fas fa-exclamation-circle text-gray-800"></i>
                    </div>
                  </div>
                  <div class=" col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full">
                    <h3 class="font-semibold text-lg mb-1 text-gray-800">Qualité Garantie:</h3>
                    <p class="leading-tight text-justify">
                        Des ateliers de haute qualité pour tous les enfants quel que soit leur âge.
                    </p>
                  </div>
                  
                </div>
                <div class="flex md:contents">
                    <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                      <div class="h-full w-6 flex items-center justify-center">
                        <div class="h-full w-1 bg-black pointer-events-none"></div>
                      </div>
                      <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-black shadow text-center">
                        <i class="fas fa-exclamation-circle text-gray-800"></i>
                      </div>
                    </div>
                    <div class=" col-start-4 col-end-12 p-4 rounded-xl my-4 mr-auto shadow-md w-full">
                      <h3 class="font-semibold text-lg mb-1 text-gray-800">Offres Spéciales pour Tous: </h3>
                      <p class="leading-tight text-justify">
                        Des promotions attractives pour tous les packs d'inscription.
                      </p>
                    </div>
                    
                  </div>
              </div>
            </div>
          </div>
    </div>
    </div>
     <!--<a class="btnnn" style="margin-left: 29rem;">Restez en contact</a>
   <div class="icons">
        <ul class="flex justify-center mt-5 space-x-5">
            <li>
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </li>
            <li>
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </li>
            <li>
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                        </path>
                    </svg>
                </a>
            </li>
            <li>
                <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </li>
        </ul>
    </div>-->

</section>
<!-- footer section starts-->
<footer class="footer" >

    <section id="contact">
        <div class="share"> 
            <div class="flex items-center gap-6">
                <a class="text-gray-700 hover:text-blue-800" aria-label="Visit TrendyMinds LinkedIn" href="" target="_blank"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-8">
                        <path fill="currentColor"
                            d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z">
                        </path>
                    </svg>
                </a>
                <a class="text-gray-700 hover:text-red-500" aria-label="Visit TrendyMinds YouTube" href="" target="_blank"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-8">
                        <path fill="currentColor"
                            d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z">
                        </path>
                    </svg>
                </a>
                <a class="text-gray-700 hover:text-blue-500" aria-label="Visit TrendyMinds Facebook" href="" target="_blank"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="h-8">
                        <path fill="currentColor"
                            d="m279.14 288 14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                        </path>
                    </svg>
                </a>
                <a class="text-gray-700 hover:text-red-300" aria-label="Visit TrendyMinds Instagram" href="" target="_blank"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-8">
                        <path fill="currentColor"
                            d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                        </path>
                    </svg>
                </a>

            </div>
        </div>
        <div class="share"> 
            <ul class="menu menu-horizontal px-1">
                <li><a href="#home">Home</a></li>
                <li><a>About Us</a></li>
                <li><a href="#offres">Offres</a></li>
                <li><a>Reviews</a></li>
                <li><a>Contact Us</a></li>
              </ul>
        </div>
        <div class="credit">&copy; copyright @ 2023 by <span>mr. ouaail elaoud</span> | all rights reserved!</div>
    </section>
    
</footer>
</div>
</template>
<style scoped>

 
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
.btn1{
    color: #FFFFFF;
    background-color: #A3B18A;
    padding: 1rem 1rem;
    border-radius: 4rem;
}
.btn2{
    cursor: pointer;
}
.btn2:hover{
    
    color: inherit;
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
.navbar .btn2:hover {
  background-color: transparent !important; /* Prevent background color change on hover */
}
.bd{
    background-color: #F6F5F4;
    padding-top: 6rem;

}
section{
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.home{
    margin-top: .1rem;
}

.home .row{
    display: flex;
    align-items: center;
    flex-wrap: reverse;
    gap: 1.5rem;
}

.home .row .content{
    flex: 1 1 40rem;
    text-align: center;
}

.home .row .image{
    flex: 1 1 40rem;

}

.home .row .image  .image1{
    width: 80%;
}
.home .row .image  .image2{
    width: 55%;
    margin-top: -22.5rem;
    margin-left: 14.5rem;
}

.home .row .content h4{
    margin-bottom: 1rem;
    font-size: 4.5rem;
    color: #2E2E2E;
    line-height: 1;
    text-align: left;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

.home .row .content p{
    margin-bottom: 1rem;
    margin-top: 1rem;
    font-size: 1.5rem;
    color: #585858;
    line-height: 1;
    text-align: left;
}

.home .row .content .btns{
    margin-left: -25.5rem;
    margin-top: 1rem;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    font-size: 1.3rem;
}
.image3{
    margin-top: 5rem;
    margin-left: -5rem;
    width: 38%;
}
.remise h3{
    font-size: 2rem;
    color: #2E2E2E;
    text-align: center;
    line-height: 1;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    margin-left: -9rem;
}

.remise p{
    margin-top: 2rem;
    font-size: 1.5rem;
    color: #585858;
    line-height: 1;
    text-align: left;
    margin-left: -5rem;
}
.remise{
    margin-left: 30rem;
    margin-top: -25rem;
    padding-bottom: 20rem;
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
    margin-top: 0.8rem;
    padding: 0rem 0;
    text-align: center;
    border: .1rem solid #F6F5F4;
    transition: .7s ease;
    border-radius: 1.2rem;
    padding-bottom: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
    font-size: 1.3rem;
    font-weight: 800;
    color: #585858 ;
    text-align: left;
    margin-left: 6rem;
    margin-top: 1rem;
}
.package .offre span{
    font-size: 1.8rem;
    font-weight: 800;
    margin-top: -8rem;
    color: #3A5A40 ;
    text-align: center;
}
.btnnn{
    margin-left: 30.8rem;
    color: #FFFFFF;
    background-color: #2E2E2E;
    padding: 1rem 3rem;
    border-radius: 5rem;
    transition: .7s ease;
    cursor: pointer;
}
.btnnn:hover{
    color: #2E2E2E;
    background-color: #A3B18A;
    transform: scale(1.05);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.content1{
    margin-top: -43rem;
    margin-left: 27rem;
    padding-bottom: 7rem;
}
.about h1{
    font-size: 3rem;
    font-weight: 800;
    margin-top: 0rem;
    margin-bottom: 2rem;
    color: #A3B18A ;
    text-align: center;
}
.about h1 span{
    color: #2E2E2E;
}
.about .image{
    margin-top: 3rem;
    margin-bottom: -1rem;
    width: 50%;
}
.about .row h2{
    font-size: 2.9rem;
    font-weight: 800;
    margin-top: 5rem;
    margin-bottom: 2rem;
    color: #2E2E2E ;
}
.about .row h2 span{
    font-size: 1.8rem;
    font-weight: 800;
    color: #3A5A40 ;    
}
.icons{
    margin-top: 2.9rem;
}
.footer{
    background-color: #A3B18A;
}
.share div {
    margin-left: 11.9rem;
}
.share ul{
    margin-left: 3rem;
}
.share ul li{
    
    color: #fff;
    background-color: #2E2E2E;
    margin: .3rem;
    border-radius: 1rem;
    border: .1rem solid #2E2E2E;
    transition: .7s ease;
}
.share ul li:hover{
    transform: scale(1.05);
}
.credit{
    font-size: 1.1rem;
    font-weight: 800;
    color: #2E2E2E;
}
.credit span{
    font-size: 1.4rem;
    font-weight: 800;
    color: #3A5A40 
}
</style>