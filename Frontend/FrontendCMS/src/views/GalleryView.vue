<template>
    <div>
      <h1>{{ gallery.year }} - {{ gallery.category }}</h1>
      <div v-for="image in gallery.images" :key="image.id">
        <img :src="image.file_path" alt="Gallery Image" width="200" />
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        gallery: null
      };
    },
    async created() {
      const galleryId = this.$route.params.id;
      try {
        const response = await this.$axios.get(`/api/galleries/${galleryId}`);
        this.gallery = response.data;
      } catch (error) {
        console.error(error);
      }
    }
  };
  </script>
  