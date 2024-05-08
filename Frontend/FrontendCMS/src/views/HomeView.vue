<template>
  <main>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="card w-50">
        <div class="card-body">
          <h5 class="card-title text-center">Prihlásiť sa</h5>
          <Form @logIn="adminLogin"></Form>
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
  setup() {
    const loginStore = useLoginStore();
    const router = useRouter();

    const adminLogin = async (email, password) => {
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
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      loginStore.setToken(data.access_token, data.admin_id);
      console.log(loginStore.token);
      router.push('/main-menu');
    };

    return {
      adminLogin,
    };
  },
};
</script>



