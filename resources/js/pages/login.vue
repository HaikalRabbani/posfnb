<template>
  <div class="min-h-screen bg-surface flex items-center justify-center p-4 text-ink">
    <div class="bg-white p-8 rounded-xl shadow-sm border border-border w-full max-w-md">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-navy mb-2">POS F&B</h1>
        <p class="text-muted text-sm">Silakan masuk ke akun kasir/admin Anda</p>
      </div>
      
      <form @submit.prevent="handleLogin" class="flex flex-col gap-4">
        <div>
          <label class="block text-sm font-medium text-muted mb-1">Email</label>
          <input type="email" class="w-full border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-blue placeholder-hint" placeholder="admin@posfnb.com" />
        </div>
        <div>
          <label class="block text-sm font-medium text-muted mb-1">Password</label>
          <input type="password" class="w-full border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-blue placeholder-hint" placeholder="••••••••" />
        </div>
        
        <button type="submit" class="w-full bg-blue text-white font-medium py-2.5 rounded-lg hover:bg-navy transition-colors mt-4">
          Masuk
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

const handleLogin = () => {
  // Nanti di sini kita tambahkan logika hit API Laravel
  // Untuk sekarang, kita langsung lempar ke dashboard
  router.push('/dashboard');
};
</script>