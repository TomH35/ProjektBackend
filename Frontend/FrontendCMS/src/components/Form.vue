<template>
  <form>
    <div class="mb-3">
      <label for="loginInput" class="form-label">Login</label>
      <input v-model="email" type="text" class="form-control" id="loginInput" placeholder="Zadajte login">
    </div>
    <div class="mb-3">
      <label for="passwordInput" class="form-label">Heslo</label>
      <input v-model="password" type="password" class="form-control" id="passwordInput" placeholder="Zadajte heslo">
    </div>
    <button @click.prevent="logIn" class="btn custom-button-color">Login</button>
    <router-link to="/admin-registration" class="ms-3">
      <button class="btn custom-button-color">Register</button>
    </router-link>
  </form>
</template>

<script>
import { defineComponent, ref } from 'vue';

export default defineComponent({
  setup(_, { emit }) {
    const email = ref('');
    const password = ref('');

    const logIn = () => {
      emit('logIn', email.value, password.value);
    };

    return {
      email,
      password,
      logIn,
    };
  },
});
</script>

