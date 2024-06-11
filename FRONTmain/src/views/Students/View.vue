<template>
    
  
    <NavbarVue/>
    <br> <br>
    <div class="overflow-x-auto">
        <table class="table">
          <!-- head -->
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Grade</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- row 1 -->
            <tr>
              <th>1</th>
              <td>Ouaail</td>
              <td>A</td>
              <td>2003waelelaouad@gmail.com</td>
              <td>0690782232</td>
              <td><button class="btn">Button</button>  |
                <button class="btn btn-error">Error</button></td>
            </tr>
            <!-- row 3 -->
          </tbody>
        </table>
      </div>
    
    
  </template>
  
  <script>
import NavbarVue from '../Navbar.vue'
import axios from 'axios';

  
  
  export default {
    name: 'App',
    components: { 
        NavbarVue
    },
    data(){
        return{
            students:[]
        }
    },
    mounted(){
        this.getStudent();
    },
    methods: {
        getStudent(){
            axios.get('').then(res=> {
                this.student = res.data
            })
        }
    }
  }
  </script>
  
  <style>
  /* Add any necessary global styles here */
  </style>
  