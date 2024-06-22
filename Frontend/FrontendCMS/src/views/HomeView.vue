<template>
  <main>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="card w-50">
        <div class="card-body">
          <h5 class="card-title text-center">Prihlásiť sa</h5>
          <Form @logIn="adminLogin" :errorMessage="errorMessage"></Form>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import Form from '../components/Form.vue';
import { useLoginStore } from '../stores/loginStore';
import { useRouter } from 'vue-router';

export default {
  components: {
    Form,
  },
  data() {
    return {
      errorMessage: ''
    };
  },
  methods: {
    async adminLogin(email, password) {
      this.errorMessage = '';

      try {
        const response = await fetch('./laravel/public/api/auth/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            email: email,
            password: password
          })
        });

        if (!response.ok) {
          if (response.status === 401) {
            this.errorMessage = 'The entered email or password is incorrect';
          } else {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return;
        }

        const data = await response.json();
        const loginStore = useLoginStore();
        loginStore.setToken(data.access_token, data.admin_id);
        console.log('Token:', loginStore.token);

        const router = this.$router;
        router.push('/main-menu');
      } catch (error) {
        console.error('There was an error!', error);
        this.errorMessage = 'An unexpected error occurred. Please try again.';
      }
    }
  }
};
</script>








