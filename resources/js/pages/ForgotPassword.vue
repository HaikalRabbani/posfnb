<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Lupa Password</h2>
      <p class="text-sm text-gray-600 mb-4 text-center">
        Masukkan email Anda, kami akan mengirimkan link untuk mereset password.
      </p>

      <form @submit.prevent="requestResetLink">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
          <input 
            v-model="email" 
            type="email" 
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
            placeholder="admin@posfnb.com"
            required
          >
        </div>

        <button 
          type="submit" 
          :disabled="isLoading"
          class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 transition disabled:opacity-50"
        >
          {{ isLoading ? 'Mengirim...' : 'Kirim Link Reset' }}
        </button>
      </form>

      <div class="mt-4 text-center">
        <router-link to="/" class="text-sm text-blue-500 hover:underline">
          Kembali ke Login
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const email = ref('');
const isLoading = ref(false);

const requestResetLink = async () => {
  isLoading.value = true;
  try {
    // Sesuaikan URL ini dengan URL Backend Laravel kamu nanti
    const response = await axios.post('http://localhost:8000/api/forgot-password', {
      email: email.value
    });
    alert(response.data.message);
    email.value = ''; // Kosongkan input
  } catch (error) {
    alert(error.response?.data?.message || 'Terjadi kesalahan sistem.');
  } finally {
    isLoading.value = false;
  }
};
</script>