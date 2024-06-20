<template>
  <div class="speaker-banner">
    <div class="container">
      <h2 class="banner-title">Speakers</h2>
      <div class="speakers-list">
        <div v-for="speaker in speakers" :key="speaker.id" class="speaker-card" @click="toggleDescription(speaker.id)">
          <img :src="speaker.image_path" :alt="`${speaker.name} ${speaker.surname}`" class="speaker-image">
          <div class="speaker-info">
            <h3 class="speaker-name">{{ speaker.name }} {{ speaker.surname }}</h3>
            <p class="speaker-bio">{{ speaker.short_description }}</p>
            <transition name="expand">
              <p v-if="speaker.showDescription" class="long-description">{{ speaker.long_description }}</p>
            </transition>
            <div class="speaker-social-links" v-if="speaker.social_links">
       
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
      speakers: [],
    };
  },
  created() {
    this.fetchSpeakers();
  },
  methods: {
    toggleDescription(speakerId) {
      const speaker = this.speakers.find(s => s.id === speakerId);
      speaker.showDescription = !speaker.showDescription;
    },

    fetchSpeakers() {
      fetch('./laravel/public/api/SpeakerMenu', {
        method: 'GET',
      })
      .then(response => response.json())
      .then(data => {
        this.speakers = data.speakers;
      })
      .catch(error => {
        console.error('Error fetching speakers:', error);
      });
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

.speakers-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
}

.speaker-card {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin: 70px;
  overflow: hidden;
  width: 250px;
  padding: 20px;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.speaker-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.speaker-image {
  width: 150px;
  height: 150px;
  object-fit: cover;
  border-radius: 50%;
  margin: 0 auto;
}

.speaker-info {
  margin-top: 15px;
}

.speaker-name {
  font-size: 1.5rem;
  margin-bottom: 10px;
}

.speaker-bio {
  font-size: 1rem;
  color: #666;
  margin-bottom: 10px;
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

.long-description {
  margin-top: 10px;
  font-size: 1rem;
  color: #333;
}


</style>
