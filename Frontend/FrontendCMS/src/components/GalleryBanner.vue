<template>
    <div class="gallery-banner">
      <h2>Galleries</h2>
      <div class="galleries">
        <div 
          v-for="gallery in galleries" 
          :key="gallery.id" 
          class="gallery-item"
          @click="selectGallery(gallery)"
        >
          <h3>{{ gallery.category }} - {{ gallery.year }}</h3>
        </div>
      </div>
      <div v-if="selectedGallery" class="selected-gallery">
        <h3>{{ selectedGallery.category }} - {{ selectedGallery.year }}</h3>
        <div class="gallery-images">
          <img 
            v-for="image in selectedGallery.images" 
            :key="image.id" 
            :src="getImagePath(image.file_path)" 
            :alt="`Image from ${selectedGallery.category} ${selectedGallery.year}`"
            class="gallery-image"
          />
        </div>
      </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      galleries: [],
      selectedGallery: null,
    };
  },
  async created() {
    await this.fetchGalleries();
  },
  methods: {
    async fetchGalleries() {
      try {
        const response = await fetch('/laravel/public/api/galleriesRead');
        if (response.ok) {
          this.galleries = await response.json();
        } else {
          console.error('Failed to fetch galleries:', response.statusText);
        }
      } catch (error) {
        console.error('Error fetching galleries:', error);
      }
    },
    getImagePath(path) {
        return `/laravel/storage/app/${path}`;
      },
    selectGallery(gallery) {
      this.selectedGallery = gallery;
    }
  },
};
</script>

<style scoped>
.gallery-banner {
  padding: 20px;
  background-color: #DDDDBE; /* Adjust based on your color palette */
  color: #3B373B; /* Adjust based on your color palette */
}

.galleries {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.gallery-item {
  background-color: #CAD4DF; /* Adjust based on your color palette */
  margin: 10px;
  padding: 10px;
  border-radius: 5px;
  text-align: center;
  cursor: pointer;
}

.gallery-item:hover {
  background-color: #656E77; /* Adjust based on your color palette */
}

.selected-gallery {
  margin-top: 20px;
}

.gallery-images {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.gallery-image {
  width: 150px; /* Adjust based on your design */
  height: 150px; /* Adjust based on your design */
  margin: 5px;
  border-radius: 5px;
  object-fit: cover;
}
</style>
