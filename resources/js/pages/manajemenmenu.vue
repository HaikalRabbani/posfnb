<template>
  <AdminLayout>
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
      <div>
        <h2 class="text-2xl font-bold text-ink">Manajemen Menu</h2>
        <p class="text-muted text-sm">Kelola daftar produk, kategori, dan ketersediaan</p>
      </div>
      
      <div class="flex items-center gap-3 w-full sm:w-auto">
        <button @click="openCategoryModal" class="flex-1 sm:flex-none bg-white border border-border text-navy hover:bg-ice px-4 py-2.5 rounded-lg font-medium transition-colors shadow-sm">
          Kelola Kategori
        </button>
        <button @click="openProductModal" class="flex-1 sm:flex-none bg-blue hover:bg-navy text-white px-5 py-2.5 rounded-lg font-medium transition-colors flex items-center justify-center gap-2 shadow-sm">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          Tambah Produk
        </button>
      </div>
    </div>

    <div class="bg-white p-4 rounded-xl border border-border shadow-sm mb-6 flex flex-col sm:flex-row gap-4">
      <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="w-5 h-5 text-hint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input 
          v-model="searchQuery" 
          type="text" 
          class="w-full pl-10 pr-4 py-2 border border-border rounded-lg focus:outline-none focus:border-blue placeholder-hint text-ink" 
          placeholder="Cari nama produk..."
        >
      </div>
      
      <div class="sm:w-64">
        <select v-model="selectedFilterCategory" class="w-full px-4 py-2 border border-border rounded-lg focus:outline-none focus:border-blue bg-white text-ink appearance-none">
          <option value="">Semua Kategori</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>
    </div>

    <div class="bg-white border border-border rounded-xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[600px]">
          <thead>
            <tr class="border-b border-border bg-surface/50">
              <th class="py-4 px-6 text-muted text-[11px] uppercase tracking-wider font-semibold">Produk</th>
              <th class="py-4 px-6 text-muted text-[11px] uppercase tracking-wider font-semibold text-right">Harga</th>
              <th class="py-4 px-6 text-muted text-[11px] uppercase tracking-wider font-semibold text-center">Status</th>
              <th class="py-4 px-6 text-muted text-[11px] uppercase tracking-wider font-semibold text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-sm">
            <tr v-if="filteredProducts.length === 0">
              <td colspan="4" class="py-8 text-center text-muted">
                Tidak ada produk yang ditemukan.
              </td>
            </tr>
            <tr v-else v-for="product in filteredProducts" :key="product.id" class="border-b border-ice hover:bg-surface transition-colors">
              <td class="py-4 px-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-ice border border-border flex items-center justify-center flex-shrink-0 text-hint overflow-hidden">
                  <svg v-if="!product.image_path" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                  <img v-else :src="product.image_path" alt="Product" class="w-full h-full object-cover">
                </div>
                <div>
                  <p class="font-bold text-ink">{{ product.name }}</p>
                  <p class="text-[11px] font-medium text-muted mt-0.5">{{ product.category?.name || 'Tanpa Kategori' }}</p>
                </div>
              </td>
              <td class="py-4 px-6 text-right font-mono font-bold text-ink">
                {{ formatRupiah(product.price) }}
              </td>
              <td class="py-4 px-6 text-center">
                <button 
                  @click="toggleProductStatus(product)"
                  class="inline-flex px-3 py-1 text-xs font-bold rounded-full border transition-colors"
                  :class="product.is_available ? 'bg-paid/10 text-paid border-paid/30' : 'bg-muted/10 text-muted border-muted/30'"
                >
                  {{ product.is_available ? 'Tersedia' : 'Habis' }}
                </button>
              </td>
              <td class="py-4 px-6 text-right">
                <div class="flex items-center justify-end gap-2">
                  <button class="p-1.5 text-muted hover:text-blue hover:bg-ice rounded transition-colors" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                  </button>
                  <button class="p-1.5 text-muted hover:text-cancelled hover:bg-red-50 rounded transition-colors" title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-if="isProductModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-ink/50 backdrop-blur-sm" @click="closeProductModal"></div>
      
      <div class="bg-white rounded-xl shadow-lg w-full max-w-lg z-10 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="p-6 border-b border-border flex justify-between items-center bg-white">
          <h3 class="text-xl font-bold text-ink">Tambah Produk Baru</h3>
          <button @click="closeProductModal" class="text-muted hover:text-cancelled transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        
        <div class="p-6 overflow-y-auto custom-scrollbar flex-1 bg-white">
          <form class="flex flex-col gap-4">
            <div class="border-2 border-dashed border-border rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-surface transition-colors cursor-pointer group">
              <div class="w-12 h-12 bg-ice rounded-full flex items-center justify-center text-blue mb-2 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
              </div>
              <p class="text-sm font-medium text-ink">Klik untuk unggah foto</p>
              <p class="text-[11px] text-muted mt-1">PNG, JPG max 2MB</p>
            </div>

            <div>
              <label class="block text-xs font-semibold text-muted mb-1 uppercase tracking-wider">Nama Produk</label>
              <input v-model="productForm.name" type="text" class="w-full border border-border rounded-lg px-4 py-2.5 focus:outline-none focus:border-blue placeholder-hint text-ink" placeholder="Misal: Nasi Goreng Spesial">
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-muted mb-1 uppercase tracking-wider">Kategori</label>
                <select v-model="productForm.category_id" class="w-full border border-border rounded-lg px-4 py-2.5 focus:outline-none focus:border-blue bg-white text-ink">
                  <option value="" disabled>Pilih Kategori</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-muted mb-1 uppercase tracking-wider">Harga (Rp)</label>
                <input v-model="productForm.price" type="number" class="w-full border border-border rounded-lg px-4 py-2.5 focus:outline-none focus:border-blue font-mono placeholder-hint text-ink" placeholder="25000">
              </div>
            </div>
          </form>
        </div>
        
        <div class="p-6 border-t border-border bg-surface flex justify-end gap-3">
          <button @click="closeProductModal" class="px-5 py-2.5 text-ink font-medium hover:bg-border rounded-lg transition-colors">Batal</button>
          <button @click="saveProduct" class="px-5 py-2.5 bg-blue hover:bg-navy text-white font-medium rounded-lg transition-colors shadow-sm">Simpan Produk</button>
        </div>
      </div>
    </div>

    <div v-if="isCategoryModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-ink/50 backdrop-blur-sm" @click="closeCategoryModal"></div>
      
      <div class="bg-white rounded-xl shadow-lg w-full max-w-md z-10 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="p-6 border-b border-border flex justify-between items-center bg-white">
          <h3 class="text-xl font-bold text-ink">Kelola Kategori</h3>
          <button @click="closeCategoryModal" class="text-muted hover:text-cancelled transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        
        <div class="p-6 flex-1 overflow-y-auto custom-scrollbar bg-white">
          <div class="flex gap-2 mb-6">
            <input v-model="newCategoryName" type="text" class="flex-1 border border-border rounded-lg px-4 py-2 focus:outline-none focus:border-blue placeholder-hint text-sm text-ink" placeholder="Nama kategori baru...">
            <button @click="saveCategory" class="bg-blue hover:bg-navy text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm whitespace-nowrap">
              Tambah
            </button>
          </div>

          <h4 class="text-xs font-semibold text-muted uppercase tracking-wider mb-3">Daftar Kategori</h4>
          <ul class="flex flex-col gap-2">
            <li v-for="category in categories" :key="category.id" class="flex items-center justify-between p-3 border border-ice rounded-lg hover:bg-surface transition-colors">
              <span class="font-medium text-ink text-sm">{{ category.name }}</span>
              <div class="flex gap-1">
                <button class="p-1 text-muted hover:text-blue rounded" title="Edit">
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </button>
                <button class="p-1 text-muted hover:text-cancelled rounded" title="Hapus">
                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import AdminLayout from '../Components/AdminLayout.vue';
import axios from 'axios';

// --- STATE DATA ---
const products = ref([]);
const categories = ref([]);

// --- STATE FILTER & SEARCH ---
const searchQuery = ref('');
const selectedFilterCategory = ref('');

// --- STATE MODAL & FORM PRODUK ---
const isProductModalOpen = ref(false);
const productForm = ref({
  name: '',
  category_id: '',
  price: '',
  image: null
});

// --- STATE MODAL & FORM KATEGORI ---
const isCategoryModalOpen = ref(false);
const newCategoryName = ref('');

// --- UTILITIES ---
const formatRupiah = (angka) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
};

// --- API FETCH ---
const fetchData = async () => {
  try {
    const response = await axios.get('/api/products-data');
    if (response.data.status === 'success') {
      products.value = response.data.data.products;
      categories.value = response.data.data.categories;
    }
  } catch (error) {
    console.error("Gagal mengambil data menu", error);
  }
};

// --- COMPUTED: FILTER PRODUK ---
const filteredProducts = computed(() => {
  return products.value.filter(product => {
    const matchName = product.name.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchCategory = selectedFilterCategory.value === '' || product.category_id === selectedFilterCategory.value;
    return matchName && matchCategory;
  });
});

// --- ACTIONS: PRODUK ---
const openProductModal = () => isProductModalOpen.value = true;
const closeProductModal = () => {
  isProductModalOpen.value = false;
  // Reset form
  productForm.value = { name: '', category_id: '', price: '', image: null };
};

const saveProduct = () => {
  // Placeholder: Nanti akan tembak API POST /api/products
  console.log("Menyimpan produk:", productForm.value);
  alert("Fungsi simpan produk akan segera dihubungkan ke API!");
  closeProductModal();
};

const toggleProductStatus = (product) => {
  // Placeholder: Nanti akan tembak API PUT /api/products/{id}/status
  product.is_available = !product.is_available;
};

// --- ACTIONS: KATEGORI ---
const openCategoryModal = () => isCategoryModalOpen.value = true;
const closeCategoryModal = () => {
  isCategoryModalOpen.value = false;
  newCategoryName.value = '';
};

const saveCategory = () => {
  // Placeholder: Nanti akan tembak API POST /api/categories
  console.log("Menambah kategori:", newCategoryName.value);
  if (newCategoryName.value.trim() !== '') {
    // Simulasi tambah ke UI sementara
    categories.value.push({ id: Date.now(), name: newCategoryName.value });
    newCategoryName.value = '';
  }
};

// --- LIFECYCLE ---
onMounted(() => {
  fetchData();
});
</script>