<template>
  <footer class="p-3 text-white" style="background-color: #656E77;">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <p>COPYRIGHT</p>
        </div>
        <div class="col-sm-6">
          <ul class="custom-list-style">
            <li v-for="(url, page) in footerMenu" :key="page">
              <router-link :to="url">{{ page }}</router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import { useLoginStore } from '../stores/loginStore';

export default {
  data() {
    return {
      footerMenu: {
        
      },
    };
  },
  created() {
    this.fetchEditorPosts();
  },
  methods: {
    fetchEditorPosts() {
      fetch('../laravel/public/api/editorPost')
        .then(response => response.json())
        .then(data => {
          if (data && data.content) {
            data.content.forEach(editorPost => {
 
              if (editorPost.location === 'footer' || editorPost.location === 'both') {
              this.footerMenu[editorPost.name] = `/tab/${editorPost.id}`;
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
.custom-list-style {
  list-style: none;
  padding-left: 0;
}

.custom-list-style li {
  display: inline-block;
  margin-right: 10px;
}

.custom-list-style li a {
  color: white;
  text-decoration: none;
}

.custom-list-style li a:hover {
  text-decoration: underline;
}
</style>
