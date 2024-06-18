<template>
    <div class="speaker-banner">
      <div class="container">
        <h2 class="banner-title">Speakers</h2>
        <div class="speakers-list">
          <div v-for="speaker in speakers" :key="speaker.id" class="speaker">
            <img :src="`${baseUrl}/laravel/public/storage/${speaker.image_path}`" :alt="`${speaker.name} ${speaker.surname}`" class="speaker-image">
            <div class="speaker-info">
              <h3 class="speaker-name">{{ speaker.name }} {{ speaker.surname }}</h3>
              <p class="speaker-bio">{{ speaker.short_description }}</p>
              <div class="speaker-social-links" v-if="speaker.social_links">
                <!--<a v-for="(link, index) in parseSocialLinks(speaker.social_links)" :key="index" :href="link" target="_blank" class="social-link">{{ link }}</a>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        baseUrl: import.meta.env.VITE_BASE_URL,
        speakers: [],
      };
    },
    created() {
      console.log('Component created');
      this.fetchSpeakers();
    },
    methods: {
      async fetchSpeakers() {
        try {
          console.log('Fetching speakers...');
          const response = await fetch('http://localhost/laravel/public/api/Speakers');
          const data = await response.json();
          console.log('Fetched data:', data);
          
          this.speakers = data;
          console.log('Speakers data assigned to component:', this.speakers);
        } catch (error) {
          console.error('Error fetching speakers:', error);
        }
      },
      parseSocialLinks(links) {
        return links.split(','); 
      }
    },
  };
  </script>
  
  <style scoped>
  .speaker-banner {
    background-color: #f9f9f9;
    padding: 20px;
  }
  .container {
    max-width: 1200px;
    margin: 0 auto;
  }
  .banner-title {
    text-align: center;
    margin-bottom: 20px;
  }
  .speakers-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }
  .speaker {
    width: 250px; 
    height: 350px; 
    margin: 15px;
    text-align: center;
    border: 1px solid #ccc;
    padding: 10px;
    background: #fff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-sizing: border-box; 
  }
  .speaker-image {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    margin: 0 auto; 
  }
  .speaker-info {
    margin-top: 10px;
  }
  .speaker-name {
    font-size: 1.2em;
    margin-bottom: 5px;
  }
  .speaker-bio {
    font-size: 0.9em;
    color: #666;
  }
  .speaker-social-links {
    margin-top: 10px;
  }
  .social-link {
    display: block;
    color: #007bff;
    text-decoration: none;
    margin: 5px 0;
  }
  .social-link:hover {
    text-decoration: underline;
  }
  </style>
  