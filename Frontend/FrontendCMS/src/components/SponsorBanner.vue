<template>
  <div class="sponsor-banner">
    <div class="container">
      <h2 class="banner-title">Sponsors</h2>
      <div class="sponsors-list">
        <div v-for="sponsor in sponsors" :key="sponsor.id" class="sponsor-card" @click="redirectToLink(sponsor.link)">
          <img :src="sponsor.previewImage || getImagePath(sponsor.image_path)" v-if="sponsor.previewImage || sponsor.image_path" alt="Image preview" class="sponsor-image" />
          <div class="sponsor-info">
            <h3 class="sponsor-name">{{ sponsor.name }}</h3>
            <p class="sponsor-description">{{ sponsor.description }}</p>
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
      sponsors: [],
    };
  },
  created() {
    this.fetchSponsors();
  },
  methods: {
    getImagePath(imagePath) {
      return `./laravel/public/${imagePath}`;
    },
    fetchSponsors() {
      fetch('./laravel/public/api/SponsorRead', {
        method: 'GET',
      })
      .then(response => response.json())
      .then(data => {
        this.sponsors = data.sponsors;
      })
      .catch(error => {
        console.error('Error fetching sponsors:', error);
      });
    },
    redirectToLink(link) {
      if (link) {
        window.open(link, '_blank');
      }
    }
  },
};
</script>

<style scoped>
.sponsor-banner {
  background-color: #f9f9f9;
  padding: 20px 0;
}

.container {
  width: 90%;
  margin: 0 auto;
}

.banner-title {
  text-align: center;
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.sponsors-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
}

.sponsor-card {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin: 10px;
  overflow: hidden;
  width: 300px;
  padding: 20px;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.sponsor-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.sponsor-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 10px;
}

.sponsor-info {
  padding: 20px;
  text-align: center;
}

.sponsor-name {
  font-size: 1.5rem;
  margin: 10px 0;
}

.sponsor-description {
  font-size: 1rem;
  color: #666;
}
</style>



