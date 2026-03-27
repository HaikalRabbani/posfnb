<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Buat Password Baru</h2>

      <form @submit.prevent="submitNewPassword">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Password Baru</label>
          <input 
            v-model="password" 
            type="password" 
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
            required
            minlength="8"
          >
        </div>

        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password Baru</label>
          <input 
            v-model="password_confirmation" 
            type="password" 
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
            required
            minlength="8"
          >
        </div>

        <button 
          type="submit" 
          :disabled="isLoading"
          class="w-full bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition disabled:opacity-50"
        >
          {{ isLoading ? 'Menyimpan...' : 'Simpan Password' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const password = ref('');
const password_confirmation = ref('');
const isLoading = ref(false);

// Tangkap token dan email dari URL bar (misal: /reset-password?token=abc&email=test@test.com)
const token = route.query.token;
const email = route.query.email;

const submitNewPassword = async () => {
  if (password.value !== password_confirmation.value) {
    alert('Password dan Konfirmasi Password tidak cocok!');
    return;
  }

  isLoading.value = true;
  try {
    const response = await axios.post('http://localhost:8000/api/reset-password', {
      email: email,
      token: token,
      password: password.value,
      password_confirmation: password_confirmation.value
    });
    
    alert(response.data.message);
    router.push('/'); // Arahkan kembali ke halaman login
    
  } catch (error) {
    alert(error.response?.data?.message || 'Gagal mereset password. Token mungkin tidak valid.');
  } finally {
    isLoading.value = false;
  }
};
</script>