import "./bootstrap";
import './stl.css'
import router from "./router/index";
import { createApp } from "vue";
import { authStore } from "./authStore";

import App from "./App.vue";

// Check if the user is already logged in
const storedUser = localStorage.getItem("user");
const storedToken = localStorage.getItem("auth_token");
if (storedUser && storedToken) {
  authStore.login(JSON.parse(storedUser), storedToken);
}
createApp(App).use(router).mount("#app");