<template>
  <form>
    <div class="mb-3">
      <label for="loginInput" class="form-label">Login</label>
      <input type="text" class="form-control" id="loginInput" placeholder="Zadajte login">
    </div>
    <div class="mb-3">
      <label for="passwordInput" class="form-label">Heslo</label>
      <input type="password" class="form-control" id="passwordInput" placeholder="Zadajte heslo">
    </div>
    <button @click.prevent="logIn" class="btn custom-button-color">Login</button>
    <router-link to="/AdminRegistration" class="ms-3">
      <button class="btn custom-button-color">Register</button>
    </router-link>
  </form>
</template>

<script>
import { defineComponent, ref } from 'vue';

export default defineComponent({
  setup(_, { emit }) {
    const logIn = () => {
      emit('logIn');
    };

    return {
      logIn,
    };
  },
});
</script>


