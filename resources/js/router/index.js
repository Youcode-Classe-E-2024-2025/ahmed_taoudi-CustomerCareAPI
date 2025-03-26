import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue'
import Auth from '../views/Auth.vue'
import TicketList from '../views/TicketList.vue'

const router = createRouter({
  history: createWebHistory(), 
  routes: [
    { path: '/', component: Home },
    { path: '/connection', component: Auth },
    { path: '/tickets', component: TicketList },

  ],
});

export default router;