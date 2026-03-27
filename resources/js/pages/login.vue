<template>
  <div class="min-h-screen flex items-center justify-center bg-surface p-4">
    <div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border border-border">
      
      <div class="text-center mb-8">
        <div class="w-16 h-16 bg-navy text-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
        </div>
        <h1 class="text-2xl font-black text-ink uppercase tracking-tight">POS <span class="text-blue">F&B</span></h1>
        <p class="text-sm text-muted font-medium mt-1">Masuk ke panel Backoffice</p>
      </div>

      <div v-if="errorMessage" class="mb-6 p-4 bg-cancelled/10 border border-cancelled/20 rounded-xl flex items-start gap-3 text-cancelled transition-all">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-xs font-bold leading-relaxed">{{ errorMessage }}</span>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-5">
        
        <div>
          <label class="block text-[10px] text-muted uppercase font-black mb-1.5 tracking-widest">Email Akses</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-muted">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
            </div>
            <input 
              v-model="form.email" 
              type="email" 
              required
              placeholder="manager@outlet.com" 
              class="w-full pl-11 pr-4 py-3 border border-border rounded-xl outline-none focus:border-blue transition-all font-bold text-sm bg-surface/30 focus:bg-white"
            >
          </div>
        </div>

        <div>
          <label class="block text-[10px] text-muted uppercase font-black mb-1.5 tracking-widest">Kata Sandi</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-muted">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <input 
              v-model="form.password" 
              type="password" 
              required
              placeholder="••••••••" 
              class="w-full pl-11 pr-4 py-3 border border-border rounded-xl outline-none focus:border-blue transition-all font-bold text-sm bg-surface/30 focus:bg-white"
            >
          </div>
          
          <div class="flex justify-end mt-2.5">
            <router-link 
              to="/forgot-password" 
              class="text-[10px] text-blue hover:text-navy uppercase font-black tracking-widest transition-colors duration-200"
            >
              Lupa Kata Sandi?
            </router-link>
          </div>
        </div>

        <button 
          type="submit" 
          :disabled="isLoading" 
          class="w-full py-3.5 bg-blue hover:bg-navy text-white rounded-xl font-black text-[11px] uppercase tracking-widest shadow-md transition-all disabled:opacity-50 flex justify-center items-center mt-2"
        >
          <svg v-if="isLoading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
          {{ isLoading ? 'Memverifikasi...' : 'Masuk Sekarang' }}
        </button>
      </form>
      
      <p class="text-center text-[10px] text-muted font-bold mt-8 uppercase tracking-widest">
        &copy; 2026 POS F&B System
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const form = ref({
  email: '',
  password: ''
});

const isLoading = ref(false);
const errorMessage = ref('');

// 1. JALANKAN SAAT HALAMAN LOGIN DIBUKA
onMounted(() => {
  // Cek apakah ada email bekas login sebelumnya di local storage
  const savedEmail = localStorage.getItem('last_login_email');
  if (savedEmail) {
    form.value.email = savedEmail; // Otomatis isikan ke kolom email
  }
});

// 2. FUNGSI HANDLE LOGIN KE API
const handleLogin = async () => {
  isLoading.value = true;
  errorMessage.value = '';

  try {
    const response = await axios.post('https://api.etres.my.id/api/auth/login', {
      email: form.value.email,
      password: form.value.password
    });

    const data = response.data;
    const token = data.token || data.access_token;
    
    if (token) {
      // Simpan token ke localStorage untuk digunakan ambil data profil
      localStorage.setItem('auth_token', token);
      
      try {
        // Ambil data detail user yang barusan login
        const userRes = await axios.get('https://api.etres.my.id/api/auth/me', {
          headers: { 'Authorization': `Bearer ${token}` }
        });
        
        const userData = userRes.data.data || userRes.data;

        // ====================================================
        // 🛡️ SISTEM KEAMANAN: BLOKIR KARYAWAN MASUK WEB ADMIN
        // ====================================================
        if (userData.role === 'karyawan') {
          // Hapus kembali tokennya dari sistem
          localStorage.removeItem('auth_token');
          
          // Tampilkan pesan error
          errorMessage.value = 'Akses Ditolak! Karyawan (Kasir) hanya dapat login melalui Aplikasi Mesin Kasir.';
          isLoading.value = false;
          return; // Batalkan proses login
        }
        // ====================================================

        // Jika dia Manager / Developer, izinkan masuk!
        localStorage.setItem('last_login_email', form.value.email);
        localStorage.setItem('user', JSON.stringify(userData));
        
        // Pindahkan ke halaman Dashboard
        router.push('/dashboard');

      } catch (e) {
        console.warn('Gagal ambil data user awal', e);
        errorMessage.value = 'Gagal memverifikasi profil akun Anda.';
      }

    } else {
      errorMessage.value = 'Token tidak valid dari server.';
    }

  } catch (error) {
    // Penanganan error dari API (Password salah, dll)
    if (error.response && error.response.status === 401) {
      errorMessage.value = 'Email atau kata sandi yang Anda masukkan salah.';
    } else if (error.response && error.response.data && error.response.data.message) {
      errorMessage.value = error.response.data.message;
    } else {
      errorMessage.value = 'Terjadi kesalahan pada server. Silakan coba lagi.';
    }
  } finally {
    isLoading.value = false;
  }
};
</script>