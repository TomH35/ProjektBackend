<template>
    <div>
      <h1>Gallery Detail</h1>
      <div v-if="!gallery">
        <p>Loading...</p>
      </div>
      <div v-else>
        <h2>{{ gallery.year }} - {{ gallery.category }}</h2>
        <div v-for="image in gallery.images" :key="image.id">
          <img :src="image.file_path" alt="Gallery Image" width="200" />
        </div>
        <router-link to="/galleries" class="btn btn-primary mt-2">Back to Galleries</router-link>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        gallery: null,
      };
    },
    async created() {
      const galleryId = this.$route.params.id;
      this.fetchGallery(galleryId);
    },
    methods: {
      async fetchGallery(id) {
        try {
          const response = await fetch(`./laravel/public/api/galleries/${id}`);
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          const data = await response.json();
          this.gallery = data;
        } catch (error) {
          console.error('There was a problem with the fetch operation:', error);
        }
      },
    },
  };
  </script>
  