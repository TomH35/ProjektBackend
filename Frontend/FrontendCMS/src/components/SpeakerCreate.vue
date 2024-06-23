<template>
  <div class="card">
    <div class="card-body">
      <h2 class="card-title text-center custom-margin-bottom">Create Speaker</h2>
      <form @submit.prevent="createSpeaker">
        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input id="name" v-model="speaker.name" type="text" class="form-control" />
        </div>

        <div class="mb-3">
          <label for="surname" class="form-label">Surname:</label>
          <input id="surname" v-model="speaker.surname" type="text" class="form-control" />
        </div>

        <div class="mb-3">
          <label for="image" class="form-label">Image:</label>
          <input id="image" type="file" class="form-control" @change="onFileChange" />
        </div>

        <div class="mb-3">
          <label for="shortDescription" class="form-label">Short Description:</label>
          <input id="shortDescription" v-model="speaker.shortDescription" type="text" class="form-control" />
        </div>

        <div class="mb-3">
          <label for="longDescription" class="form-label">Long Description:</label>
          <textarea id="longDescription" v-model="speaker.longDescription" class="form-control"></textarea>
        </div>

        <div class="mb-3">
          <label for="socialLinks" class="form-label">Social Media Links:</label>
          <input id="socialLinks" v-model="speaker.socialLinks" type="text" class="form-control" />
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</template>

<script>
import { useLoginStore } from '../stores/loginStore';

export default {
  data() {
    return {
      speaker: {
        name: '',
        surname: '',
        shortDescription: '',
        longDescription: '',
        socialLinks: '',
        image: null,
        previewImage: null,
      },
    };
  },
  methods: {
    onFileChange(event) {
      this.speaker.image = event.target.files[0];

      let reader = new FileReader();
      reader.onload = (e) => {
        this.speaker.previewImage = e.target.result;
      };
      reader.readAsDataURL(this.speaker.image);
    },
    async createSpeaker() {
      try {
        const loginStore = useLoginStore();
        const token = loginStore.getToken;
        const adminId = loginStore.getAdminId;
        console.log(loginStore.admin_id);

        const formData = new FormData();

        formData.append('speaker', JSON.stringify({
          name: this.speaker.name,
          surname: this.speaker.surname,
          shortDescription: this.speaker.shortDescription,
          longDescription: this.speaker.longDescription,
          socialLinks: this.speaker.socialLinks,
        }));

        formData.append('admin_id', adminId);

        if (this.speaker.image) {
          formData.append('image', this.speaker.image);
        }

        const response = await fetch('./laravel/public/api/auth/SpeakerCreate', {
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
          alert('Speaker has been created successfully!');
          this.$emit('speakerCreated');
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>