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

        const response = await fetch('../laravel/public/api/about_us', {
          method: 'POST',
          body: formData,
        });

        if (response.ok) {
          this.$router.push({ name: 'AboutUsManager' });
        } else {
          console.error('Failed to create entry:', response.statusText);
        }
      } catch (error) {
        console.error('Failed to create entry:', error);
      }
    },
  },
};
</script>

<style scoped>
.contact-section {
  padding: 40px 0;
}

.contact-info {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 5px;
}

.contact-info h4 {
  margin-bottom: 20px;
  color: #333;
}

.contact-item {
  margin-bottom: 20px;
}

.contact-item img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
}

.contact-item h5 {
  margin: 0 0 5px;
}

.contact-item p {
  margin: 0;
}

.contact-item a {
  color: #007bff;
  text-decoration: none;
}

.contact-item a:hover {
  text-decoration: underline;
}
</style>
