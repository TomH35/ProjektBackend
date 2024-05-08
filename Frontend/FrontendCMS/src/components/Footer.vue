<template>
    <footer class="p-3 text-white" style="background-color: #000000;">
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
 /* export default {
    data() {
      return {
        footerMenu: {
          "Logout": "/Logout",
        },
      };
    },
  };*/
  </script>