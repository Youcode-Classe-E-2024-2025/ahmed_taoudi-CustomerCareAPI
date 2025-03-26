<template>
    <NavBar></NavBar>
    <main>
      <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 flex justify-center items-center">

          <RouterView></RouterView>

      </div>
    </main>
</template>
  
<script setup>
import NavBar from './components/NavBar.vue';

</script>
  
  <style></style>