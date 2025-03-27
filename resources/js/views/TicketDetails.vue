<template>
    <div class="max-w-2xl w-full bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 space-y-6">
        <!-- Title -->
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Ticket Details</h2>

        <!-- Ticket Information -->
        <div v-if="ticket" class="space-y-3">
            <p class="flex items-center gap-2 text-gray-900 dark:text-white">
                <span class="font-medium text-gray-700 dark:text-gray-400">Title:</span>
                <span>{{ ticket.title }}</span>
            </p>
            <p class="flex items-center gap-2 text-gray-900 dark:text-white">
                <span class="font-medium text-gray-700 dark:text-gray-400">Description:</span>
                <span>{{ ticket.description }}</span>
            </p>
            <p class="flex items-center gap-2 text-gray-900 dark:text-white">
                <span class="font-medium text-gray-700 dark:text-gray-400">Status:</span>
                <span :class="statusClass">{{ ticket.status }}</span>
            </p>
            <p class="flex items-center gap-2 text-gray-900 dark:text-white">
                <span class="font-medium text-gray-700 dark:text-gray-400">Date:</span>
                <span :class="statusClass">{{ new Date(ticket.created_at).toLocaleString() }}</span>
            </p>
        </div>

        <!-- Agent Responses -->
        <div v-if="responses.length" class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Agent Responses</h3>
            <div
                v-for="response in responses"
                :key="response.id"
                class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg space-y-2"
            >
                <p class="flex items-center gap-2 text-gray-900 dark:text-white">
                    <span class="font-medium text-gray-700 dark:text-gray-400">Agent:</span>
                    <span>{{ response.user.name }}</span>
                </p>
                <p class="text-gray-900 dark:text-white">{{ response.response }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ response.created_at }}</p>
            </div>
        </div>

        <!-- Back Button -->
        <button
            @click="goBack"
            class="mt-4 py-2 px-4 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark transition-colors"
        >
            Back to Tickets
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const ticket = ref(null);
const responses = ref([]);
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;
const token = localStorage.getItem("auth_token");

const statusClass = computed(() => {
    return ticket.value?.status === 'open' ? 'text-green-600' : 'text-red-600';
});

onMounted(async () => {
    await fetchTicketDetails();
});

const fetchTicketDetails = async () => {
    try {
        const response = await fetch(`${API_BASE_URL}/api/tickets/${route.params.id}`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        
        if (!response.ok) throw new Error("Failed to fetch ticket");
        
        const data = await response.json();
        ticket.value = data;
        responses.value = data.responses || [];
    } catch (error) {
        console.error("Error fetching ticket details:", error);
    }
};

const goBack = () => {
    router.push({ name: 'TicketList' });
};
</script>

<style></style>
