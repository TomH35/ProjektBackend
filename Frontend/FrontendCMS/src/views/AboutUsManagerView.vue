<template>
    <div>
      <h1>About Us Manager</h1>
      <router-link to="/about_us/create">Create New</router-link>
      <div v-if="aboutUs.length === 0">
        <p>No entries available.</p>
      </div>
      <div v-else>
        <div v-for="entry in aboutUs" :key="entry.id">
          <h2>{{ entry.name }}</h2>
          <p>{{ entry.short_description }}</p>
          <img :src="entry.image_path" alt="Image" width="100" />
          <button @click="editEntry(entry.id)">Edit</button>
          <button @click="deleteEntry(entry.id)">Delete</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        aboutUs: [],
      };
    },
    async created() {
      this.fetchEntries();
    },
    methods: {
      async fetchEntries() {
        try {
          const response = await fetch('http://localhost/laravel/public/api/about_us');
          this.aboutUs = await response.json();
        } catch (error) {
          console.error('Failed to fetch entries:', error);
        }
      },
      editEntry(id) {
    this.$router.push({ name: 'AboutUsEdit', params: { id } });
  },
      async deleteEntry(id) {
        if (confirm('Are you sure you want to delete this entry?')) {
          try {
            await fetch(`http://localhost/laravel/public/api/about_us/${id}`, {
              method: 'DELETE',
            });
            this.fetchEntries();
          } catch (error) {
            console.error('Failed to delete entry:', error);
          }
        }
      },
    },
  };
  </script>
  