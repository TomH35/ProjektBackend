<template>
    <div class="container custom-container">
      <h1 class="text-center custom-margin-bottom"><strong>Conference Registration</strong></h1>
      <EventRegistrationForm />
    </div>


  </template>
  
  <script>
  import EventRegistrationForm from '../components/EventRegistrationForm.vue';
  
  export default {
    components: {
        EventRegistrationForm
    },
    
  };
  </script>