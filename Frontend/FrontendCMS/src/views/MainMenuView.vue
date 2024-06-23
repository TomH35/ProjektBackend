<template>
  <div class="container custom-container">
    <div class="row">
      <div class="col-sm-6">
        <!-- Card 1 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/add-g273330623_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Stage Manager</h5>
                <router-link :to="{ name: 'StageManager' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <!-- Card 2 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/add-g273330623_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Sponsor Manager</h5>
                <router-link :to="{ name: 'SponsorManager' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <!-- Card 3 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/add-g273330623_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Speaker Manager</h5>
                <router-link :to="{ name: 'SpeakerManager' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <!-- Card 4 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/add-g273330623_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Gallery Manager</h5>
                <router-link :to="{ name: 'GalleryManager' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <!-- Card 5 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/add-g273330623_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">About Us Manager</h5>
                <router-link :to="{ name: 'AboutUsManager' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <!-- Card 6 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/add-g273330623_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Website editor</h5>
                <router-link :to="{ name: 'WebsiteCreateView' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center mt-3 mb-5">
      <button @click="handleLogout" class="btn custom-button-color">Logout</button>
    </div>
  </div>
</template>

<script>
import { useLoginStore } from '../stores/loginStore';
import { useRouter } from 'vue-router';

export default {
  methods: {
    handleLogout() {
      const loginStore = useLoginStore();
      const token = loginStore.getToken;

      fetch('./laravel/public/api/auth/logout', {
        method: 'POST',
        headers: {
          'Authorization': `bearer ${token}`,
        },
      })
        .then(response => response.json())
        .then(data => {
          console.log(data);
          loginStore.clearToken();
          const router = this.$router;
          router.push('/admin-login');
        })
        .catch((error) => {
          console.error('Error:', error);
        });
    }
  }
};
</script>


