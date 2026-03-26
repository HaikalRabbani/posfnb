<template>
  <AdminLayout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
      <div>
        <h2 class="text-2xl font-black text-ink tracking-tight">Manajemen <span class="text-blue">Menu</span></h2>
        <p class="text-muted text-sm font-medium">Cari, filter, dan kelola produk menu Anda.</p>
      </div>
      
      <div class="flex items-center gap-3 w-full sm:w-auto">
        <button @click="openCategoryModal" class="bg-white border border-border text-navy hover:bg-ice px-4 py-2.5 rounded-xl font-bold transition-all shadow-sm">
          Kelola Kategori
        </button>
        <button @click="openProductModal()" class="bg-blue hover:bg-navy text-white px-5 py-2.5 rounded-xl font-bold transition-all flex items-center justify-center gap-2 shadow-md">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          Tambah Menu
        </button>
      </div>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-border shadow-sm mb-6 flex flex-col lg:flex-row gap-4">
      <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-hint">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input v-model="searchQuery" type="text" class="w-full pl-10 pr-4 py-2.5 border border-border rounded-xl focus:border-blue outline-none text-sm font-bold" placeholder="Cari nama menu...">
      </div>
      
      <div class="sm:w-48">
        <select v-model="selectedFilterCategory" class="w-full px-4 py-2.5 border border-border rounded-xl focus:border-blue outline-none bg-white text-sm font-bold appearance-none cursor-pointer">
          <option value="">Semua Kategori</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
        </select>
      </div>

      <div class="sm:w-32 flex items-center gap-2">
        <span class="text-[10px] font-black text-muted uppercase">Baris:</span>
        <select v-model="perPage" class="flex-1 px-2 py-2 border border-border rounded-xl focus:border-blue bg-white text-sm font-bold cursor-pointer">
          <option :value="5">5</option>
          <option :value="10">10</option>
          <option :value="20">20</option>
        </select>
      </div>
    </div>

    <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden font-bold">
      <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[750px]">
          <thead>
            <tr class="border-b border-border bg-surface/50 text-[11px] uppercase text-muted tracking-widest font-black">
              <th class="py-4 px-6">Produk & Foto</th>
              <th class="py-4 px-6 text-right">Harga Jual</th>
              <th class="py-4 px-6 text-center">Stok</th>
              <th class="py-4 px-6 text-center">Status</th>
              <th class="py-4 px-6 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-sm">
            <tr v-if="isLoadingData">
              <td colspan="5" class="py-12 text-center text-muted font-normal italic">Sinkronisasi data menu...</td>
            </tr>
            <tr v-else-if="paginatedProducts.length === 0">
              <td colspan="5" class="py-12 text-center text-muted font-normal italic">Menu tidak ditemukan.</td>
            </tr>
            
            <tr v-for="product in paginatedProducts" :key="product.id" 
                class="border-b border-ice transition-all duration-300"
                :class="(!product.status || product.stock <= 0) ? 'bg-surface opacity-50 grayscale' : 'hover:bg-surface/50'">
              
              <td class="py-4 px-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-ice border border-border flex items-center justify-center flex-shrink-0 overflow-hidden shadow-sm bg-white">
                   <img v-if="product.image" :src="getImageUrl(product.image)" class="w-full h-full object-cover" />
                   <svg v-else class="w-5 h-5 text-hint opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                  <p :class="(product.status && product.stock > 0) ? 'text-ink' : 'text-muted line-through italic'">{{ product.name }}</p>
                  <p class="text-[10px] font-black text-blue uppercase tracking-tighter">{{ product.category?.name || 'Uncategorized' }}</p>
                </div>
              </td>

              <td class="py-4 px-6 text-right font-mono text-navy">{{ formatRupiah(product.price) }}</td>
              <td class="py-4 px-6 text-center font-mono">{{ product.stock }}</td>
              
              <td class="py-4 px-6 text-center">
                <button @click="toggleProductStatus(product)" 
                        class="px-3 py-1 text-[10px] font-black rounded-full border transition-all uppercase"
                        :class="(product.status && product.stock > 0) ? 'bg-paid/10 text-paid border-paid/30' : 'bg-cancelled/10 text-cancelled border-cancelled/30'">
                  {{ (product.status && product.stock > 0) ? 'Tersedia' : 'Habis' }}
                </button>
              </td>

              <td class="py-4 px-6 text-right">
                <div class="flex items-center justify-end gap-2 font-normal">
                  <button @click="openProductModal(product)" class="p-1.5 text-muted hover:text-blue transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                  <button @click="confirmDelete('product', product)" class="p-1.5 text-muted hover:text-cancelled transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="p-4 bg-surface/30 border-t border-border flex justify-between items-center text-[11px] font-black uppercase tracking-widest">
        <p class="text-muted">{{ paginatedProducts.length }} dari {{ filteredAndSortedProducts.length }} Menu</p>
        <div class="flex items-center gap-2">
          <button @click="currentPage--" :disabled="currentPage === 1" class="p-1.5 border border-border rounded bg-white disabled:opacity-30 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
          <span class="text-navy w-16 text-center">Hal {{ currentPage }}</span>
          <button @click="currentPage++" :disabled="currentPage >= totalPages" class="p-1.5 border border-border rounded bg-white disabled:opacity-30 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
        </div>
      </div>
    </div>

    <div v-if="isProductModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-ink/60 backdrop-blur-sm" @click="closeProductModal"></div>
      <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg z-10 overflow-hidden flex flex-col max-h-[90vh] font-bold">
        <div class="p-6 border-b border-border flex justify-between items-center bg-white">
          <h3 class="text-xl font-black text-ink uppercase tracking-tight">{{ isEditMode ? 'Edit Menu' : 'Tambah Menu' }}</h3>
          <button @click="closeProductModal" class="text-muted hover:text-cancelled"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1 bg-white space-y-5">
          <div class="flex flex-col items-center justify-center border-2 border-dashed border-border rounded-2xl p-3 transition-all hover:bg-ice cursor-pointer relative" @click="$refs.fileInput.click()">
            <input type="file" ref="fileInput" class="hidden" accept="image/*" @change="handleFileChange">
            <div v-if="imagePreview" class="w-full h-44 rounded-xl overflow-hidden shadow-inner relative bg-white">
               <img :src="imagePreview" class="w-full h-full object-cover" />
            </div>
            <div v-else class="text-center py-6">
              <svg class="w-10 h-10 text-hint mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
              <p class="text-[10px] text-muted uppercase tracking-widest font-black">Klik untuk upload foto</p>
            </div>
          </div>

          <div>
            <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Nama Menu</label>
            <input v-model="productForm.name" type="text" class="w-full border border-border rounded-xl px-4 py-3 outline-none focus:border-blue transition-all" :class="errors.name ? 'border-cancelled bg-red-50' : ''">
            <p v-if="errors.name" class="text-[10px] text-cancelled mt-1 italic">{{ errors.name }}</p>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Kategori</label>
              <select v-model="productForm.category_id" class="w-full border border-border rounded-xl px-4 py-3 outline-none bg-white">
                <option value="" disabled>Pilih Kategori</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
              </select>
            </div>
            <div>
              <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Stok Awal</label>
              <input v-model="productForm.stock" type="number" class="w-full border border-border rounded-xl px-4 py-3 outline-none font-mono">
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
             <div>
              <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Harga Beli (Modal)</label>
              <input v-model="productForm.cost_price" type="number" class="w-full border border-border rounded-xl px-4 py-3 outline-none font-mono" placeholder="Wajib">
            </div>
            <div>
              <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Harga Jual</label>
              <input v-model="productForm.price" type="number" class="w-full border border-border rounded-xl px-4 py-3 outline-none font-mono">
            </div>
          </div>

          <div>
            <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Status Publikasi</label>
            <select v-model="productForm.status" class="w-full border border-border rounded-xl px-4 py-3 outline-none bg-white">
              <option :value="true">Tersedia (Aktif)</option>
              <option :value="false">Habis (Disembunyikan)</option>
            </select>
          </div>
        </div>

        <div class="p-6 border-t border-border bg-surface/50 flex justify-end gap-3 font-black">
          <button @click="closeProductModal" class="px-6 py-3 text-ink hover:bg-border rounded-xl transition-all">Batal</button>
          <button @click="saveProduct" :disabled="isSaving" class="px-8 py-3 bg-navy text-white rounded-xl shadow-lg disabled:opacity-50 transition-all uppercase tracking-widest text-[11px]">
            {{ isSaving ? 'Proses...' : 'Simpan Menu' }}
          </button>
        </div>
      </div>
    </div>

    <div v-if="isCategoryModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-ink/60 backdrop-blur-sm" @click="closeCategoryModal"></div>
      <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md z-10 overflow-hidden flex flex-col max-h-[90vh] font-bold">
        <div class="p-6 border-b border-border flex justify-between items-center bg-white">
          <h3 class="text-xl font-black text-ink uppercase tracking-tight">Kelola Kategori</h3>
          <button @click="closeCategoryModal" class="text-muted hover:text-cancelled"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        
        <div class="p-6 flex-1 overflow-y-auto bg-white custom-scrollbar">
          <form @submit.prevent="saveCategory" class="flex flex-col gap-3 mb-6 border-b border-border pb-6">
            <div>
              <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Nama Kategori</label>
              <input v-model="categoryForm.name" type="text" required class="w-full border border-border rounded-xl px-4 py-2.5 outline-none focus:border-blue transition-all text-sm" placeholder="Contoh: Minuman Dingin">
            </div>
            <div>
              <label class="block text-[10px] font-black uppercase text-muted tracking-widest mb-1.5">Deskripsi</label>
              <input v-model="categoryForm.description" type="text" class="w-full border border-border rounded-xl px-4 py-2.5 outline-none focus:border-blue transition-all text-sm font-normal" placeholder="Keterangan singkat (opsional)">
            </div>
            <div class="flex gap-2 mt-2">
                <button type="submit" :disabled="isSaving" class="flex-1 bg-blue hover:bg-navy transition-colors text-white py-2.5 rounded-xl text-xs uppercase tracking-widest font-black shadow-md">
                  {{ categoryForm.id ? 'Perbarui Kategori' : 'Tambah Kategori' }}
                </button>
                <button v-if="categoryForm.id" @click="resetCategoryForm" type="button" class="px-4 py-2.5 bg-surface border border-border rounded-xl text-xs uppercase tracking-widest font-black hover:bg-ice transition-colors">Batal</button>
            </div>
          </form>

          <p class="text-[10px] font-black uppercase text-muted tracking-widest mb-3">Daftar Kategori Tersedia</p>
          <ul class="flex flex-col gap-2">
            <li v-if="categories.length === 0" class="text-center text-xs text-muted py-4 italic font-normal">Belum ada kategori.</li>
            <li v-for="cat in categories" :key="cat.id" class="flex items-center justify-between p-3 border border-ice rounded-xl hover:bg-surface transition-colors">
              <span class="font-bold text-ink text-sm">{{ cat.name }}</span>
              <div class="flex gap-1 font-normal">
                <button @click="editCategory(cat)" class="p-1.5 text-muted hover:text-blue transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                <button @click="confirmDelete('category', cat)" class="p-1.5 text-muted hover:text-cancelled transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div v-if="deleteState.isOpen" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-ink/70 backdrop-blur-sm" @click="cancelDelete"></div>
      <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm z-10 overflow-hidden flex flex-col font-bold text-center p-6 relative transform transition-all">
        <div class="w-16 h-16 bg-cancelled/10 text-cancelled rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        
        <h3 class="text-xl font-black text-ink uppercase tracking-tight mb-2">
          Hapus {{ deleteState.type === 'product' ? 'Menu' : 'Kategori' }}?
        </h3>
        
        <p class="text-sm text-muted font-medium mb-6">
          Apakah Anda yakin ingin menghapus <span class="text-ink font-black">"{{ deleteState.name }}"</span>?<br>
          <span v-if="deleteState.type === 'category'" class="text-[11px] text-cancelled/80 mt-1 block leading-tight">Perhatian: Menu yang menggunakan kategori ini mungkin akan terpengaruh.</span>
          <span v-else class="text-[11px] mt-1 block">Tindakan ini tidak dapat dibatalkan.</span>
        </p>
        
        <div class="flex gap-3">
          <button @click="cancelDelete" class="flex-1 px-4 py-3 bg-surface border border-border text-ink hover:bg-ice rounded-xl transition-all">Batal</button>
          <button @click="executeDelete" :disabled="deleteState.isDeleting" class="flex-1 px-4 py-3 bg-cancelled hover:bg-red-600 text-white rounded-xl shadow-lg disabled:opacity-50 transition-all uppercase tracking-widest text-[11px]">
            {{ deleteState.isDeleting ? 'Menghapus...' : 'Ya, Hapus' }}
          </button>
        </div>
      </div>
    </div>

  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import AdminLayout from '../Components/AdminLayout.vue';
import axios from 'axios';

// API Setup
const api = axios.create({
  baseURL: 'https://api.etres.my.id/api',
  headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${localStorage.getItem('auth_token')}` }
});

// States
const products = ref([]);
const categories = ref([]);
const isLoadingData = ref(false);
const isSaving = ref(false);
const errors = ref({});

// State Pencarian & Pagination
const searchQuery = ref('');
const selectedFilterCategory = ref('');
const perPage = ref(10);
const currentPage = ref(1);

// State Modal Produk 
const isProductModalOpen = ref(false);
const isEditMode = ref(false);
const imagePreview = ref(null);
const productForm = ref({ id: null, name: '', category_id: '', price: '', cost_price: '', stock: 0, status: true, image: null });

// State Modal Kategori
const isCategoryModalOpen = ref(false);
const categoryForm = ref({ id: null, name: '', description: '' });

// ---------------------------------------------
// NEW: STATE MODAL HAPUS UNIVERSAL
// ---------------------------------------------
const deleteState = ref({
  isOpen: false,
  type: '', // 'product' atau 'category'
  id: null,
  name: '',
  isDeleting: false
});

const confirmDelete = (type, item) => {
  deleteState.value = {
    isOpen: true,
    type: type,
    id: item.id,
    name: item.name,
    isDeleting: false
  };
};

const cancelDelete = () => {
  deleteState.value.isOpen = false;
};

const executeDelete = async () => {
  deleteState.value.isDeleting = true;
  try {
    if (deleteState.value.type === 'product') {
      await api.delete(`/products/${deleteState.value.id}`);
    } else if (deleteState.value.type === 'category') {
      await api.delete(`/categories/${deleteState.value.id}`);
    }
    cancelDelete();
    fetchData(); // Refresh tabel setelah hapus
  } catch (e) {
    alert(`Gagal menghapus ${deleteState.value.type === 'product' ? 'menu' : 'kategori'}.`);
  } finally {
    deleteState.value.isDeleting = false;
  }
};
// ---------------------------------------------

// HELPER: Penentu URL Gambar yang Pintar
const getImageUrl = (imagePath) => {
  if (!imagePath) return null;
  if (imagePath.startsWith('http') || imagePath.startsWith('data:')) return imagePath;
  if (imagePath.startsWith('uploads/')) return `https://api.etres.my.id/${imagePath}`;
  return `https://api.etres.my.id/storage/${imagePath}`;
};

// LOGIKA FILTER, SORTING & PAGINATION
const filteredAndSortedProducts = computed(() => {
  let res = products.value.filter(p => {
    const matchName = (p.name || '').toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchCat = selectedFilterCategory.value === '' || p.category_id == selectedFilterCategory.value;
    return matchName && matchCat;
  });
  
  return res.sort((a, b) => {
    const aAvail = (a.status && a.stock > 0) ? 1 : 0;
    const bAvail = (b.status && b.stock > 0) ? 1 : 0;
    return bAvail - aAvail;
  });
});

const totalPages = computed(() => Math.ceil(filteredAndSortedProducts.value.length / perPage.value) || 1);
const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  return filteredAndSortedProducts.value.slice(start, start + perPage.value);
});

watch([searchQuery, selectedFilterCategory, perPage], () => currentPage.value = 1);

// FUNGSI UMUM 
const fetchData = async () => {
  isLoadingData.value = true;
  try {
    const [catRes, prodRes] = await Promise.all([api.get('/categories'), api.get('/products')]);
    categories.value = catRes.data || [];
    products.value = prodRes.data || [];
  } catch (e) { 
    console.error(e); 
  } finally { 
    isLoadingData.value = false; 
  }
};

const formatRupiah = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n || 0);

// FUNGSI CRUD PRODUK
const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    if (file.size > 5 * 1024 * 1024) return alert("Maksimal ukuran foto adalah 5MB!"); 
    productForm.value.image = file;
    const reader = new FileReader();
    reader.onload = (res) => { imagePreview.value = res.target.result; };
    reader.readAsDataURL(file);
  }
};

const openProductModal = (p = null) => {
  errors.value = {};
  if (p) {
    isEditMode.value = true;
    productForm.value = { ...p, image: null, cost_price: p.cost_price || 0 }; 
    imagePreview.value = getImageUrl(p.image);
  } else {
    isEditMode.value = false;
    productForm.value = { id: null, name: '', category_id: '', price: '', cost_price: '', stock: 0, status: true, image: null };
    imagePreview.value = null;
  }
  isProductModalOpen.value = true;
};

const closeProductModal = () => isProductModalOpen.value = false;

const saveProduct = async () => {
  errors.value = {};
  if (!productForm.value.name) { errors.value.name = "Nama menu wajib diisi"; return; }

  isSaving.value = true;
  const formData = new FormData();
  formData.append('name', productForm.value.name);
  formData.append('category_id', productForm.value.category_id);
  formData.append('price', productForm.value.price);
  formData.append('cost_price', productForm.value.cost_price || 0);
  formData.append('stock', productForm.value.stock);
  formData.append('status', productForm.value.status ? 1 : 0);
  
  if (productForm.value.image) {
    formData.append('image', productForm.value.image);
  }

  try {
    if (isEditMode.value) {
      formData.append('_method', 'PUT');
      await api.post(`/products/${productForm.value.id}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
    } else {
      await api.post('/products', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });
    }
    closeProductModal(); 
    fetchData();
  } catch (e) {
    alert("Error: " + (e.response?.data?.message || "Gagal menyimpan. Pastikan semua data lengkap."));
  } finally {
    isSaving.value = false;
  }
};

const toggleProductStatus = async (p) => {
  const newStatus = !p.status;
  try {
    await api.put(`/products/${p.id}`, { ...p, status: newStatus });
    p.status = newStatus;
  } catch (e) { alert("Gagal update status"); }
};

// FUNGSI CRUD KATEGORI
const openCategoryModal = () => { isCategoryModalOpen.value = true; resetCategoryForm(); };
const closeCategoryModal = () => { isCategoryModalOpen.value = false; };
const resetCategoryForm = () => { categoryForm.value = { id: null, name: '', description: '' }; };

const editCategory = (c) => { 
  categoryForm.value = { id: c.id, name: c.name, description: c.description || '' }; 
};

const saveCategory = async () => {
  if (!categoryForm.value.name) return;
  isSaving.value = true;
  try {
    const payload = { name: categoryForm.value.name, description: categoryForm.value.description };
    if (categoryForm.value.id) await api.put(`/categories/${categoryForm.value.id}`, payload);
    else await api.post('/categories', payload);
    
    resetCategoryForm(); 
    fetchData();
  } catch (e) { alert("Gagal menyimpan kategori"); }
  finally { isSaving.value = false; }
};

onMounted(fetchData);
</script>