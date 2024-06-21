<template>
  <div class="container custom-container">
    <h1>Gallery Manager</h1>
    <router-link to="/galleries/create">Create Gallery</router-link>
    <div v-if="galleries.length === 0">
      <p>No galleries available.</p>
    </div>
    <div v-else>
      <div v-for="gallery in galleries" :key="gallery.id">
        <h2>{{ gallery.year }} - {{ gallery.category }}</h2>
        <div v-for="image in gallery.images" :key="image.id">
          <img :src="image.file_path" alt="Gallery Image" width="200" />
        </div>
        <button @click="editGallery(gallery.id)" class="btn btn-primary">Edit</button>
        <button @click="deleteGallery(gallery.id)" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      galleries: [],
      errorMessage: '',
    };
  },
  async created() {
    this.fetchGalleries();
  },
  methods: {
    async fetchGalleries() {
      try {
        const response = await fetch('http://localhost/laravel/public/api/galleriesRead');
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        this.galleries = data;
      } catch (error) {
        this.errorMessage = 'Failed to load galleries';
        console.error('There was a problem with the fetch operation:', error);
      }
    },
    editGallery(id) {
      this.$router.push({ name: 'GalleryEdit', params: { id } });
    },
    async deleteGallery(id) {
      if (confirm('Are you sure you want to delete this gallery?')) {
        try {
          const response = await fetch(`http://localhost/laravel/public/api/galleriesDestroy/${id}`, {
            method: 'DELETE',
          });
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          alert('Gallery deleted successfully!');
          this.fetchGalleries(); // Refresh the gallery list
        } catch (error) {
          this.errorMessage = 'Failed to delete gallery';
          console.error('There was a problem with the fetch operation:', error);
        }
      }
    },
  },
};
</script>
