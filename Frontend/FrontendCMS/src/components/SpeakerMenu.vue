<template>
    <div class="row">
      <div class="col-md-4" v-for="speaker in speakers" :key="speaker.id">
        <div class="card mb-4">
          <img :src="speaker.image_path" class="card-img-top" alt="Speaker image">
          <div class="card-body">
            <h5 class="card-title">{{ speaker.name }} {{ speaker.surname }}</h5>
            <p class="card-text">{{ speaker.short_description }}</p>
            <button class="btn btn-primary" @click="showLongDescription(speaker)">Read more</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { useLoginStore } from '../stores/loginStore';
  export default {
    data() {
      return {
        speakers: [],
      };
    },
    methods: {
        fetchSpeakers() {
        const loginStore = useLoginStore();
        const token = loginStore.getToken;

        fetch('./laravel/public/api/auth/SpeakerMenu', {
            method: 'POST',
            headers: {
                'Authorization': `bearer ${token}`,
            },
        })
        .then(response => response.json())
        .then(data => {
            this.speakers = data.speakers;
        });
    },
      showLongDescription(speaker) {
        alert(speaker.long_description);
      },
    },
    mounted() {
      this.fetchSpeakers();
    },
  };
  </script>
  