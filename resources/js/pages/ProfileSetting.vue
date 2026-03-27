<template>
  <AdminLayout>
    <div class="max-w-4xl mx-auto">
      <div class="mb-8">
        <h2 class="text-2xl font-black text-ink uppercase tracking-tight">Pengaturan <span class="text-blue">Profil</span></h2>
        <p class="text-muted text-sm font-medium">Perbarui informasi akun dan kata sandi Anda di sini.</p>
      </div>

      <div class="bg-white rounded-3xl shadow-sm border border-border overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3">
          
          <div class="bg-surface/30 p-8 border-b md:border-b-0 md:border-r border-border flex flex-col items-center justify-center text-center">
            
            <div class="w-24 h-24 rounded-full bg-navy text-white flex items-center justify-center text-3xl font-black shadow-lg mb-4 uppercase tracking-tighter transition-all duration-300">
              {{ form.name ? form.name.substring(0, 2) : 'US' }}
            </div>
            
            <h3 class="text-lg font-black text-ink break-all">{{ form.name || 'Nama User' }}</h3>
            <p class="text-sm text-muted font-medium mb-1 break-all">{{ form.email || 'email@contoh.com' }}</p>
            
            <p class="text-[11px] font-black text-blue uppercase tracking-widest mb-4">
              {{ user.role || 'ROLE' }}
            </p>
            
            <span v-if="user.is_active" class="px-3 py-1 bg-paid/10 text-paid font-black text-[10px] rounded-full uppercase tracking-widest border border-paid/20">
              Akun Aktif
            </span>
            <span v-else class="px-3 py-1 bg-cancelled/10 text-cancelled font-black text-[10px] rounded-full uppercase tracking-widest border border-cancelled/20">
              Akun Nonaktif
            </span>
          </div>

          <div class="col-span-2 p-8 space-y-8 bg-white">
            
            <section>
              <h4 class="text-xs font-black text-ink uppercase tracking-widest border-b border-border pb-3 mb-5">Informasi Akun</h4>
              <div class="space-y-4">
                <div>
                  <label class="block text-[10px] text-muted uppercase font-black mb-1.5 tracking-widest">Nama Lengkap</label>
                  <input v-model="form.name" type="text" placeholder="Masukkan nama lengkap" class="w-full border border-border rounded-xl px-4 py-3 outline-none focus:border-blue transition-all font-bold text-sm bg-surface/30 focus:bg-white">
                </div>
                <div>
                  <label class="block text-[10px] text-muted uppercase font-black mb-1.5 tracking-widest">Alamat Email</label>
                  <input v-model="form.email" type="email" placeholder="Masukkan alamat email" class="w-full border border-border rounded-xl px-4 py-3 outline-none focus:border-blue transition-all font-bold text-sm bg-surface/30 focus:bg-white">
                </div>
                <div class="flex justify-end mt-2">
                  <button @click="updateProfile" :disabled="isSavingProfile" class="px-6 py-2.5 bg-blue hover:bg-navy text-white rounded-xl font-black text-[11px] uppercase tracking-widest shadow-md transition-all disabled:opacity-50">
                    {{ isSavingProfile ? 'Menyimpan...' : 'Simpan Profil' }}
                  </button>
                </div>
              </div>
            </section>

            <section>
              <h4 class="text-xs font-black text-ink uppercase tracking-widest border-b border-border pb-3 mb-5">Ubah Kata Sandi</h4>
              <div class="space-y-4">
                <div>
                  <label class="block text-[10px] text-muted uppercase font-black mb-1.5 tracking-widest">Kata Sandi Baru</label>
                  <input v-model="passwordForm.password" type="password" placeholder="Minimal 6 karakter" class="w-full border border-border rounded-xl px-4 py-3 outline-none focus:border-blue transition-all text-sm font-bold bg-surface/30 focus:bg-white">
                </div>
                <div>
                  <label class="block text-[10px] text-muted uppercase font-black mb-1.5 tracking-widest">Konfirmasi Kata Sandi Baru</label>
                  <input v-model="passwordForm.password_confirmation" type="password" placeholder="Ulangi kata sandi baru" class="w-full border border-border rounded-xl px-4 py-3 outline-none focus:border-cancelled transition-all text-sm font-bold bg-surface/30 focus:bg-white" :class="passwordError ? 'border-cancelled bg-red-50' : ''">
                  <p v-if="passwordError" class="text-[10px] text-cancelled mt-1 font-bold italic">{{ passwordError }}</p>
                </div>
                <div class="flex justify-end mt-2">
                  <button @click="updatePassword" :disabled="isSavingPassword" class="px-6 py-2.5 bg-surface border border-border text-ink hover:bg-ice rounded-xl font-black text-[11px] uppercase tracking-widest transition-all disabled:opacity-50">
                    {{ isSavingPassword ? 'Memperbarui...' : 'Perbarui Sandi' }}
                  </button>
                </div>
              </div>
            </section>

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

const api = axios.create({
  baseURL: 'https://api.etres.my.id/api',
  headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
});

// State untuk menyimpan semua data asli dari API
const user = ref({
  id: null,
  name: '',
  email: '',
  role: '',
  is_active: true
});

// Form terpisah untuk diedit (bound via v-model ke input)
// Data dari sinilah yang digunakan untuk pratinjau di sisi kiri
const form = ref({
  name: '',
  email: ''
});

const passwordForm = ref({
  password: '',
  password_confirmation: ''
});

const isSavingProfile = ref(false);
const isSavingPassword = ref(false);
const passwordError = ref('');

// Ambil profil terbaru dari endpoint Auth
const fetchProfile = async () => {
  try {
    const res = await api.get('/auth/me'); 
    const userData = res.data.data || res.data; 
    
    user.value = userData;
    form.value.name = userData.name;
    form.value.email = userData.email;
    
    // Simpan ke local storage agar Navbar juga terupdate otomatis
    localStorage.setItem('user', JSON.stringify(userData));
  } catch (error) {
    console.error("Gagal memuat data profil.");
  }
};

const updateProfile = async () => {
  if (!form.value.name || !form.value.email) return alert("Nama dan Email tidak boleh kosong!");
  
  isSavingProfile.value = true;
  try {
    if(user.value.id) {
       await api.put(`/users/${user.value.id}`, {
          name: form.value.name,
          email: form.value.email,
          role: user.value.role,
          is_active: user.value.is_active ? 1 : 0
       });
       
       alert("Profil berhasil diperbarui!");
       
       // Perbarui data asli ('user') dengan data dari form setelah berhasil disimpan
       user.value.name = form.value.name;
       user.value.email = form.value.email;
       localStorage.setItem('user', JSON.stringify(user.value));
       
       // Refresh halaman agar nama di Navbar atas ikut terupdate
       window.location.reload();
    }
  } catch (error) {
    alert("Gagal memperbarui profil. Email mungkin sudah dipakai.");
  } finally {
    isSavingProfile.value = false;
  }
};

const updatePassword = async () => {
  passwordError.value = '';
  if (passwordForm.value.password.length < 6) {
    passwordError.value = "Kata sandi minimal 6 karakter!";
    return;
  }
  if (passwordForm.value.password !== passwordForm.value.password_confirmation) {
    passwordError.value = "Konfirmasi kata sandi tidak cocok!";
    return;
  }

  isSavingPassword.value = true;
  try {
    if(user.value.id) {
      await api.put(`/users/${user.value.id}`, {
        name: user.value.name,
        email: user.value.email,
        role: user.value.role,
        is_active: user.value.is_active ? 1 : 0,
        password: passwordForm.value.password
      });
      
      alert("Kata sandi berhasil diperbarui!");
      passwordForm.value = { password: '', password_confirmation: '' };
    }
  } catch (error) {
    alert("Gagal memperbarui kata sandi.");
  } finally {
    isSavingPassword.value = false;
  }
};

onMounted(() => {
  // Coba ambil data dari localStorage dulu untuk fast-render
  const localData = JSON.parse(localStorage.getItem('user'));
  if (localData) {
    user.value = localData;
    form.value.name = localData.name;
    form.value.email = localData.email;
  }
  
  // Panggil API untuk mendapatkan data paling update
  fetchProfile();
});
</script>