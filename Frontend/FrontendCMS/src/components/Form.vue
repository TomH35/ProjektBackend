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
    <button @click.prevent="emitTest" class="btn custom-button-color">Test</button>
  </form>
</template>

<script>
import { defineComponent, ref } from 'vue';

export default defineComponent({
  setup(_, { emit }) {
    const emitTest = () => {
      emit('test');
    };

    return {
      emitTest,
    };
  },
});
</script>
