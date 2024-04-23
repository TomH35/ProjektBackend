<template>
 
    <Navigation />

      <RouterView /> 

      <Footer /> 

  </template>
  
  <script>
  import { RouterLink, RouterView } from 'vue-router';
  import Navigation from './components/Navigation.vue';
  import Footer from './components/Footer.vue';
  
  export default {
    components: {
      Navigation,
      Footer
    }
  }
  </script>
  
  