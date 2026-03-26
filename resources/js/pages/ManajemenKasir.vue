<template>
  <AdminLayout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
      <div>
        <h2 class="text-2xl font-bold text-ink">Manajemen <span class="text-blue">Kasir</span></h2>
        <p class="text-muted text-sm">Kelola akun staff dan kontrol status akses mereka</p>
      </div>
      <button @click="openModal()" class="bg-blue hover:bg-navy text-white px-5 py-2.5 rounded-lg font-bold transition-all flex items-center gap-2 shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
        Tambah Kasir
      </button>
    </div>

    <div class="bg-white border border-border rounded-xl shadow-sm overflow-hidden font-bold">
      <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[600px]">
          <thead>
            <tr class="border-b border-border bg-surface/50 text-[11px] uppercase text-muted tracking-wider">
              <th class="py-4 px-6">Nama & Email</th>
              <th class="py-4 px-6 text-center">Role</th>
              <th class="py-4 px-6 text-center">Status Akses</th>
              <th class="py-4 px-6 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-sm">
            <tr v-if="isLoading">
              <td colspan="4" class="py-12 text-center text-muted font-normal italic">Memuat data kasir...</td>
            </tr>
            <tr v-for="user in users" :key="user.id" 
                class="border-b border-ice transition-all duration-300"
                :class="!user.is_active ? 'bg-surface/50 opacity-50 grayscale' : 'hover:bg-surface/50'">
              
              <td class="py-4 px-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center text-xs uppercase shadow-sm">
                  {{ user.name.substring(0,2) }}
                </div>
                <div>
                  <p :class="!user.is_active ? 'text-muted line-through' : 'text-ink'">{{ user.name }}</p>
                  <p class="text-[11px] font-medium text-muted">{{ user.email }}</p>
                </div>
              </td>
              
              <td class="py-4 px-6 text-center">
                <span class="px-3 py-1 text-[10px] rounded-full border bg-amber-100 text-amber-700 border-amber-200 uppercase tracking-widest">
                  {{ user.role }}
                </span>
              </td>

              <td class="py-4 px-6 text-center">
                <button @click="toggleUserStatus(user)" 
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-[10px] uppercase font-black transition-all"
                        :class="user.is_active ? 'bg-paid/10 text-paid border-paid/30 shadow-sm' : 'bg-cancelled/10 text-cancelled border-cancelled/30'">
                  <span class="w-1.5 h-1.5 rounded-full" :class="user.is_active ? 'bg-paid' : 'bg-cancelled'"></span>
                  {{ user.is_active ? 'Aktif' : 'Nonaktif' }}
                </button>
              </td>

              <td class="py-4 px-6 text-right font-normal">
                <div class="flex items-center justify-end gap-2">
                  <button @click="openModal(user)" class="p-1.5 text-muted hover:text-blue transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                  <button @click="deleteUser(user.id)" class="p-1.5 text-muted hover:text-cancelled transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-ink/60 backdrop-blur-sm" @click="closeModal"></div>
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-md z-10 overflow-hidden font-bold">
        <div class="p-6 border-b border-border flex justify-between items-center bg-white">
          <h3 class="text-xl font-bold text-ink">{{ isEditMode ? 'Update Data Kasir' : 'Daftar Kasir Baru' }}</h3>
          <button @click="closeModal" class="text-muted hover:text-cancelled"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <div class="p-6 bg-white space-y-4">
          <div>
            <label class="block text-[11px] text-muted uppercase mb-1">Nama Lengkap</label>
            <input v-model="form.name" type="text" class="w-full border rounded-xl px-4 py-3 outline-none transition-all" :class="errors.name ? 'border-cancelled bg-red-50 focus:border-cancelled' : 'border-border focus:border-blue'">
            <p v-if="errors.name" class="text-[10px] text-cancelled mt-1 italic font-bold">⚠️ {{ errors.name }}</p>
          </div>
          <div>
            <label class="block text-[11px] text-muted uppercase mb-1">Email Login</label>
            <input v-model="form.email" type="email" class="w-full border rounded-xl px-4 py-3 outline-none" :class="errors.email ? 'border-cancelled bg-red-50' : 'border-border focus:border-blue'">
            <p v-if="errors.email" class="text-[10px] text-cancelled mt-1 italic font-bold">⚠️ {{ errors.email }}</p>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[11px] text-muted uppercase mb-1">Akses Role</label>
              <select v-model="form.role" class="w-full border border-border rounded-xl px-4 py-3 outline-none bg-white font-bold">
                <option value="kasir">KASIR</option>
                <option value="admin">ADMIN</option>
              </select>
            </div>
            <div>
              <label class="block text-[11px] text-muted uppercase mb-1">Password</label>
              <input v-model="form.password" type="password" class="w-full border border-border rounded-xl px-4 py-3 outline-none" :placeholder="isEditMode ? 'Kosongkan jika tetap' : 'Min 6 karakter'">
              <p v-if="errors.password" class="text-[10px] text-cancelled mt-1 italic font-bold">⚠️ {{ errors.password }}</p>
            </div>
          </div>
        </div>
        <div class="p-6 border-t border-border bg-surface/50 flex justify-end gap-3 font-bold">
          <button @click="closeModal" class="px-6 py-2.5 text-ink hover:bg-border rounded-xl transition-colors">Batal</button>
          <button @click="saveUser" :disabled="isSaving" class="px-6 py-2.5 bg-navy text-white rounded-xl shadow-md disabled:opacity-50">
            {{ isSaving ? 'Proses...' : 'Simpan Akun' }}
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AdminLayout from '../Components/AdminLayout.vue';
import axios from 'axios';

const api = axios.create({
  baseURL: 'https://api.etres.my.id/api',
  headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
});

const users = ref([]);
const isLoading = ref(false);
const isSaving = ref(false);
const isModalOpen = ref(false);
const isEditMode = ref(false);
const errors = ref({});

const form = ref({ id: null, name: '', email: '', role: 'kasir', password: '', is_active: true });

const fetchData = async () => {
  isLoading.value = true;
  try {
    const res = await api.get('/users');
    // Sort: Aktif di atas, Nonaktif di bawah
    users.value = (res.data || []).sort((a, b) => b.is_active - a.is_active);
  } catch (e) { console.error(e); }
  finally { isLoading.value = false; }
};

const openModal = (user = null) => {
  errors.value = {};
  if (user) {
    isEditMode.value = true;
    form.value = { ...user, password: '' };
  } else {
    isEditMode.value = false;
    form.value = { id: null, name: '', email: '', role: 'kasir', password: '', is_active: true };
  }
  isModalOpen.value = true;
};

const closeModal = () => { isModalOpen.value = false; errors.value = {}; };

const saveUser = async () => {
  errors.value = {};
  if (!form.value.name) errors.value.name = "Nama wajib diisi";
  if (!form.value.email) errors.value.email = "Email wajib diisi";
  if (!isEditMode.value && !form.value.password) errors.value.password = "Password wajib diisi";

  if (Object.keys(errors.value).length > 0) return;

  isSaving.value = true;
  try {
    const payload = { ...form.value };
    // Jika edit dan password kosong, hapus dari payload agar tidak terupdate jadi kosong
    if (isEditMode.value && !payload.password) delete payload.password;

    if (isEditMode.value) await api.put(`/users/${form.value.id}`, payload);
    else await api.post('/users', payload);
    
    closeModal(); fetchData();
  } catch (e) { 
    if (e.response?.status === 422) errors.value = e.response.data.errors;
    else alert("Gagal menyimpan data");
  } finally { isSaving.value = false; }
};

const toggleUserStatus = async (user) => {
  const originalStatus = user.is_active;
  const newStatus = !originalStatus;
  
  try {
    // Kita tembak API update biasa
    await api.put(`/users/${user.id}`, { 
        is_active: newStatus,
        name: user.name,
        email: user.email,
        role: user.role
    });
    user.is_active = newStatus;
    fetchData(); // Sort ulang posisi
  } catch (e) {
    alert("Gagal mengubah status akses");
    user.is_active = originalStatus;
  }
};

const deleteUser = async (id) => {
  if (confirm('Hapus akses kasir ini?')) {
    try { await api.delete(`/users/${id}`); fetchData(); } catch (e) { alert("Gagal hapus"); }
  }
};

onMounted(fetchData);
</script>