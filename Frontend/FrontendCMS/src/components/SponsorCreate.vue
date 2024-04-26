<template>
    <div class="sponsor-create">
      <h1>Create Sponsor</h1>
  
      <form @submit.prevent="createSponsor" class="form">
        <div class="form-group">
          <label for="name">Name of Sponsor:</label>
          <input id="name" v-model="sponsor.name" type="text" required>
        </div>
  
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea id="description" v-model="sponsor.description" required></textarea>
        </div>
  
        <div class="form-group">
          <label for="link">Sponsor Link:</label>
          <input id="link" v-model="sponsor.link" type="url" required>
        </div>
  
        <div class="form-group">
          <label for="image">Image:</label>
          <input id="image" type="file" @change="handleImageChange($event)" required>
          <img :src="sponsor.previewImage" v-if="sponsor.previewImage" alt="Image preview" class="imag"/>
        </div>
  
        <button type="submit">Submit</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        sponsor: {
          name: '',
          description: '',
          link: '',
          image: null,
          previewImage: null,
        },
      };
    },
    methods: {
      handleImageChange(event) {
        this.sponsor.image = event.target.files[0];
  
        let reader = new FileReader();
        reader.onload = (e) => {
          this.sponsor.previewImage = e.target.result;
        };
        reader.readAsDataURL(this.sponsor.image);
      },
      async createSponsor() {
        try {
          const formData = new FormData();
  
          formData.append('sponsor', JSON.stringify({
            name: this.sponsor.name,
            description: this.sponsor.description,
            link: this.sponsor.link,
          }));
  
          if (this.sponsor.image) {
            formData.append('image', this.sponsor.image);
          }
  
          const response = await fetch('./laravel/public/api/SponsorCreate', {
            method: 'POST',
            body: formData,
          });
  
          if (!response.ok) {
            const data = await response.json();
            alert(data.error);
            throw new Error(`HTTP error! status: ${response.status}`);
          } else {
            alert('Sponsor has been created successfully!');
            this.$emit('sponsorCreated');
          }
        } catch (error) {
          console.error(error);
        }
      },
    },
  };
  </script>
  
  
  <style scoped>
  .sponsor-create {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #f7f7f7;
    border-radius: 5px;
  }

  .sponsor-create h1 {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
  }

  .form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .form-group label {
    font-weight: bold;
    color: #333;
  }

  .form-group input,
  .form-group textarea {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
  }

  .imag {
    width: 200px;
    height: auto;
    margin-top: 10px;
    border-radius: 5px;
  }

  button {
    padding: 10px 20px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }

  button:hover {
    background-color: #0056b3;
  }
</style>

  