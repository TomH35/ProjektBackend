<template>
    <div>
      <h1>Edit About Us Entry</h1>
      <form @submit.prevent="updateEntry">
        <div>
          <label for="name">Name:</label>
          <input v-model="entry.name" id="name" required />
        </div>
        <div>
          <label for="short_description">Short Description:</label>
          <input v-model="entry.short_description" id="short_description" required />
        </div>
        <div>
          <label for="text">Text:</label>
          <textarea v-model="entry.text" id="text" required></textarea>
        </div>
        <div>
          <label for="current_image">Current Image:</label>
          <img :src="`http://localhost/laravel/storage/${entry.image_path}`" alt="Current Image" width="100" />
        </div>
        <div>
          <label for="image">New Image:</label>
          <input type="file" @change="handleImageChange" />
        </div>
        <button type="submit">Update</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        entry: {
          name: '',
          short_description: '',
          text: '',
          image_path: '',
        },
        newImage: null,
      };
    },
    async created() {
      this.fetchEntry();
    },
    methods: {
      async fetchEntry() {
        try {
          const response = await fetch(`http://localhost/laravel/public/api/about_us/${this.$route.params.id}`);
          this.entry = await response.json();
        } catch (error) {
          console.error('Failed to fetch entry:', error);
        }
      },
      handleImageChange(event) {
        this.newImage = event.target.files[0];
      },
      async updateEntry() {
        try {
          const formData = new FormData();
          formData.append('name', this.entry.name);
          formData.append('short_description', this.entry.short_description);
          formData.append('text', this.entry.text);
          if (this.newImage) {
            formData.append('image', this.newImage);
          }
  
          await fetch(`http://localhost/laravel/public/api/about_us/${this.$route.params.id}`, {
            method: 'POST',
            body: formData,
          });
  
          this.$router.push({ name: 'AboutUsManager' });
        } catch (error) {
          console.error('Failed to update entry:', error);
        }
      },
    },
  };
  </script>
  