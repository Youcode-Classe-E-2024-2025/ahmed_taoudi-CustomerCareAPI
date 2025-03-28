<template>
    <header class="sticky top-0 z-10 bg-white dark:bg-gray-900 shadow-sm">
      <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- Branding Section -->
        <div class="flex items-center space-x-2">

          <h1 class="text-xl font-bold text-gray-900 dark:text-white">CustomerCareAPI</h1>
        </div>
  
        <!-- Mobile Menu Button -->
        <button
          class="md:hidden text-gray-900 dark:text-white"
          @click="toggleMobileMenu"
          aria-label="Toggle menu"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            class="h-6 w-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>
  
        <!-- Desktop Nav Menu -->
        <nav class="hidden md:flex space-x-8">
          <router-link
            to="/"
            class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
            >Home
        </router-link>
          <router-link
          v-if="authStore.isLoggedIn"
            to="/tickets"
            class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
            >Tickets
        </router-link>
          <!-- <router-link
           v-if="authStore.isLoggedIn"
            to="/responses"
            class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
            >Responses
        </router-link> -->

          <div  v-if="authStore.isLoggedIn" class="flex items-center space-x-4">
            <span class="text-gray-900 dark:text-white">{{ authStore.userProfile?.name }}</span>
            <button
              @click="logout"
              class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
              aria-label="Logout"
            >Logout
            </button>
          </div>
          <router-link
            v-else
            to="/connection"
            class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
            >Connection
            </router-link>
        </nav>

        <div
          v-if="mobileMenuOpen"
          class="absolute top-16 left-0 right-0 bg-white dark:bg-gray-900 shadow-md md:hidden"
        >
          <nav class="flex flex-col space-y-4 p-4">
            <router-link
             v-if="authStore.isLoggedIn"
              to="/home"
              class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
              >Home</router-link
            >
            
            <router-link
             v-if="authStore.isLoggedIn"
              to="/tickets"
              class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
              >Tickets</router-link
            >
            <router-link
             v-if="authStore.isLoggedIn"
              to="/responses"
              class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
              >Responses</router-link
            >
  
            <!-- auth -->
            <div  v-if="authStore.isLoggedIn" class="flex items-center space-x-4">
              <span class="text-gray-900 dark:text-white">{{ authStore.userProfile?.name }}</span>
              <button
                @click="logout"
                class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
                aria-label="Logout"
              >
                Logout
              </button>
            </div>
            <router-link
            v-else
            to="/connection"
            class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary"
            >Connection
            </router-link>
          </nav>
        </div>
      </div>
    </header>
  </template>
  
<script setup>
import {onMounted, ref  } from 'vue';
import { authStore } from "../authStore.js";
import { useRouter } from 'vue-router';
let mobileMenuOpen = ref(false);

const toggleMobileMenu = ()=>{
    mobileMenuOpen.value = !mobileMenuOpen.value;
};
const router = useRouter();
// Logout Method
const logout = () => {
  authStore.logout(); // Call the logout method from the shared state
  router.push('/connection');
};

</script>


  <style scoped></style>
  