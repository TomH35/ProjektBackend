<template>
  <div class="custom-container">
    <div class="sponsor-create">
      <h1>{{ isEditing ? 'Edit Sponsor' : 'Create Sponsor' }}</h1>

      <form @submit.prevent="submitForm" class="form">
        <div class="form-group">
          <label for="name">Name of Sponsor:</label>
          <input id="name" v-model="sponsor.name" type="text" required />
        </div>

        <div class="form-group">
          <label for="description">Description:</label>
          <textarea id="description" v-model="sponsor.description" required></textarea>
        </div>

        <div class="form-group">
          <label for="link">Sponsor Link:</label>
          <input id="link" v-model="sponsor.link" type="url" required />
        </div>

        <div class="form-group">
          <label for="image">Image:</label>
          <input id="image" type="file" @change="handleImageChange($event)" :required="!isEditing" />
          <img :src="sponsor.previewImage || getImagePath(sponsor.image_path)" v-if="sponsor.previewImage || sponsor.image_path" alt="Image preview" class="imag" />
        </div>

        <button type="submit" class="submit-button">{{ isEditing ? 'Update' : 'Submit' }}</button>
        <button type="button" class="cancel-button" v-if="isEditing" @click="cancelEdit">Cancel</button>
      </form>

      <h2>Sponsors</h2>
      <table class="sponsors-table">
        <thead>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Link</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="sponsor in sponsors" :key="sponsor.id">
            <td><img :src="getImagePath(sponsor.image_path)" alt="Sponsor Image" class="sponsor-image" /></td>
            <td>{{ sponsor.name }}</td>
            <td>{{ sponsor.description }}</td>
            <td><a :href="sponsor.link" target="_blank">{{ sponsor.link }}</a></td>
            <td class="actions-cell">
              <button @click="editSponsor(sponsor)" class="edit-button">Edit</button>
              <button @click="deleteSponsor(sponsor.id)" class="delete-button">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      sponsor: {
        id: null,
        name: "",
        description: "",
        link: "",
        image: null,
        previewImage: null,
        image_path: null,
      },
      sponsors: [],
      isEditing: false,
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
    async submitForm() {
      if (this.isEditing) {
        await this.updateSponsor();
      } else {
        await this.createSponsor();
      }
    },
    async createSponsor() {
      try {
        const formData = new FormData();

        formData.append(
          "sponsor",
          JSON.stringify({
            name: this.sponsor.name,
            description: this.sponsor.description,
            link: this.sponsor.link,
          })
        );

        if (this.sponsor.image) {
          formData.append("image", this.sponsor.image);
        }

        const response = await fetch("./laravel/public/api/SponsorCreate", {
          method: "POST",
          body: formData,
        });

        if (!response.ok) {
          const data = await response.json();
          alert(data.error);
          throw new Error(`HTTP error! status: ${response.status}`);
        } else {
          alert("Sponsor has been created successfully!");
          this.$emit("sponsorCreated");
          this.fetchSponsors(); 
          this.resetForm();
        }
      } catch (error) {
        console.error(error);
      }
    },
    async updateSponsor() {
      try {
        const formData = new FormData();

        formData.append(
          "sponsor",
          JSON.stringify({
            name: this.sponsor.name,
            description: this.sponsor.description,
            link: this.sponsor.link,
          })
        );

        if (this.sponsor.image) {
          formData.append("image", this.sponsor.image);
        }

        const response = await fetch(`./laravel/public/api/SponsorUpdate/${this.sponsor.id}`, {
          method: "POST", 
          body: formData,
        });

        if (!response.ok) {
          const data = await response.json();
          alert(data.error);
          throw new Error(`HTTP error! status: ${response.status}`);
        } else {
          alert("Sponsor has been updated successfully!");
          this.$emit("sponsorUpdated");
          this.fetchSponsors(); 
          this.resetForm();
        }
      } catch (error) {
        console.error(error);
      }
    },
    resetForm() {
      this.sponsor = {
        id: null,
        name: "",
        description: "",
        link: "",
        image: null,
        previewImage: null,
        image_path: null,
      };
      this.isEditing = false;
    },
    cancelEdit() {
      this.resetForm();
    },
    getImagePath(imagePath) {
      return `./laravel/public${imagePath}`;
    },
    editSponsor(sponsor) {
      this.sponsor = { ...sponsor };
      this.isEditing = true;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    async deleteSponsor(sponsorId) {
      try {
        const response = await fetch(`./laravel/public/api/SponsorDelete/${sponsorId}`, {
          method: "DELETE",
        });

        if (!response.ok) {
          const data = await response.json();
          alert(data.error);
          throw new Error(`HTTP error! status: ${response.status}`);
        } else {
          alert("Sponsor has been deleted successfully!");
          this.fetchSponsors(); 
        }
      } catch (error) {
        console.error("Error deleting sponsor:", error);
      }
    },
    async fetchSponsors() {
      try {
        const response = await fetch("./laravel/public/api/SponsorRead");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        this.sponsors = data.sponsors;
      } catch (error) {
        console.error("Error fetching sponsors:", error);
      }
    },
  },
  mounted() {
    this.fetchSponsors(); 
  },
};
</script>

<style scoped>
.custom-container {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  background-color: #f0f2f5;
  min-height: 100vh;
}

.sponsor-create {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  padding: 20px;
  width: 100%;
  max-width: 800px;
}

.sponsor-create h1 {
  text-align: center;
  color: #333;
  font-size: 24px;
  margin-bottom: 20px;
  border-bottom: 2px solid #007bff;
  padding-bottom: 10px;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-weight: bold;
  color: #333;
}

.form-group input,
.form-group textarea {
  padding: 12px;
  border-radius: 4px;
  border: 1px solid #ccc;
  font-size: 16px;
}

.imag {
  width: 100%;
  max-width: 300px;
  height: auto;
  margin-top: 10px;
  border-radius: 5px;
  display: block;
}

.submit-button {
  padding: 12px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
  align-self: center;
}

.submit-button:hover {
  background-color: #0056b3;
}

.cancel-button {
  padding: 12px 20px;
  background-color: #6c757d;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
  align-self: center;
  margin-top: 10px;
}

.cancel-button:hover {
  background-color: #5a6268;
}

.sponsors-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.sponsors-table th,
.sponsors-table td {
  border: 1px solid #ccc;
  padding: 12px;
  text-align: left;
}

.sponsors-table th {
  background-color: #007bff;
  color: #fff;
}

.sponsors-table td {
  background-color: #f9f9f9;
}

.sponsors-table a {
  color: #007bff;
  text-decoration: none;
}

.sponsor-image {
  width: 50px;
  height: auto;
  border-radius: 4px;
}

.actions-cell {
  display: flex;
  gap: 10px;
}

.edit-button,
.delete-button {
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
}

.edit-button {
  background-color: #28a745;
  color: #fff;
}

.edit-button:hover {
  background-color: #218838;
}

.delete-button {
  background-color: #dc3545;
  color: #fff;
}

.delete-button:hover {
  background-color: #c82333;
}
</style>
