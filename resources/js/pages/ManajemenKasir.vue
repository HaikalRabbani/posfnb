<template>
  <AdminLayout>
    <div class="p-6">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
          <h1 class="text-2xl font-black text-ink tracking-tight">Manajemen <span class="text-blue">Karyawan</span></h1>
          <p class="text-sm text-muted font-medium mt-1">Kelola akses, role, dan status aktif tim Anda.</p>
        </div>
        <button @click="openModal()" class="bg-blue hover:bg-navy text-white px-5 py-2.5 rounded-xl font-black text-[11px] uppercase tracking-widest shadow-md transition-all flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          Tambah Karyawan
        </button>
      </div>

      <div class="bg-white rounded-3xl shadow-sm border border-border overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-surface/50 border-b border-border">
                <th class="px-6 py-4 text-[10px] text-muted uppercase font-black tracking-widest">Profil Karyawan</th>
                <th class="px-6 py-4 text-[10px] text-muted uppercase font-black tracking-widest">Role</th>
                <th class="px-6 py-4 text-[10px] text-muted uppercase font-black tracking-widest text-center">Status</th>
                <th class="px-6 py-4 text-[10px] text-muted uppercase font-black tracking-widest text-center">Tipe Login</th>
                <th class="px-6 py-4 text-[10px] text-muted uppercase font-black tracking-widest">Tgl Bergabung</th>
                <th class="px-6 py-4 text-[10px] text-muted uppercase font-black tracking-widest text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-border">
              
              <tr v-if="isLoadingData">
                <td colspan="6" class="py-12 text-center text-muted font-normal italic">Memuat data karyawan...</td>
              </tr>
              
              <tr v-for="user in users" :key="user.id" class="hover:bg-surface/30 transition-colors group">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-navy border border-border flex items-center justify-center text-white font-black text-sm uppercase flex-shrink-0 shadow-inner">
                      {{ user.name.charAt(0) }}
                    </div>
                    <div>
                      <div class="font-bold text-ink text-sm">{{ user.name }}</div>
                      <div class="text-xs text-muted">{{ user.email }}</div>
                    </div>
                  </div>
                </td>

                <td class="px-6 py-4">
                  <span :class="{
                    'bg-purple-100 text-purple-700': user.role === 'developer' || user.role === 'owner',
                    'bg-blue/10 text-blue': user.role === 'manager',
                    'bg-gray-100 text-gray-600': user.role === 'karyawan',
                  }" class="px-3 py-1 rounded-lg text-[10px] uppercase font-black tracking-wider shadow-sm">
                    {{ user.role }}
                  </span>
                </td>

                <td class="px-6 py-4 text-center">
                  <button v-if="canManageUser(user) && user.id !== currentUser.id" @click="toggleStatus(user)" class="flex items-center justify-center gap-1.5 mx-auto px-2 py-1 rounded hover:bg-surface transition-colors cursor-pointer">
                    <span :class="user.is_active ? 'bg-green-500' : 'bg-red-500'" class="w-2 h-2 rounded-full shadow-sm"></span>
                    <span class="text-xs font-bold text-ink">{{ user.is_active ? 'Aktif' : 'Nonaktif' }}</span>
                  </button>
                  <div v-else class="flex items-center justify-center gap-1.5 mx-auto px-2 py-1">
                    <span :class="user.is_active ? 'bg-green-500' : 'bg-red-500'" class="w-2 h-2 rounded-full shadow-sm"></span>
                    <span class="text-xs font-bold text-ink">{{ user.is_active ? 'Aktif' : 'Nonaktif' }}</span>
                  </div>
                </td>

                <td class="px-6 py-4 text-center">
                  <div v-if="user.provider === 'google'" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-500 border border-red-100" title="Login via Google">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M21.35,11.1H12.18V13.83H18.69C18.36,17.64 15.19,19.27 12.19,19.27C8.36,19.27 5,16.25 5,12C5,7.9 8.2,4.73 12.2,4.73C15.29,4.73 17.1,6.7 17.1,6.7L19,4.72C19,4.72 16.56,2 12.1,2C6.42,2 2.03,6.8 2.03,12C2.03,17.05 6.16,22 12.25,22C17.6,22 21.5,18.33 21.5,12.91C21.5,11.76 21.35,11.1 21.35,11.1V11.1Z" /></svg>
                  </div>
                  <div v-else class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-surface text-muted border border-border" title="Login Lokal (Email/Password)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                  </div>
                </td>

                <td class="px-6 py-4 text-xs font-medium text-muted">
                  {{ formatDate(user.created_at) }}
                </td>

                <td class="px-6 py-4 text-right">
                  <div v-if="canManageUser(user)" class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button @click="openModal(user)" class="p-2 text-blue hover:bg-blue/10 rounded-lg transition-colors" title="Edit Data">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button v-if="user.id !== currentUser.id" @click="confirmDelete(user)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Karyawan">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                  </div>
                  <div v-else class="text-[10px] text-hint italic font-medium">
                    Tidak ada akses
                  </div>
                </td>
              </tr>

              <tr v-if="!isLoadingData && users.length === 0">
                <td colspan="6" class="px-6 py-12 text-center text-muted text-sm font-medium">Belum ada data karyawan.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-ink/60 backdrop-blur-sm" @click="closeModal"></div>
      <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden flex flex-col font-bold">
        <div class="p-6 border-b border-border flex justify-between items-center bg-white">
          <h3 class="text-xl font-black text-ink uppercase tracking-tight">{{ isEditMode ? 'Edit Karyawan' : 'Tambah Karyawan' }}</h3>
          <button @click="closeModal" class="text-muted hover:text-cancelled"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        
        <div class="p-6 overflow-y-auto bg-white space-y-4">
          <div>
            <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Nama Lengkap</label>
            <input 
              v-model="form.name" 
              type="text" 
              class="w-full border rounded-xl px-4 py-3 outline-none focus:border-blue transition-all"
              :class="errors.name ? 'border-cancelled bg-red-50' : 'border-border'"
              placeholder="Misal: Budi Santoso"
            >
            <p v-if="errors.name" class="text-[10px] text-cancelled mt-1 italic font-medium">{{ errors.name }}</p>
          </div>

          <div>
            <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Email Akses</label>
            <input 
              v-model="form.email" 
              type="email" 
              class="w-full border rounded-xl px-4 py-3 outline-none focus:border-blue transition-all"
              :class="errors.email ? 'border-cancelled bg-red-50' : 'border-border'"
              placeholder="budi@outlet.com"
            >
            <p v-if="errors.email" class="text-[10px] text-cancelled mt-1 italic font-medium">{{ errors.email }}</p>
          </div>

          <div>
            <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">
              Kata Sandi <span v-if="isEditMode" class="text-hint normal-case font-normal">(Kosongkan jika tidak diubah)</span>
            </label>
            <input 
              v-model="form.password" 
              type="password" 
              class="w-full border rounded-xl px-4 py-3 outline-none focus:border-blue transition-all"
              :class="errors.password ? 'border-cancelled bg-red-50' : 'border-border'"
              placeholder="••••••••"
            >
            <p v-if="errors.password" class="text-[10px] text-cancelled mt-1 italic font-medium">{{ errors.password }}</p>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Role (Hak Akses)</label>
              <select v-model="form.role" class="w-full border border-border rounded-xl px-4 py-3 outline-none bg-white">
                <option v-for="role in availableRoles" :key="role.value" :value="role.value">
                  {{ role.label }}
                </option>
              </select>
            </div>
            
            <div>
              <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Status Akun</label>
              <select v-model="form.is_active" class="w-full border border-border rounded-xl px-4 py-3 outline-none bg-white">
                <option :value="true">Aktif</option>
                <option :value="false">Nonaktif</option>
              </select>
            </div>
          </div>
        </div>

        <div class="p-6 border-t border-border bg-surface/50 flex justify-end gap-3">
          <button @click="closeModal" class="px-6 py-3 text-ink hover:bg-border rounded-xl transition-all font-black uppercase tracking-widest text-[11px]">Batal</button>
          <button @click="saveUser" :disabled="isSaving" class="px-8 py-3 bg-blue hover:bg-navy text-white rounded-xl shadow-lg disabled:opacity-50 transition-all font-black uppercase tracking-widest text-[11px]">
            {{ isSaving ? 'Menyimpan...' : 'Simpan Data' }}
          </button>
        </div>
      </div>
    </div>

    <div v-if="deleteState.isOpen" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-ink/70 backdrop-blur-sm" @click="cancelDelete"></div>
      <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 overflow-hidden flex flex-col font-bold text-center p-6 relative transform transition-all">
        <div class="w-16 h-16 bg-cancelled/10 text-cancelled rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        
        <h3 class="text-xl font-black text-ink uppercase tracking-tight mb-2">Hapus Karyawan?</h3>
        <p class="text-sm text-muted font-medium mb-6">
          Apakah Anda yakin ingin menghapus akun <span class="text-ink font-black">"{{ deleteState.name }}"</span>? Tindakan ini tidak dapat dibatalkan.
        </p>
        
        <div class="flex gap-3">
          <button @click="cancelDelete" class="flex-1 px-4 py-3 bg-surface border border-border text-ink hover:bg-ice rounded-xl transition-all uppercase tracking-widest text-[11px] font-black">Batal</button>
          <button @click="executeDelete" :disabled="deleteState.isDeleting" class="flex-1 px-4 py-3 bg-cancelled hover:bg-red-600 text-white rounded-xl shadow-lg disabled:opacity-50 transition-all uppercase tracking-widest text-[11px] font-black">
            {{ deleteState.isDeleting ? 'Proses...' : 'Ya, Hapus' }}
          </button>
        </div>
      </div>
    </div>

  </AdminLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import AdminLayout from '../components/adminlayout.vue';
import axios from 'axios';

// API Configuration
const api = axios.create({
  baseURL: 'https://api.etres.my.id/api',
  headers: { 
    'Accept': 'application/json', 
    'Authorization': `Bearer ${localStorage.getItem('auth_token')}` 
  }
});

// States
const users = ref([]);
const isLoadingData = ref(false);
const isSaving = ref(false);

// Ambil data user yang sedang login dari localStorage
const currentUser = ref(JSON.parse(localStorage.getItem('user')) || {});

// ==========================================
// ROLE-BASED ACCESS CONTROL (RBAC) LOGIC
// ==========================================

// 1. Opsi Role di Dropdown Modal
const availableRoles = computed(() => {
  const currentRole = currentUser.value?.role;
  
  if (currentRole === 'developer' || currentRole === 'owner') {
    return [
      { value: 'manager', label: 'Manager (Admin)' },
      { value: 'karyawan', label: 'Karyawan (Kasir)' }
    ];
  } 
  
  // Manager cuma bisa bikin akun karyawan biasa
  return [
    { value: 'karyawan', label: 'Karyawan (Kasir)' }
  ];
});

// 2. Proteksi Tombol Edit & Hapus di Tabel
const canManageUser = (targetUser) => {
  const currentRole = currentUser.value?.role;
  
  // Developer/Owner bebas atur siapa saja
  if (currentRole === 'developer' || currentRole === 'owner') return true;
  
  // Manager HANYA bisa ngatur karyawan biasa (nggak bisa ngatur sesama manager/bos)
  if (currentRole === 'manager' && targetUser.role === 'karyawan') return true;
  
  return false;
};

// ==========================================

// Form States & Errors
const isModalOpen = ref(false);
const isEditMode = ref(false);
const errors = ref({});
const form = ref({
  id: null,
  name: '',
  email: '',
  password: '',
  role: 'karyawan',
  is_active: true
});

// Delete States
const deleteState = ref({
  isOpen: false,
  id: null,
  name: '',
  isDeleting: false
});

// Utilities
const formatDate = (dateString) => {
  if (!dateString) return '-';
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
};

// Fetch Data dari Backend
const fetchUsers = async () => {
  isLoadingData.value = true;
  try {
    const response = await api.get('/users');
    users.value = response.data.data || response.data;
  } catch (error) {
    console.error("Gagal mengambil data user:", error);
    users.value = [];
  } finally {
    isLoadingData.value = false;
  }
};

// Toggle Status (Aktif/Nonaktif) Cepat
const toggleStatus = async (user) => {
  try {
    const newStatus = !user.is_active;
    await api.put(`/users/${user.id}`, { is_active: newStatus });
    user.is_active = newStatus;
  } catch (error) {
    alert('Gagal mengubah status akun.');
  }
};

// Modal Functions
const openModal = (user = null) => {
  errors.value = {}; 
  if (user) {
    isEditMode.value = true;
    form.value = { 
      id: user.id, 
      name: user.name, 
      email: user.email, 
      password: '', 
      role: user.role, 
      is_active: Boolean(user.is_active) 
    };
  } else {
    isEditMode.value = false;
    // Default form role menyesuaikan siapa yang login
    const defaultRole = (currentUser.value?.role === 'manager') ? 'karyawan' : 'manager';
    form.value = { id: null, name: '', email: '', password: '', role: defaultRole, is_active: true };
  }
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};

// Save Data (Create / Update) dengan Validasi Visual
const saveUser = async () => {
  errors.value = {};
  let isValid = true;

  if (!form.value.name) {
    errors.value.name = 'Nama lengkap wajib diisi';
    isValid = false;
  }
  if (!form.value.email) {
    errors.value.email = 'Email akses wajib diisi';
    isValid = false;
  }
  if (!isEditMode.value && !form.value.password) {
    errors.value.password = 'Kata sandi wajib diisi untuk karyawan baru';
    isValid = false;
  }

  if (!isValid) return;

  isSaving.value = true;
  try {
    const payload = {
      name: form.value.name,
      email: form.value.email,
      role: form.value.role,
      is_active: form.value.is_active,
    };

    if (form.value.password) {
      payload.password = form.value.password;
    }

    if (isEditMode.value) {
      await api.put(`/users/${form.value.id}`, payload);
    } else {
      await api.post('/users', payload);
    }
    
    closeModal();
    fetchUsers(); 
  } catch (error) {
    if (error.response?.data?.errors?.email) {
      errors.value.email = error.response.data.errors.email[0];
    } else {
      alert(error.response?.data?.message || 'Gagal menyimpan data karyawan.');
    }
  } finally {
    isSaving.value = false;
  }
};

// Delete Functions
const confirmDelete = (user) => {
  deleteState.value = {
    isOpen: true,
    id: user.id,
    name: user.name,
    isDeleting: false
  };
};

const cancelDelete = () => {
  deleteState.value.isOpen = false;
};

const executeDelete = async () => {
  deleteState.value.isDeleting = true;
  try {
    await api.delete(`/users/${deleteState.value.id}`);
    cancelDelete();
    fetchUsers();
  } catch (error) {
    alert('Gagal menghapus karyawan.');
  } finally {
    deleteState.value.isDeleting = false;
  }
};

onMounted(() => {
  fetchUsers();
});
</script>