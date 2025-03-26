<template>
    <div
        class="max-w-md w-full bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6"
    >
        <div class="flex justify-between mb-4">
            <button
                :class="[
                    'w-1/2 py-2 text-center font-semibold text-lg',
                    {
                        'bg-primary text-white': activeTab === 'login',
                        'text-primary dark:text-white': activeTab !== 'login',
                    },
                ]"
                @click="activeTab = 'login'"
            >
                Login
            </button>
            <button
                :class="[
                    'w-1/2 py-2 text-center font-semibold text-lg',
                    {
                        'bg-primary text-white': activeTab === 'register',
                        'text-primary dark:text-white':
                            activeTab !== 'register',
                    },
                ]"
                @click="activeTab = 'register'"
            >
                Register
            </button>
        </div>

        <!-- ----------------------------------------------- -->
        <!-- login form -->
        <!-- ----------------------------------------------- -->

        <form
            v-if="activeTab === 'login'"
            @submit.prevent="handleLogin"
            class="space-y-6"
        >
            <h2
                class="text-2xl font-bold text-center text-gray-900 dark:text-white"
            >
                Login to Your Account
            </h2>
            <div class="space-y-4">
                <div>
                    <label
                        for="login-email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >Eamil</label
                    >
                    <input
                        id="login-email"
                        v-model="loginForm.email"
                        type="email"
                        placeholder="your@email.com"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-800 dark:text-white"
                    />
                </div>
                <div>
                    <label
                        for="login-password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >Password</label
                    >
                    <input
                        id="login-password"
                        v-model="loginForm.password"
                        type="password"
                        placeholder="Your password"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-800 dark:text-white"
                    />
                </div>
            </div>

            <div v-if="loginError" class="text-red-600 text-sm mb-4">
                {{ loginError }}
            </div>

            <button
                type="submit"
                class="w-full py-2 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark focus:ring-2 focus:ring-primary"
                :disabled="isLoading"
            >
                {{ isLoading ? "Logging in..." : "Login" }}
            </button>
        </form>

        <!-- ----------------------------------------------- -->
        <!-- register form -->
        <!-- ----------------------------------------------- -->

        <form v-if="activeTab === 'register'">
            <h2
                class="text-2xl font-bold text-center text-gray-900 dark:text-white"
            >
                Create New Account {{ API_BASE_URL }}
            </h2>
        </form>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";

const activeTab = ref("login");
const isLoading = ref(false);
const loginError = ref("");
const user = ref(null);
const token = ref("");
//  url
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

onMounted(()=>{
  const savedToken = localStorage.getItem('auth_token')
  const savedUser = localStorage.getItem('user')
  
  if (savedToken) {
    token.value = savedToken
    try {
      user.value = JSON.parse(savedUser)
    } catch (e) {
      console.error('Error parsing user data', e)
    }
  }  
})

const loginForm = reactive({
    email: "",
    password: "",
});

const handleLogin = async () => {
    try {
        isLoading.value = true;
        loginError.value = "";
        // console.log(JSON.stringify(loginForm));
        const response = await fetch(`${API_BASE_URL}/api/login`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(loginForm),
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || "Login failed");
        }
        token.value = data.token
        localStorage.setItem('auth_token', data.token)
        loginForm.email = "";
        loginForm.password = "";
    } catch (error) {
        loginError.value = error.message || "An error occurred during login";
        console.error("Login error:", error);
    } finally {
        isLoading.value = false;
    }
};
</script>

<style></style>
