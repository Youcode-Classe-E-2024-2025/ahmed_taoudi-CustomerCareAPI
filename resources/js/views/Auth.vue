<template>
  <div class="max-w-md w-full bg-white dark:bg-gray-900  rounded-xl shadow-lg p-6" >
    <div class="flex justify-between mb-4">
      <button
        :class=" ['w-1/2 py-2 text-center font-semibold text-lg', { 'bg-primary text-white': activeTab === 'login', 'text-primary dark:text-white': activeTab !== 'login' }]"
        @click="activeTab='login'"
      >
          Login
      </button>
      <button
        :class="['w-1/2 py-2 text-center font-semibold text-lg', { 'bg-primary text-white': activeTab === 'register', 'text-primary dark:text-white': activeTab !== 'register' }]"
          @click="activeTab='register'"
      >
          Register
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';


const activeTab = ref('register');
</script>

<style></style>
