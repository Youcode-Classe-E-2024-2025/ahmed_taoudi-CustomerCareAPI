// authStore.js
import { reactive } from 'vue';

export const authStore = reactive({
  isLoggedIn: false,
  userProfile: null,
  token: null,

  login(userProfile, token) {
    this.isLoggedIn = true;
    this.userProfile = userProfile;
    this.token = token;
    localStorage.setItem('user', JSON.stringify(userProfile));
    localStorage.setItem('auth_token', token);
  },

  logout() {
    this.isLoggedIn = false;
    this.userProfile = null;
    this.token = null;
    localStorage.removeItem('user');
    localStorage.removeItem('auth_token');
  },
});