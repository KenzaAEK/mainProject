<template>
        <div class="navbar bg-base-100">
            <div class="flex-1">
              <a class="btn btn-ghost text-xl"> LOGO</a>
            </div>
            <div class="navbar-center hidden lg:flex" style="margin-right: 10.5rem;">
              <ul class="menu menu-horizontal px-1">
                <li><a href="#home">Home</a></li>
                <li><a href="#offres">Offres</a></li>
                <li><a href="#contact">Contact Us</a></li>
              </ul>
            </div>
            <div class="flex-none gap-2">
              <div class="form-control">
                <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" />
              </div>
              <button class="btn btn-ghost btn-circle">
                <div class="indicator">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                  <span class="badge badge-xs badge-primary indicator-item"></span>
                </div>
              </button>
              <div class="dropdown dropdown-end">
                <div class="navbar-end">
                    <a class="btn1 btn">Déconnexion</a>
                  </div>
                
              </div>
            </div>
          </div>

</template>
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
</style>