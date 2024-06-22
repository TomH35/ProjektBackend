<template>
    <div :style="bannerStyle" class="banner">
      <div class="container">
        <div class="banner-content">
          <p class="banner-date"></p>
          <h1 class="banner-title">TECH KONFERENCIA PRE ŠTUDENTOV V NITRE</h1>
          <h2 class="banner-subtitle">nCONNECT24</h2>
          <div class="banner-buttons">
            <button @click="goToProgram" class="btn btn-outline-light">PROGRAM KONFERENCIE</button>
            <button @click="goToSpeakers" class="btn btn-outline-light">SPEAKERS</button>
            <button @click="goToRegistration" class="btn btn-outline-light">REGISTRÁCIA</button>
          </div>
          
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import bannerBackground from '@/assets/banner-backround.jpg';
  
  export default {
    data() {
      return {
        bannerStyle: {
          background: `url(${bannerBackground}) no-repeat center center`,
          backgroundSize: 'cover',
          height: '60vh', 
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          color: 'white', 
          textAlign: 'center',
        },
      };
    },
    methods: {
      goToProgram() {
        this.$router.push('/program');
      },
      goToSpeakers() {
        this.$router.push('/speakers');
      },
      goToRegistration() {
        this.$router.push('/event-registration');
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    max-width: 1200px;
    width: 100%;
  }
  .banner-content {
    position: relative;
  }
  .banner-date {
    font-size: 0.8em; 
    margin-bottom: 0.5em;
    color: white; 
  }
  .banner-title {
    font-size: 1.5em; 
    margin-bottom: 0.5em;
    color: white; 
  }
  .banner-subtitle {
    font-size: 2em; 
    margin-bottom: 1em;
    font-weight: bold;
    color: white; 
  }
  .banner-buttons {
    margin-top: 1em;
  }
  .banner-buttons .btn {
    margin: 0 0.5em;
  }
  .banner-logo {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 100px; 
    height: auto;
  }
  </style>
  