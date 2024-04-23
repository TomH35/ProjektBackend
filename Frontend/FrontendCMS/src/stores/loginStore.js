// loginStore.js
import { defineStore } from 'pinia';
import { useBeehivesStore } from '../stores/store';
import { jwtDecode } from 'jwt-decode';

export const useLoginStore = defineStore({
  id: 'loginStore',
  state: () => ({
    userAuthorised: false,
    jwt: '',
  }),
  actions: {
    async loginAsGuest() {
      try {
        const response = await fetch('./inc/GuestAuthorization.php');
        const data = await response.json();

        const jwt = jwtDecode<jwt>(data.jwt);

        if (jwt.Authorised) {
          this.userAuthorised = jwt.Authorised;
          this.jwt = data.jwt;
          localStorage.setItem('jwt', data.jwt); // Save the JWT to local storage
          const beehivesStore = useBeehivesStore();
          await beehivesStore.fetchBeehives();
          await beehivesStore.fetchBeehiveTable(); 
          await beehivesStore.fetchDefaultGraphData();
        } else {
          console.error('Failed to decode JWT or JWT did not contain Authorised field');
        }

      } catch (error) {
        console.error('Failed to login as guest:', error);
      }
    },
    checkLoginStatus() {
      const jwt = localStorage.getItem('jwt'); // Get the JWT from local storage
    
      if (jwt) {
        const decodedJwt = jwtDecode<jwt>(jwt);
    
        if (decodedJwt.Authorised) {
          this.userAuthorised = decodedJwt.Authorised;
          this.jwt = jwt;
        }
      }
    },    
    logout() {
      localStorage.removeItem('jwt'); // Remove the JWT from local storage
      this.userAuthorised = false;
      this.jwt = '';
    },
  },
});