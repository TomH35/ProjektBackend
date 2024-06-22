<template>
 <div class="row">
    <div class="col-md-4" v-for="speaker in speakers" :key="speaker.id">
      <div class="card mb-4">
        <img :src="speaker.image_path" class="card-img-top" alt="Speaker image">
        <div class="card-body">
          <h5 class="card-title">{{ speaker.name }} {{ speaker.surname }}</h5>
          <p class="card-text">{{ speaker.short_description }}</p>
          <div>
            <button class="btn btn-primary me-2" @click="showLongDescription(speaker)">Read more</button>
            <button class="btn btn-danger me-2" @click="deleteSpeaker(speaker.id)">Delete</button>
            <button class="btn btn-warning" @click="editSpeaker(speaker)">Update</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for updating speaker -->
    <div class="modal fade" id="editSpeakerModal" tabindex="-1" aria-labelledby="editSpeakerModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editSpeakerModalLabel">Update Speaker</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateSpeaker">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" v-model="currentSpeaker.name" required>
              </div>
              <div class="mb-3">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" class="form-control" id="surname" v-model="currentSpeaker.surname" required>
              </div>
              <div class="mb-3">
                <label for="short_description" class="form-label">Short Description</label>
                <input type="text" class="form-control" id="short_description" v-model="currentSpeaker.short_description" required>
              </div>
              <div class="mb-3">
                <label for="long_description" class="form-label">Long Description</label>
                <textarea class="form-control" id="long_description" v-model="currentSpeaker.long_description" required></textarea>
              </div>
              <div class="mb-3">
                <label for="social_links" class="form-label">Social Links</label>
                <textarea class="form-control" id="social_links" v-model="currentSpeaker.social_links" required></textarea>
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" @change="onFileChange">
              </div>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal for showing long description -->
    <div class="modal fade" id="longDescriptionModal" tabindex="-1" aria-labelledby="longDescriptionModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="longDescriptionModalLabel">Long Description</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>{{ currentSpeaker.long_description }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
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
      currentSpeaker: {
        id: null,
        name: '',
        surname: '',
        short_description: '',
        long_description: '',
        social_links: '',
        image: null
      },
      newImage: null,
      editSpeakerModal: null,
      longDescriptionModal: null // Add this line
    };
  },
  methods: {
    fetchSpeakers() {
      const loginStore = useLoginStore();
      const token = loginStore.getToken;

      fetch('./laravel/public/api/SpeakerMenu', {
        method: 'GET',
      })
      .then(response => response.json())
      .then(data => {
        this.speakers = data.speakers;
      });
    },
    showLongDescription(speaker) {
      this.currentSpeaker = { ...speaker };
      this.longDescriptionModal = new window.bootstrap.Modal(document.getElementById('longDescriptionModal'));
      this.longDescriptionModal.show();
    },
    async deleteSpeaker(speakerId) {
      try {
        const loginStore = useLoginStore();
        const token = loginStore.getToken;

        const response = await fetch(`./laravel/public/api/auth/SpeakerDelete/${speakerId}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `bearer ${token}`,
          },
        });

        if (!response.ok) {
          const data = await response.json();
          alert(data.error);
          throw new Error(`HTTP error! status: ${response.status}`);
        } else {
          alert('Speaker has been deleted successfully!');
          this.fetchSpeakers();
        }
      } catch (error) {
        console.error(error);
      }
    },
    editSpeaker(speaker) {
      this.currentSpeaker = { ...speaker };
      this.editSpeakerModal = new window.bootstrap.Modal(document.getElementById('editSpeakerModal'));
      this.editSpeakerModal.show();
    },
    onFileChange(e) {
      this.newImage = e.target.files[0];
    },
    async updateSpeaker() {
      try {
        const loginStore = useLoginStore();
        const token = loginStore.getToken;

        const formData = new FormData();
        formData.append('name', this.currentSpeaker.name);
        formData.append('surname', this.currentSpeaker.surname);
        formData.append('short_description', this.currentSpeaker.short_description);
        formData.append('long_description', this.currentSpeaker.long_description);
        formData.append('social_links', this.currentSpeaker.social_links);
        if (this.newImage) {
          formData.append('image', this.newImage);
        }

        const response = await fetch(`./laravel/public/api/auth/SpeakerUpdate/${this.currentSpeaker.id}`, {
          method: 'POST',
          headers: {
            'Authorization': `bearer ${token}`,
          },
          body: formData,
        });

        if (!response.ok) {
          const data = await response.json();
          alert(data.error);
          throw new Error(`HTTP error! status: ${response.status}`);
        } else {
          alert('Speaker has been updated successfully!');
          this.fetchSpeakers();
          this.editSpeakerModal.hide();
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    this.fetchSpeakers();
  },
};
</script>






  