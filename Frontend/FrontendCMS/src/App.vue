<template>
  <div id="app" class="app-container">
    <Navigation />
    <main class="main-content">
      <RouterView />
    </main>
    <Footer />
  </div>
</template>

<script>
import { RouterView } from 'vue-router';
import Navigation from './components/Navigation.vue';
import Footer from './components/Footer.vue';

export default {
  components: {
    Navigation,
    Footer
  }
}
</script>

<style>
html, body, #app {
  height: 100%;
  margin: 0;
}

.app-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding-top: 100px; 
}

footer {
  background-color: #004d60; /* Adjust as necessary */
  color: white;
  text-align: center;
  padding: 1rem 0;
}
</style>
