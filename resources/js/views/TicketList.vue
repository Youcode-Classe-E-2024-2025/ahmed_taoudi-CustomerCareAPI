<template>
  <div class="w-full">
    <!-- Ticket Management Container -->
    <div class="max-w-md w-full mx-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6">
      <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-4">Manage Tickets</h2>
    
<!-- Status Filter  -->


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
      <div class="flex justify-center mb-4">
  <label class="mr-4 text-gray-700 dark:text-gray-300 font-semibold">Filter by Status:</label>
  <div class="flex space-x-2">
    <!-- All Button -->
    <button
      @click="setSelectedStatus('')"
      :class="[
        'inline-flex items-center px-4 py-2 border rounded-full text-sm font-medium transition-all duration-200 ease-in-out',
        selectedStatus === '' ? 'bg-purple-200 text-green-800 hover:bg-purple-300' : 'bg-white text-gray-700 hover:bg-purple-50'
      ]"
    >
      All
    </button>

    <!-- Open Button -->
    <button
      @click="setSelectedStatus('open')"
      :class="[
        'inline-flex items-center px-4 py-2 border rounded-full text-sm font-medium transition-all duration-200 ease-in-out',
        selectedStatus === 'open' ? 'bg-purple-200 text-green-800 hover:bg-purple-300' : 'bg-white text-gray-700 hover:bg-purple-50'
      ]"
    >
      Open
    </button>

    <!-- In Progress Button -->
    <button
      @click="setSelectedStatus('in_progress')"
      :class="[
        'inline-flex items-center px-4 py-2 border rounded-full text-sm font-medium transition-all duration-200 ease-in-out',
        selectedStatus === 'in_progress' ? 'bg-purple-200 text-green-800 hover:bg-purple-300' : 'bg-white text-gray-700 hover:bg-purple-50'
      ]"
    >
      In Progress
    </button>

    <!-- Closed Button -->
    <button
      @click="setSelectedStatus('closed')"
      :class="[
        'inline-flex items-center px-4 py-2 border rounded-full text-sm font-medium transition-all duration-200 ease-in-out',
        selectedStatus === 'closed' ? 'bg-purple-200 text-green-800 hover:bg-purple-300' : 'bg-white text-gray-700 hover:bg-purple-50'
      ]"
    >
      Closed
    </button>
  </div>
</div>
      <div v-if="tickets.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div
          v-for="ticket in tickets"
          :key="ticket.id"
          class="p-4 border rounded-lg dark:border-gray-700 dark:bg-gray-800"
        >
          <h3  @click="goToDetails(ticket.id)"  class="text-lg hover:underline font-semibold text-gray-900 dark:text-white">{{ ticket.title }}</h3>
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

      <!-- Pagination Links -->
      <div v-if="pagination.links.length > 0" class="flex justify-center mt-6 space-x-2">
        <button
          v-for="(link, index) in pagination.links"
          :key="index"
          @click="fetchPage(link.url)"
          :disabled="!link.url"
          :class="[
            'px-3 py-1 rounded',
            link.active ? 'bg-primary text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
            !link.url && 'cursor-not-allowed opacity-50'
          ]"
           v-html="link.label"
        >
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
const token = localStorage.getItem("auth_token");
const tickets = ref([]);
const pagination = ref({ links: [] });
const isEditing = ref(false);
const form = reactive({ id: null, title: '', description: '' });
const selectedStatus = ref('');
onMounted(fetchTickets);

async function fetchTickets(url = `${API_BASE_URL}/api/tickets`) {
  try {
    if (selectedStatus.value) {
      url += `?status=${selectedStatus.value}`;
    }

    const response = await fetch(url, {
      headers: { Authorization: `Bearer ${token}` },
    });
    const data = await response.json();
    tickets.value = data.data;
    pagination.value = {
      links: data.links,
      current_page: data.current_page,
      last_page: data.last_page,
    };
  } catch (error) {
    console.error('Error fetching tickets:', error);
  }
}

async function fetchPage(url) {
  if (url) {
    await fetchTickets(url);
  }
}

function applyFilter() {
  fetchTickets(`${API_BASE_URL}/api/tickets`);
}

function setSelectedStatus(status) {
  selectedStatus.value = status; 
  applyFilter(); 
}


async function handleSubmit() {
  const method = isEditing.value ? 'PUT' : 'POST';
  const url = isEditing.value ? `${API_BASE_URL}/api/tickets/${form.id}` : `${API_BASE_URL}/api/tickets`;

  await fetch(url, {
    method,
    headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${token}` },
    body: JSON.stringify(form),
  });
  resetForm();
  fetchTickets();
}

function editTicket(ticket) {
  Object.assign(form, ticket);
  isEditing.value = true;
}

async function deleteTicket(id) {
  await fetch(`${API_BASE_URL}/api/tickets/${id}`, {
    method: 'DELETE',
    headers: { Authorization: `Bearer ${token}` },
  });
  fetchTickets();
}

const router = useRouter();
defineProps(['ticket']);

const goToDetails = (id) => {
    router.push({ name: 'TicketDetails', params: { id } });
};

function resetForm() {
  Object.assign(form, { id: null, title: '', description: '' });
  isEditing.value = false;
}
</script>