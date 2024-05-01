<template>
    <div class="container custom-container">
        <div class="mb-5">
        <h3><strong>Admin Registration</strong></h3>
        </div>
      <form @submit.prevent="registerAdmin">
        <div class="mb-3">
          <label for="meno" class="form-label">Meno</label>
          <input type="text" class="form-control" id="meno" v-model="admin.meno" required>
        </div>
        <div class="mb-3">
          <label for="priezvisko" class="form-label">Priezvisko</label>
          <input type="text" class="form-control" id="priezvisko" v-model="admin.priezvisko" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" v-model="admin.email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" v-model="admin.password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        admin: {
          meno: '',
          priezvisko: '',
          email: '',
          password: ''
        }
      }
    },
    methods: {
        registerAdmin() {
    // Define the URL where you want to send the POST request
    const url = './laravel/public/api/AdminRegistration';

    // Use fetch to send a POST request
    fetch(url, {
      method: 'POST', // Specify the method
      headers: {
        'Content-Type': 'application/json' // Set the content type to JSON
      },
      body: JSON.stringify(this.admin) // Convert the admin data to a JSON string
    })
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      // Handle the response data here
      console.log(data);
    })
    .catch(error => {
      // Handle any errors here
      console.error('There was an error!', error);
    });
  }
    }
  }
  </script>
  