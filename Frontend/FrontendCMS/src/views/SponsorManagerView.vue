<template>
    <div class="sponsor-manager-view">
      <h1>Sponsor Manager</h1>
      <SponsorCreate />
    </div>
  </template>
  
  <script>
  import SponsorCreate from '../components/SponsorCreate.vue';
  
  export default {
    components: {
      SponsorCreate,
    },
    
  };
  </script>
  
  <style scoped>
  .sponsor-manager-view h1 {
      text-align: center;
  }
  </style>
  