<template>
    <div>
      <h1>Create About Us Entry</h1>
      <form @submit.prevent="createEntry">
        <div>
          <label for="name">Name:</label>
          <input v-model="name" id="name" required />
        </div>
        <div>
          <label for="short_description">Short Description:</label>
          <input v-model="short_description" id="short_description" required />
        </div>
        <div>
          <label for="text">Text:</label>
          <textarea v-model="text" id="text" required></textarea>
        </div>
        <div>
          <label for="image">Image:</label>
          <input type="file" @change="handleImageChange" required />
        </div>
        <button type="submit">Create</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        name: '',
        short_description: '',
        text: '',
        image: null,
      };
    },
    methods: {
      handleImageChange(event) {
        this.image = event.target.files[0];
      },
      async createEntry() {
        try {
          const formData = new FormData();
          formData.append('name', this.name);
          formData.append('short_description', this.short_description);
          formData.append('text', this.text);
          formData.append('image', this.image);
  
          await fetch('http://localhost/laravel/public/api/about_us', {
            method: 'POST',
            body: formData,
          });
  
          this.$router.push({ name: 'AboutUsManager' });
        } catch (error) {
          console.error('Failed to create entry:', error);
        }
      },
    },
  };
  </script>
  