<template>
  <div class="gallery-edit">
    <div class="card">
      <div class="card-body">
        <h2>Edit Gallery</h2>
        <form @submit.prevent="updateGallery" class="form">
          <div class="mb-3">
            <label for="year" class="form-label">Year:</label>
            <input id="year" v-model="gallery.year" type="number" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <input id="category" v-model="gallery.category" type="text" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="existing-images" class="form-label">Existing Images:</label>
            <div v-if="gallery.images.length" class="mt-3">
              <div v-for="(image, index) in gallery.images" :key="index" class="img-preview">
                <img :src="getImagePath(image.file_path)" alt="Gallery Image" class="img-thumbnail mt-2" width="100" />
                <button type="button" class="btn btn-danger btn-sm mt-2" @click="removeExistingImage(index)">Remove</button>
              </div>
            </div>
          </div>
          <div v-for="(image, index) in newImages" :key="index" class="mb-3">
            <label :for="'new-image' + index" class="form-label">New Image {{ index + 1 }}:</label>
            <input :id="'new-image' + index" type="file" class="form-control" @change="event => handleNewImageChange(event, index)">
            <button type="button" class="btn btn-danger btn-sm mt-2" @click="removeNewImage(index)">Remove</button>
          </div>
          <button type="button" class="btn btn-secondary mt-3" @click="addNewImageInput">Add New Image</button>
          <button type="submit" class="btn btn-success mt-3">Update Gallery</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      gallery: {
        year: '',
        category: '',
        images: []
      },
      newImages: [],
      successMessage: '',
      errorMessage: ''
    };
  },
  async created() {
    this.fetchGallery();
  },
  methods: {
    async fetchGallery() {
      try {
        const response = await fetch(`http://localhost/laravel/public/api/galleriesShow/${this.id}`);
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        const data = await response.json();
        this.gallery = data;
      } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
      }
    },
    handleNewImageChange(event, index) {
      const file = event.target.files[0];
      if (file) {
        this.newImages.splice(index, 1, file);
      }
    },
    addNewImageInput() {
      this.newImages.push(null);
    },
    removeNewImage(index) {
      this.newImages.splice(index, 1);
    },
    removeExistingImage(index) {
      this.gallery.images.splice(index, 1);
    },
    getImagePath(path) {
      const formattedPath = `/laravel/storage/app/public/${path.replace('public/', '')}`;
      console.log('Formatted image path:', formattedPath); // Log the formatted image path
      return formattedPath;
    },
    async updateGallery() {
      try {
        const formData = new FormData();
        formData.append('year', this.gallery.year);
        formData.append('category', this.gallery.category);
        this.gallery.images.forEach((image, index) => {
          formData.append(`existing_images[${index}]`, image.id); // Assuming each image has an ID
        });
        this.newImages.forEach((image, index) => {
          if (image) {
            formData.append(`new_images[${index}]`, image);
          }
        });

        const response = await fetch(`http://localhost/laravel/public/api/galleriesUpdate/${this.id}`, {
          method: 'POST',
          body: formData
        });

        if (!response.ok) {
          const errorData = await response.text();
          console.error('Error response:', errorData);
          alert('Error updating gallery. Check console for details.');
          throw new Error(`HTTP error! status: ${response.status}`);
        } else {
          alert('Gallery updated successfully!');
          this.$router.push({ name: 'GalleryManager' });
        }
      } catch (error) {
        console.error('There was a problem with the update operation:', error);
      }
    }
  }
};
</script>

<style>
.img-preview {
  display: inline-block;
  margin-right: 10px;
}
</style>
