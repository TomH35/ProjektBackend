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
        <img :src="entryImageUrl" alt="Current Image" width="100" />
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
  computed: {
    entryImageUrl() {
      return this.entry.image_path ? `/storage/${this.entry.image_path}` : '';
    },
  },
  async created() {
    this.fetchEntry();
  },
  methods: {
    async fetchEntry() {
      try {
        const response = await fetch(`/laravel/public/api/about_us/${this.$route.params.id}`);
        if (response.ok) {
          this.entry = await response.json();
        } else {
          console.error('Failed to fetch entry:', response.statusText);
        }
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

        const response = await fetch(`/laravel/public/api/about_us/${this.$route.params.id}`, {
          method: 'POST',
          body: formData,
        });

        if (response.ok) {
          this.$router.push({ name: 'AboutUsManager' });
        } else {
          console.error('Failed to update entry:', response.statusText);
        }
      } catch (error) {
        console.error('Failed to update entry:', error);
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
