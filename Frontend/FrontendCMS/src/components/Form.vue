<template>
  <form @submit.prevent="logIn">
    <div class="mb-3">
      <label for="loginInput" class="form-label">Email</label>
      <input v-model="email" type="text" class="form-control" id="loginInput">
    </div>
    <div class="mb-3">
      <label for="passwordInput" class="form-label">Heslo</label>
      <div class="input-group">
        <input :type="showPassword ? 'text' : 'password'" v-model="password" class="form-control" id="passwordInput">
        <button type="button" class="btn btn-outline-secondary" @click="togglePasswordVisibility">
          {{ showPassword ? 'Hide' : 'Show' }}
        </button>
      </div>
    </div>
    <div v-if="errorMessage" class="alert alert-danger">
      {{ errorMessage }}
    </div>
    <button type="submit" class="btn custom-button-color">Login</button>
    <router-link to="/admin-registration" class="ms-3">
      <button type="button" class="btn custom-button-color">Register</button>
    </router-link>
  </form>
</template>

<script>
export default {
  props: {
    errorMessage: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      email: '',
      password: '',
      showPassword: false
    };
  },
  methods: {
    logIn() {
      this.$emit('logIn', this.email, this.password);
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    }
  },
  watch: {
    errorMessage(newVal) {
      if (newVal) {
        console.log('Error message:', newVal);
      }
    }
  }
};
</script>






