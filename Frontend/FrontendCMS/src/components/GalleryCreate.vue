<template>
  <div class="gallery-create">
    <div class="card">
      <div class="card-body">
        <h2>Create Gallery</h2>
        <form @submit.prevent="createGallery" class="form">
          <div class="mb-3">
            <label for="year" class="form-label">Year:</label>
            <input id="year" v-model="gallery.year" type="number" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <input id="category" v-model="gallery.category" type="text" class="form-control" required>
          </div>
          <div v-for="(image, index) in gallery.images" :key="index" class="mb-3">
            <label :for="'image' + (index + 1)" class="form-label">Image {{ index + 1 }}:</label>
            <input :id="'image' + (index + 1)" type="file" class="form-control" @change="handleImageChange(index)">
          </div>
          <button type="button" class="btn btn-danger mt-3" @click="removeImage(index)">Remove</button>
          <button type="button" class="btn btn-secondary mt-3" @click="addImageInput">Add Another Image</button>
          <button type="submit" class="btn btn-success mt-3">Create Gallery</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      gallery: {
        year: '',
        category: '',
        images: [null]
      },
      previewImages: []
    };
  },
  methods: {
    handleImageChange(index) {
      return (event) => {
        const file = event.target.files[0];
        if (file) {
          this.gallery.images[index] = file;
          const reader = new FileReader();
          reader.onload = (e) => {
            this.$set(this.previewImages, index, e.target.result);
          };
          reader.readAsDataURL(file);
        }
      };
    },
    addImageInput() {
      this.gallery.images.push(null);
    },
    removeImage(index) {
      this.gallery.images.splice(index, 1);
      this.previewImages.splice(index, 1);
    },
    async createGallery() {
      try {
        const formData = new FormData();
        formData.append('year', this.gallery.year);
        formData.append('category', this.gallery.category);

        this.gallery.images.forEach((image, index) => {
          if (image) {
            formData.append(`images[${index}]`, image);
          }
        });

        const response = await fetch('http://localhost/laravel/public/api/galleriesCreate', {
          method: 'POST',
          body: formData
        });

        if (!response.ok) {
          const data = await response.json();
          alert(data.error);
          console.error('Error response:', data);
          throw new Error(`HTTP error! status: ${response.status}`);
        } else {
          alert('Gallery has been created successfully!');
          this.$emit('galleryCreated');
        }
      } catch (error) {
        console.error('Fetch error:', error);
        alert('An error occurred while creating the gallery');
      }
    }
  }
};
</script>

<style>
.img-preview {
  display: flex;
  align-items: center;
  margin-top: 10px;
}

.img-preview img {
  margin-right: 10px;
}

.remove-btn {
  margin-left: 10px;
}
</style>
