<template>
  <main>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="card w-50">
        <div class="card-body">
          <h5 class="card-title text-center">Prihlásiť sa</h5>
          <Form @test="testFunc"></Form>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import Form from '../components/Form.vue';

export default {
  components: {
    Form,
  },
  setup() {
    const testFunc = async () => {
      const response = await fetch('http://localhost/Backend/laravel/public/api/test-post', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
});


      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      // Do something with the data
    };

    return {
      testFunc,
    };
  },
};
</script>
