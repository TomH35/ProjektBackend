<template>
    <div :style="bannerStyle" class="about-us-banner">
      <h2>POVEDALI O NÁS</h2>
      <div class="about-us-content">
        <div class="about-us-images">
          <div 
            v-for="person in people" 
            :key="person.id" 
            class="about-us-item" 
            @click="selectPerson(person)"
          >
            <img :src="getImagePath(person.image_path)" :alt="`${person.name}`" class="person-image">
            <p>{{ person.name }}</p>
          </div>
        </div>
        <div v-if="selectedPerson" class="about-us-details">
          <h3>{{ selectedPerson.name }}</h3>
          <p>{{ selectedPerson.short_description }}</p>
          <p>{{ selectedPerson.text }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import bannerBackground from '@/assets/banner-backround.jpg';
  
  export default {
    data() {
      return {
        people: [],
        selectedPerson: null,
        bannerStyle: {
          background: `url(${bannerBackground}) no-repeat center center`,
          backgroundSize: 'cover',
          padding: '20px',
          color: 'white', 
          textAlign: 'center',
        },
      };
    },
    async created() {
      await this.fetchPeople();
      if (this.people.length > 0) {
        this.selectPerson(this.people[0]); 
      }
    },
    methods: {
      async fetchPeople() {
        try {
          const response = await fetch('/laravel/public/api/about_us');
          const data = await response.json();
          this.people = data;
        } catch (error) {
          console.error('Error fetching people:', error);
        }
      },
      getImagePath(path) {
        return `/laravel/storage/app/public/${path}`;
      },
      selectPerson(person) {
        this.selectedPerson = person;
      }
    }
  };
  </script>
  
  <style scoped>
  .about-us-banner {
    display: flex;
    flex-direction: column;
    padding: 20px;
    margin: 0 auto;
    width: 100%; 
  }
  
  .about-us-banner h2 {
    text-align: center;
    color: white;
    margin-bottom: 20px;
  }
  
  .about-us-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
  }
  
  .about-us-images {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    flex-wrap: wrap; 
    width: 80%;
  }
  
  .about-us-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
    cursor: pointer;
    background-color: #004c75;
    color: white;
    margin: 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    font-weight: bold;
    text-align: center;
    width: 150px;
  }
  
  .about-us-item:hover {
    background-color: #006599;
  }
  
  .person-image {
    width: 100%;
    height: auto;
    border-radius: 5px;
    margin-bottom: 10px;
    max-height: 150px; /* Ensuring the image doesn't exceed a certain height */
    object-fit: cover; /* Ensures the image covers the entire container without distortion */
  }
  
  .about-us-details {
    flex: 1;
    padding: 20px;
    border-radius: 5px;
    width: 80%;
    max-width: 1000px;
    min-height: 200px; 
    background-color: white;
    color: #3B373B;
    overflow: auto; 
  }
  
  .about-us-details h3 {
    margin-bottom: 10px;
  }
  
  .about-us-details p {
    margin-bottom: 10px;
  }
  </style>
  