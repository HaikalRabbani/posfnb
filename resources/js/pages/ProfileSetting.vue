<template>
  <AdminLayout>
    <div class="max-w-3xl mx-auto">
      <div class="mb-8">
        <h2 class="text-2xl font-bold text-ink tracking-tight">Pengaturan Profil</h2>
        <p class="text-muted text-sm">Update informasi data diri dan keamanan akun Anda di sini.</p>
      </div>

      <div class="grid grid-cols-1 gap-8">
        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden font-bold">
          <div class="p-6 border-b border-border bg-surface/30">
            <h3 class="text-ink flex items-center gap-2">
              <svg class="w-5 h-5 text-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
              Detail Profil
            </h3>
          </div>
          <div class="p-8">
            <form @submit.prevent="updateProfile" class="space-y-5">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-[11px] uppercase text-muted tracking-widest mb-2">Nama Lengkap</label>
                  <input v-model="profileForm.name" type="text" class="w-full px-4 py-3 rounded-xl border border-border focus:border-blue outline-none transition-all text-ink" placeholder="Nama Anda">
                </div>
                <div>
                  <label class="block text-[11px] uppercase text-muted tracking-widest mb-2">Alamat Email</label>
                  <input v-model="profileForm.email" type="email" class="w-full px-4 py-3 rounded-xl border border-border focus:border-blue outline-none transition-all text-ink" placeholder="email@toko.com">
                </div>
              </div>
              <div class="flex justify-end pt-4">
                <button :disabled="isUpdating" class="bg-blue hover:bg-navy text-white px-8 py-3 rounded-xl shadow-md transition-all disabled:opacity-50">
                  {{ isUpdating ? 'Menyimpan...' : 'Simpan Perubahan' }}
                </button>
              </div>
            </form>
          </div>
        </div>

        <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden font-bold">
          <div class="p-6 border-b border-border bg-surface/30">
            <h3 class="text-ink flex items-center gap-2">
              <svg class="w-5 h-5 text-cancelled" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
              Ganti Password
            </h3>
          </div>
          <div class="p-8">
            <form @submit.prevent="updatePassword" class="space-y-6">
              <div>
                <label class="block text-[11px] uppercase text-muted tracking-widest mb-2">Password Saat Ini</label>
                <input v-model="passwordForm.old" type="password" class="w-full px-4 py-3 rounded-xl border border-border focus:border-blue outline-none transition-all" placeholder="••••••••">
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-[11px] uppercase text-muted tracking-widest mb-2">Password Baru</label>
                  <input v-model="passwordForm.new" type="password" class="w-full px-4 py-3 rounded-xl border border-border focus:border-blue outline-none transition-all" placeholder="Min. 8 Karakter">
                </div>
                <div>
                  <label class="block text-[11px] uppercase text-muted tracking-widest mb-2">Konfirmasi Password Baru</label>
                  <input v-model="passwordForm.confirm" type="password" class="w-full px-4 py-3 rounded-xl border border-border focus:border-blue outline-none transition-all" placeholder="Ulangi Password">
                </div>
              </div>
              <div class="flex justify-end pt-4">
                <button class="bg-navy hover:bg-ink text-white px-8 py-3 rounded-xl shadow-md transition-all">
                  Update Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AdminLayout from '../Components/AdminLayout.vue';
import axios from 'axios';

const isUpdating = ref(false);
const profileForm = ref({ name: '', email: '' });
const passwordForm = ref({ old: '', new: '', confirm: '' });

// Ambil data profil saat ini dari localStorage atau API
onMounted(() => {
  profileForm.value.name = localStorage.getItem('user_name') || 'Admin POS';
  profileForm.value.email = localStorage.getItem('user_email') || 'admin@pos.com';
});

const updateProfile = async () => {
  if(!profileForm.value.name || !profileForm.value.email) return alert('Data tidak boleh kosong');
  
  isUpdating.value = true;
  try {
    // Simulasi tembak API update profil
    // await axios.put('/api/profile/update', profileForm.value);
    
    localStorage.setItem('user_name', profileForm.value.name);
    localStorage.setItem('user_email', profileForm.value.email);
    
    setTimeout(() => {
      isUpdating.value = false;
      alert("Profil Berhasil Diperbarui! Silakan refresh halaman.");
      window.location.reload();
    }, 800);
  } catch (e) {
    isUpdating.value = false;
    alert("Gagal memperbarui profil.");
  }
};

const updatePassword = () => {
  if (!passwordForm.value.old || !passwordForm.value.new) return alert('Isi semua kolom password');
  if (passwordForm.value.new !== passwordForm.value.confirm) return alert('Konfirmasi password tidak cocok');
  
  // Simulasi tembak API ganti password
  alert("Password Berhasil Diubah!");
  passwordForm.value = { old: '', new: '', confirm: '' };
};
</script>