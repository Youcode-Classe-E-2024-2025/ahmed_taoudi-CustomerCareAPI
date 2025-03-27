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

        <form
            v-if="activeTab === 'register'"
            @submit.prevent="handleRegister"
            class="space-y-6"
        >
            <h2
                class="text-2xl font-bold text-center text-gray-900 dark:text-white"
            >
                Create New Account
            </h2>

            <div class="space-y-4">
                <div>
                    <label
                        for="register-name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >Full Name</label
                    >
                    <input
                        id="register-name"
                        v-model="registerForm.name"
                        type="text"
                        placeholder="John Doe"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-800 dark:text-white"
                    />
                </div>

                <div>
                    <label
                        for="register-email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >Email</label
                    >
                    <input
                        id="register-email"
                        v-model="registerForm.email"
                        type="email"
                        placeholder="your@email.com"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-800 dark:text-white"
                    />
                </div>

                <div>
                    <label
                        for="register-password"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >Password</label
                    >
                    <input
                        id="register-password"
                        v-model="registerForm.password"
                        type="password"
                        placeholder="Create a password"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-800 dark:text-white"
                    />
                </div>

                <div>
                    <label
                        for="register-password-confirm"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >Confirm Password</label
                    >
                    <input
                        id="register-password-confirm"
                        v-model="registerForm.password_confirmation"
                        type="password"
                        placeholder="Confirm your password"
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-800 dark:text-white"
                    />
                </div>
            </div>

            <div v-if="registerError" class="text-red-600 text-sm mb-4">
                {{ registerError }}
            </div>

            <button
                type="submit"
                class="w-full py-2 bg-primary text-white font-semibold rounded-lg hover:bg-primary-dark focus:ring-2 focus:ring-primary"
                :disabled="isLoading"
            >
                {{ isLoading ? "Creating account..." : "Register" }}
            </button>
        </form>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { authStore } from "../authStore.js"; 

const router = useRouter();
const activeTab = ref("login");
const isLoading = ref(false);
const loginError = ref("");
const registerError = ref("");
const user = ref(null);
const token = ref("");
//  url
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

onMounted(() => {
    const savedToken = localStorage.getItem("auth_token");
    const savedUser = localStorage.getItem("user");

    if (savedToken) {
        token.value = savedToken;
        try {
            user.value = JSON.parse(savedUser);
        } catch (e) {
            console.error("Error parsing user data", e);
        }
    }
});

const loginForm = reactive({
    email: "",
    password: "",
});


const registerForm = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

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

        const userInfo = await fetchUserInfo(data.token) ;
        authStore.login(userInfo, data.token);
        loginForm.email = "";
        loginForm.password = "";
        router.push({ name: 'Home' });
    } catch (error) {
        loginError.value = error.message || "An error occurred during login";
        console.error("Login error:", error);
    } finally {
        isLoading.value = false;
    }
};

// Register handler
const handleRegister = async () => {
  try {
    isLoading.value = true
    registerError.value = ''
    
    if (registerForm.password !== registerForm.password_confirmation) {
      throw new Error('Passwords do not match')
    }
    
    const response = await fetch(`${API_BASE_URL}/api/register`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(registerForm)
    })
    
    const data = await response.json()
    
    if (!response.ok) {
      if (response.status === 422 && data.errors) {
        const errorMessages = Object.values(data.errors).flat().join(', ')
        throw new Error(errorMessages)
      }
      throw new Error(data.message || 'Registration failed')
    }
    
    loginForm.email = registerForm.email
    loginForm.password = registerForm.password
    await handleLogin()
    
    registerForm.name = ''
    registerForm.email = ''
    registerForm.password = ''
    registerForm.password_confirmation = ''
    
    // activeTab.value = 'login'
    
  } catch (error) {
    registerError.value = error.message || 'An error occurred during registration'
    console.error('Registration error:', error)
  } finally {
    isLoading.value = false
  }
};

// Fetch user info
const fetchUserInfo = async (token) => {
  try {
    const response = await fetch(`${API_BASE_URL}/api/user`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    if (response.ok) {
      return await response.json();
    }
  } catch (error) {
    console.error("Error fetching user info:", error);
  }
}
</script>

<style></style>
