import { defineStore } from 'pinia';

export const useLoginStore = defineStore({
  id: 'login',
  state: () => ({
    token: null,
  }),
  getters: {
    getToken(state) {
      // If the token is null, try to get it from local storage
      if (!state.token) {
        state.token = localStorage.getItem('token');
      }
      return state.token;
    },
  },
  actions: {
    setToken(token) {
      this.token = token;
      // You might want to store the token in local storage or a cookie so it persists across page reloads
      localStorage.setItem('token', token);
    },
    clearToken() {
      this.token = null;
      localStorage.removeItem('token');
    },
  },
});
