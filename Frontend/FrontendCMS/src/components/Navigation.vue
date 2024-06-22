<template>
  <nav class="navbar navbar-expand-sm navbar-dark fixed-top ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="@/assets/logo.png" alt="nCONNECT24" class="banner-logo">
        <span class="custom-navbar-top-color">CMS</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item" v-for="(url, page) in headerMenu" :key="page">
            <router-link :to="url" class="nav-link" @click.native="handleClick(page)">
              <span class="custom-navbar-color">{{ page }}</span>
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { useLoginStore } from '../stores/loginStore';
export default {
  data() {
    return {
      headerMenu: {
        "DOMOV": "/",
        "SPEAKERS": "/speakers",
        "PROGRAM": "/program",
        "PARTNERI": "/partneri",
        "KONTAKT": "/kontakt",
        "REGISTRÁCIA": "/event-registration",
      },
    };
  },
  created() {
    this.fetchEditorPosts();
  },
  methods: {
    handleClick(page) {
      if (page === 'Logout') {
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
          })
          .catch((error) => {
            console.error('Error:', error);
          });
      }
    },
    fetchEditorPosts() {
      fetch('../laravel/public/api/editorPost')
        .then(response => response.json())
        .then(data => {
          if (data && data.content) {
            data.content.forEach(editorPost => {
              if (editorPost.location === 'both' || editorPost.location === 'navbar') {
              this.headerMenu[editorPost.name] = `/tab/${editorPost.id}`;
            }
          
            });
          }
        })
        .catch(error => {
          console.error('Error fetching editor posts:', error);
        });
    },
  },
};
</script>

<style scoped>
.navbar {
  background-color: #656E77; 
}

.custom-navbar-color {
  color: #DDDBDE; 
}

.custom-navbar-top-color {
  color: #ffcc00; 
}

.nav-link:hover {
  background-color: #003e4f; 
}
</style>
