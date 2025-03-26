import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue'
import Auth from '../views/Auth.vue'
import TicketList from '../views/TicketList.vue'

const router = createRouter({
  history: createWebHistory(), 
  routes: [
    { path: '/', name:'Home', component: Home },
    { path: '/connection', name:'Auth', component: Auth },
    { path: '/tickets',name:'TicketList', component: TicketList },

  ],
});

export default router;