<template>
    <div class="container another-custom-container">
      <h1 class="text-center custom-margin-bottom"><strong>Speaker Manager</strong></h1>
      <SpeakerCreate />
      <div class="custom-container">
        <div><h3 class="text-center custom-margin-bottom"><strong>Speakers</strong></h3></div>
        <SpeakerMenu />
      </div>
    </div>


  </template>
  
  <script>
  import SpeakerCreate from '../components/SpeakerCreate.vue';
  import SpeakerMenu from '../components/SpeakerMenu.vue';
  
  export default {
    components: {
      SpeakerCreate,
      SpeakerMenu,
    },
    
  };
  </script>