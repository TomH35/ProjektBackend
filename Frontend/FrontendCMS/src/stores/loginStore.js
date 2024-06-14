import { defineStore } from 'pinia';

export const useLoginStore = defineStore({
  id: 'login',
  state: () => ({
    token: null,
    admin_id: null,
  }),
  getters: {
    getToken(state) {
      return state.token;
    },
    getAdminId(state) {
      return state.admin_id;
    },
  },
  actions: {
    setToken(token, admin_id) {
      this.token = token;
      this.admin_id = admin_id;
      localStorage.setItem('token', token);
      localStorage.setItem('admin_id', admin_id);
    },
    clearToken() {
      this.token = null;
      this.admin_id = null;
      localStorage.removeItem('token');
      localStorage.removeItem('admin_id');
    },
    loadTokenFromLocalStorage() {
      const token = localStorage.getItem('token');
      const admin_id = localStorage.getItem('admin_id');
      if (token && admin_id) {
        this.token = token;
        this.admin_id = admin_id;
      }
    },
  },
});



