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

        <form v-if="activeTab === 'login'">
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
        </form>

        <!-- ----------------------------------------------- -->
        <!-- register form -->
        <!-- ----------------------------------------------- -->

        <form v-if="activeTab === 'register'">
            <h2
                class="text-2xl font-bold text-center text-gray-900 dark:text-white"
            >
                Create New Account
            </h2>
        </form>
    </div>
</template>

<script setup>
import { reactive, ref } from "vue";

const activeTab = ref("register");

const loginForm = reactive({
  email: '',
  password: ''
})
</script>

<style></style>
