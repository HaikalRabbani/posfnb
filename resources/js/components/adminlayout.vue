<template>
  <div class="min-h-screen flex text-ink bg-surface">
    
    <aside class="bg-white border-r border-border flex flex-col relative transition-all duration-300 ease-in-out z-20 flex-shrink-0 h-screen" :class="isSidebarMinimized ? 'w-20' : 'w-64'">
      <button @click="toggleSidebar" class="absolute -right-3 top-8 bg-white border border-border rounded-full p-1 text-muted hover:text-navy hover:bg-ice transition-colors shadow-sm z-30">
        <svg v-if="!isSidebarMinimized" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
      </button>

      <div class="h-20 flex items-center justify-center p-4 mb-2 overflow-hidden flex-shrink-0 border-b border-ice">
        <h1 class="text-navy font-bold flex items-center gap-2 transition-all duration-300" :class="isSidebarMinimized ? 'text-sm' : 'text-xl'">
          <span class="bg-navy text-white p-2 rounded-lg flex-shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg></span>
          <div v-show="!isSidebarMinimized" class="flex flex-col"><span class="whitespace-nowrap leading-tight">POS F&B</span><span class="text-[10px] text-muted font-normal leading-none">Admin Panel</span></div>
        </h1>
      </div>

      <nav class="flex flex-col gap-1 flex-1 px-3 overflow-y-auto overflow-x-hidden custom-scrollbar pb-4 mt-3">
        <div v-show="!isSidebarMinimized" class="text-[11px] font-bold text-muted uppercase tracking-wider mt-2 mb-1 px-3 opacity-60">Main Menu</div>
        <hr v-show="isSidebarMinimized" class="border-ice my-3 mx-2" />
        
        <router-link to="/dashboard" class="flex items-center gap-3 py-2.5 hover:bg-ice text-muted hover:text-navy rounded-lg transition-all duration-200 group" exact-active-class="bg-ice text-navy font-bold" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Dashboard">
          <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap text-sm">Dashboard</span>
        </router-link>
        
        <router-link to="/laporan" class="flex items-center gap-3 py-2.5 hover:bg-ice text-muted hover:text-navy rounded-lg transition-all duration-200 group" exact-active-class="bg-ice text-navy font-bold" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Laporan Analitik">
          <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap text-sm">Laporan Analitik</span>
        </router-link>

        <router-link to="/menu" class="flex items-center gap-3 py-2.5 hover:bg-ice text-muted hover:text-navy rounded-lg transition-all duration-200 group" exact-active-class="bg-ice text-navy font-bold" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Manajemen Menu">
          <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap text-sm">Manajemen Menu</span>
        </router-link>

        <router-link to="/transaksi" class="flex items-center gap-3 py-2.5 hover:bg-ice text-muted hover:text-navy rounded-lg transition-all duration-200 group" exact-active-class="bg-ice text-navy font-bold" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Riwayat Transaksi">
          <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap text-sm">Riwayat Transaksi</span>
        </router-link>

        <router-link to="/kasir" class="flex items-center gap-3 py-2.5 hover:bg-ice text-muted hover:text-navy rounded-lg transition-all duration-200 group" exact-active-class="bg-ice text-navy font-bold" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Manajemen Kasir">
          <svg class="w-5 h-5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap text-sm">Manajemen Staff</span>
        </router-link>

        <div class="mt-auto pt-5 border-t border-ice">
          <button @click="handleLogout" class="w-full flex items-center gap-3 py-2.5 text-cancelled hover:bg-red-50 rounded-lg transition-all duration-200 group" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Logout">
            <svg class="w-5 h-5 flex-shrink-0 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span v-show="!isSidebarMinimized" class="whitespace-nowrap text-sm font-bold">Logout</span>
          </button>
        </div>
      </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-surface">
      <header class="h-20 bg-surface border-b border-border flex items-center justify-between px-8 flex-shrink-0 z-10">
        <div>
          <h2 class="text-2xl font-bold text-ink">Admin Panel</h2>
        </div>
        <div class="flex items-center gap-5">
          <div class="hidden md:flex items-center gap-2 text-navy bg-white border border-border px-4 py-2 rounded-full shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="text-[13px] font-medium">{{ currentDate }}</span>
          </div>
          <button class="relative p-2 text-muted hover:text-navy hover:bg-ice rounded-full transition-colors" title="Notifikasi"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg><span class="absolute top-1.5 right-2 w-2.5 h-2.5 bg-cancelled rounded-full border-2 border-surface"></span></button>
          
          <div class="h-8 w-px bg-border"></div>
          
          <div class="relative">
            <button @click="toggleProfileMenu" class="flex items-center gap-3 hover:bg-ice p-1.5 pr-3 rounded-xl transition-colors text-left group">
              <div class="w-9 h-9 rounded-full bg-navy text-white flex items-center justify-center font-bold text-sm shadow-sm group-hover:bg-blue transition-colors uppercase">
                {{ userProfile.initial }}
              </div>
              <div class="hidden md:block">
                <span class="block text-sm font-bold text-ink leading-tight">{{ userProfile.name }}</span>
                <span class="block text-[11px] text-blue font-medium leading-tight mt-0.5 capitalize">{{ userProfile.role }}</span>
              </div>
              <svg class="w-4 h-4 text-muted group-hover:text-navy transition-transform" :class="isProfileMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div v-if="isProfileMenuOpen" @click="isProfileMenuOpen = false" class="fixed inset-0 z-40"></div>

            <div v-if="isProfileMenuOpen" class="absolute right-0 mt-2 w-48 bg-white border border-border rounded-xl shadow-lg py-2 z-50">
              <router-link to="/profile-setting" @click="isProfileMenuOpen = false" class="block px-4 py-2 text-sm font-bold text-ink hover:bg-ice transition-colors">
                Pengaturan Profil
              </router-link>
              <div class="border-t border-border my-1"></div>
              <p class="w-full text-left block px-4 py-2 text-sm font-bold transition-colors">
                fitur lain
              </p>
            </div>
          </div>

        </div>
      </header>

      <div class="p-8 overflow-y-auto flex-1 custom-scrollbar">
        <slot />
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const isSidebarMinimized = ref(false);
const isProfileMenuOpen = ref(false); // State untuk dropdown profil
const currentDate = ref('');

// State untuk menyimpan data User yang login
const userProfile = ref({
  name: 'Memuat...',
  role: '...',
  initial: ''
});

// URL dasar API
const BASE_URL = 'https://api.etres.my.id/api';

onMounted(() => {
  const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
  currentDate.value = new Date().toLocaleDateString('id-ID', options);
  
  // Panggil data profil saat layout dimuat
  fetchUserProfile();
});

const toggleSidebar = () => isSidebarMinimized.value = !isSidebarMinimized.value;
const toggleProfileMenu = () => isProfileMenuOpen.value = !isProfileMenuOpen.value;

// Fungsi GET /auth/me
const fetchUserProfile = async () => {
  const token = localStorage.getItem('auth_token');
  
  if (!token) {
    router.push('/');
    return;
  }

  try {
    const response = await axios.get(`${BASE_URL}/auth/me`, {
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json' // PENTING: Agar Laravel merespon JSON, bukan HTML Login Page
      }
    });
    
    // Asumsi response dari API Laravel L5-Swagger
    const userData = response.data.data || response.data;
    
    userProfile.value = {
      name: userData.name || 'Admin',
      role: userData.role || 'Administrator',
      initial: (userData.name || 'AD').substring(0, 2).toUpperCase()
    };
  } catch (error) {
    console.error('Gagal mengambil data profil:', error);
    // Sekarang aman untuk mengaktifkan ini kembali
    if (error.response && error.response.status === 401) {
      // Token tidak valid atau kedaluwarsa, bersihkan dan tendang ke login
      localStorage.removeItem('auth_token');
      router.push('/');
    }
  }
};

// Fungsi POST /auth/logout
const handleLogout = async () => {
  const token = localStorage.getItem('auth_token');
  
  if (token) {
    try {
      await axios.post(`${BASE_URL}/auth/logout`, {}, {
        headers: { 
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json' // PENTING: Standar API Laravel
        }
      });
    } catch (error) {
      console.error('Error saat logout di server:', error);
    }
  }
  
  // Hapus token lokal & pindah ke halaman login
  localStorage.removeItem('auth_token');
  router.push('/');
};
</script>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #D4E4F4; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #8AAFCC; }
</style>