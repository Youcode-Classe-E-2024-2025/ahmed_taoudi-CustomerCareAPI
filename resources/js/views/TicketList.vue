<template>
  <div class="w-full">
    <!-- Ticket Management Container -->
    <div class="max-w-md w-full mx-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6">
      <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-4">Manage Tickets</h2>

      <!-- Create/Edit Ticket Form -->
      <form @submit.prevent="handleSubmit" class="mt-6 space-y-4">
        <input
          v-model="form.title"
          type="text"
          placeholder="Title"
          required
          class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary"
        />
        <textarea
          v-model="form.description"
          placeholder="Description"
          required
          class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary"
        ></textarea>
        <button
          type="submit"
          class="w-full py-2 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark focus:ring-2 focus:ring-primary transition-colors"
        >
          {{ isEditing ? "Update Ticket" : "Create Ticket" }}
        </button>
      </form>
    </div>

    <!-- Ticket List Section -->
    <div class="mt-8">
      <div v-if="tickets.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div
          v-for="ticket in tickets"
          :key="ticket.id"
          class="p-4 border rounded-lg dark:border-gray-700 dark:bg-gray-800"
        >
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ ticket.title }}</h3>
          <p class="text-gray-700 dark:text-gray-300 mt-2">{{ ticket.description }}</p>
          <p class="text-sm text-gray-500 mt-2">Status: {{ ticket.status }}</p>
          <div class="flex space-x-2 mt-4">
            <button
              @click="editTicket(ticket)"
              class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors"
            >
              Edit
            </button>
            <button
              @click="deleteTicket(ticket.id)"
              class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <!-- No Tickets Message -->
      <p v-else class="text-gray-500 text-center mt-4">No tickets available.</p>


    </div>
  </div>
</template>

<script setup></script>