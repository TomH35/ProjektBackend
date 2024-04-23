<template>
    <nav class="navbar navbar-expand-sm navbar-dark fixed-top custom-background">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="" alt="" width="28" height="28" class="d-inline-block align-text-top">
          <span class="custom-navbar-top-color">CMS</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item" v-for="(url, page) in headerMenu" :key="page">
              <router-link :to="url" class="nav-link">
              <span class="custom-navbar-color">{{ page }}</span>
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
</template>
  
<script>
export default {
  data() {
    return {
      headerMenu: {
        "Logout": "/",
        // ...other menu items...
      },
    };
  },
};
</script>
