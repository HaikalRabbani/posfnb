<template>
  <AdminLayout>
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-ink">Riwayat <span class="text-blue">Transaksi</span></h2>
      <p class="text-muted text-sm">Pantau semua pesanan yang masuk dan status pembayarannya</p>
    </div>

    <div class="bg-white p-5 rounded-xl border border-border shadow-sm mb-6 flex flex-wrap gap-4 items-end">
      <div class="flex-1 min-w-[200px]">
        <label class="block text-[11px] font-bold text-muted uppercase mb-1.5">Cari Order</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-3 flex items-center text-hint">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
          </span>
          <input type="text" placeholder="No. Pesanan / Nama Meja" class="w-full pl-9 pr-4 py-2 border border-border rounded-lg focus:border-blue outline-none text-sm">
        </div>
      </div>
      
      <div class="w-44">
        <label class="block text-[11px] font-bold text-muted uppercase mb-1.5">Status</label>
        <select class="w-full px-3 py-2 border border-border rounded-lg outline-none text-sm bg-white">
          <option>Semua Status</option>
          <option>Selesai (Paid)</option>
          <option>Proses</option>
          <option>Dibatalkan</option>
        </select>
      </div>

      <div class="w-44">
        <label class="block text-[11px] font-bold text-muted uppercase mb-1.5">Tanggal</label>
        <input type="date" class="w-full px-3 py-2 border border-border rounded-lg outline-none text-sm">
      </div>

      <button class="bg-ice text-navy border border-border px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue hover:text-white transition-all">
        Ekspor CSV
      </button>
    </div>

    <div class="bg-white border border-border rounded-xl shadow-sm overflow-hidden">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-surface/50 border-b border-border">
            <th class="p-4 text-[11px] uppercase text-muted font-bold">Waktu & No. Order</th>
            <th class="p-4 text-[11px] uppercase text-muted font-bold">Meja</th>
            <th class="p-4 text-[11px] uppercase text-muted font-bold">Metode</th>
            <th class="p-4 text-[11px] uppercase text-muted font-bold text-right">Total</th>
            <th class="p-4 text-[11px] uppercase text-muted font-bold text-center">Status</th>
            <th class="p-4 text-[11px] uppercase text-muted font-bold text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-sm">
          <tr v-for="i in 5" :key="i" class="border-b border-ice hover:bg-surface transition-colors">
            <td class="p-4">
              <div class="font-bold text-ink">#ORD-02{{ i }}</div>
              <div class="text-[11px] text-muted font-mono">26 Mar 2026, 10:45</div>
            </td>
            <td class="p-4 font-medium text-ink">Meja {{ i + 2 }}</td>
            <td class="p-4">
              <span class="text-[11px] font-bold px-2 py-0.5 bg-ice rounded text-navy uppercase tracking-tighter">QRIS - Midtrans</span>
            </td>
            <td class="p-4 text-right font-mono font-bold text-ink">Rp 125.000</td>
            <td class="p-4 text-center">
              <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-paid/10 text-paid border border-paid/20">Selesai</span>
            </td>
            <td class="p-4 text-center">
              <button @click="showDetail = true" class="text-blue hover:underline font-bold text-xs">Detail Struk</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="showDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-ink/60 backdrop-blur-sm">
      <div class="bg-white w-full max-w-sm rounded-2xl overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="p-6 border-b border-dashed border-border relative">
          <div class="text-center">
            <div class="w-12 h-12 bg-navy text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold">POS</div>
            <h3 class="font-bold text-lg text-ink uppercase tracking-widest">Struk Pesanan</h3>
            <p class="text-xs text-muted font-mono">#ORD-021 • Kasir: Budi</p>
          </div>
          <button @click="showDetail = false" class="absolute top-4 right-4 text-muted hover:text-cancelled">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        
        <div class="p-6 space-y-3">
          <div v-for="j in 3" :key="j" class="flex justify-between text-sm">
            <span class="text-muted">Menu Makanan {{ j }} x1</span>
            <span class="font-mono text-ink">Rp 35.000</span>
          </div>
          <hr class="border-border border-dashed my-4">
          <div class="flex justify-between font-bold text-lg">
            <span>Total</span>
            <span class="font-mono text-blue">Rp 105.000</span>
          </div>
        </div>

        <div class="p-6 bg-surface text-center">
          <button @click="showDetail = false" class="w-full bg-navy text-white py-3 rounded-xl font-bold text-sm shadow-md hover:bg-blue transition-colors">
            Cetak Struk (PDF)
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AdminLayout from '../Components/AdminLayout.vue';

const showDetail = ref(false);
const currentDate = ref('');

onMounted(() => {
  currentDate.value = new Date().toLocaleDateString('id-ID');
});
</script>