<template>
    <div class="container">
      <div class="row">
      <h1 class="text-center"><strong>Registrácia</strong></h1>
      <EventRegistrationForm />
    </div>
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