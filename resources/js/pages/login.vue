<template>
  <div class="min-h-screen bg-surface flex items-center justify-center p-4 text-ink">
    <div class="bg-white p-8 rounded-xl shadow-sm border border-border w-full max-w-md">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-navy mb-2">POS F&B</h1>
        <p class="text-muted text-sm">Silakan masuk ke akun kasir/admin Anda</p>
      </div>

      <div v-if="errorMessage" class="mb-5 p-3 bg-red-50 border border-cancelled text-cancelled rounded-lg text-sm font-medium">
        {{ errorMessage }}
      </div>
      
      <form @submit.prevent="handleLogin" class="flex flex-col gap-4">
        <div>
          <label class="block text-sm font-medium text-muted mb-1">Email</label>
          <input 
            v-model="email"
            type="email" 
            required
            class="w-full border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-blue placeholder-hint" 
            placeholder="admin@example.com" 
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-muted mb-1">Password</label>
          <input 
            v-model="password"
            type="password" 
            required
            class="w-full border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-blue placeholder-hint" 
            placeholder="••••••••" 
          />
        </div>
        
        <button 
          type="submit" 
          :disabled="isLoading"
          class="w-full bg-blue text-white font-medium py-2.5 rounded-lg hover:bg-navy transition-colors mt-4 disabled:opacity-70 disabled:cursor-not-allowed flex justify-center items-center gap-2"
        >
          <svg v-if="isLoading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          {{ isLoading ? 'Memproses...' : 'Masuk' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

// State Form (Langsung diisi default sesuai data testing kamu)
const email = ref('admin@example.com');
const password = ref('password');

// State Status
const isLoading = ref(false);
const errorMessage = ref('');

const handleLogin = async () => {
  isLoading.value = true;
  errorMessage.value = '';

  try {
    // 1. Tembak API eksternal
    const response = await axios.post('https://api.etres.my.id/api/auth/login', {
      email: email.value,
      password: password.value
    });

    // 2. Ambil token dari response
    // Sesuaikan dengan struktur JSON dari API tersebut (biasanya access_token atau token)
    const token = response.data.access_token || response.data.token || response.data?.data?.token;

    if (token) {
      // Simpan JWT Token di LocalStorage
      localStorage.setItem('auth_token', token);
      
      // Set default header Axios supaya request berikutnya otomatis membawa token
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      
      // Lempar ke dashboard
      router.push('/dashboard');
    } else {
      errorMessage.value = 'Login berhasil, tapi token tidak ditemukan.';
    }

  } catch (error) {
    console.error('Error Login:', error);
    if (error.response && error.response.data) {
      errorMessage.value = error.response.data.message || 'Email atau password salah.';
    } else {
      errorMessage.value = 'Gagal terhubung ke server. Periksa koneksi internet Anda.';
    }
  } finally {
    isLoading.value = false;
  }
};
</script>