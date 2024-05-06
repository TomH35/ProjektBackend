<template>
    <div class="container custom-container">
      <h1 class="text-center custom-margin-bottom">Speaker Manager</h1>
      <SpeakerCreate />
    </div>
  </template>
  
  <script>
  import SpeakerCreate from '../components/SpeakerCreate.vue';
  
  export default {
    components: {
      SpeakerCreate,
    },
    
  };
  </script>