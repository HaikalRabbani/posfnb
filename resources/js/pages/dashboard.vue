<template>
  <AdminLayout>
    
    <div class="mb-6">
      <h2 class="text-2xl font-bold">Dashboard Overview</h2>
      <p class="text-muted text-sm">Ringkasan performa hari ini</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      
      <div class="bg-white border border-border rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex justify-between items-start mb-2">
          <p class="text-muted text-[11px] uppercase tracking-wider font-semibold">Pendapatan Hari Ini</p>
          <div class="p-1.5 bg-ice text-navy rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          </div>
        </div>
        <p class="font-mono text-2xl font-bold text-ink">{{ formatRupiah(stats.revenue_today) }}</p>
        <p class="text-paid text-xs font-medium mt-3 flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
          12% dari kemarin
        </p>
      </div>

      <div class="bg-white border border-border rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex justify-between items-start mb-2">
          <p class="text-muted text-[11px] uppercase tracking-wider font-semibold">Total Order</p>
          <div class="p-1.5 bg-ice text-navy rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
          </div>
        </div>
        <p class="font-mono text-2xl font-bold text-ink">{{ stats.total_orders }}</p>
        <p class="text-paid text-xs font-medium mt-3 flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
          5 order baru jam ini
        </p>
      </div>

      <div class="bg-white border border-border rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex justify-between items-start mb-2">
          <p class="text-muted text-[11px] uppercase tracking-wider font-semibold">Order Selesai</p>
          <div class="p-1.5 bg-ice text-navy rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          </div>
        </div>
        <p class="font-mono text-2xl font-bold text-ink">{{ stats.completed_orders }}</p>
        <p class="text-paid text-xs font-medium mt-3 flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
          92% success rate
        </p>
      </div>

      <div class="bg-white border border-border rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
        <div class="flex justify-between items-start mb-2">
          <p class="text-muted text-[11px] uppercase tracking-wider font-semibold">Order Pending</p>
          <div class="p-1.5 bg-ice text-pending rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          </div>
        </div>
        <p class="font-mono text-2xl font-bold text-ink">{{ stats.pending_orders }}</p>
        <p class="text-pending text-xs font-medium mt-3 flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
          Perlu segera diproses!
        </p>
      </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-8">
      
      <div class="lg:col-span-2 bg-white border border-border rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-ink font-bold text-lg">Transaksi Terbaru</h3>
          <a href="#" class="text-blue text-sm font-medium hover:underline flex items-center gap-1">
            Lihat semua 
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
          </a>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="border-b border-border">
                <th class="pb-3 text-muted text-[11px] uppercase tracking-wider font-medium">Order</th>
                <th class="pb-3 text-muted text-[11px] uppercase tracking-wider font-medium">Meja</th>
                <th class="pb-3 text-muted text-[11px] uppercase tracking-wider font-medium">Item</th>
                <th class="pb-3 text-muted text-[11px] uppercase tracking-wider font-medium text-right">Total</th>
                <th class="pb-3 text-muted text-[11px] uppercase tracking-wider font-medium text-center w-28">Status</th>
              </tr>
            </thead>
            <tbody class="text-sm">
              <tr class="border-b border-ice hover:bg-surface transition-colors">
                <td class="py-3 font-mono text-blue font-medium">#ORD-018</td>
                <td class="py-3 font-medium text-ink">Meja 5</td>
                <td class="py-3 text-muted truncate max-w-[200px]">Es Kopi Susu ×2, Nasi Goreng ×1</td>
                <td class="py-3 font-mono font-medium text-ink text-right">Rp 79.000</td>
                <td class="py-3 text-center">
                  <span class="inline-block px-2.5 py-1 text-[11px] font-bold rounded-md bg-paid/20 text-[#1A5A35] border border-paid/55">Paid</span>
                </td>
              </tr>
              <tr class="border-b border-ice hover:bg-surface transition-colors">
                <td class="py-3 font-mono text-blue font-medium">#ORD-017</td>
                <td class="py-3 font-medium text-ink">Meja 8</td>
                <td class="py-3 text-muted truncate max-w-[200px]">Juice Alpukat ×2, Pisang Goreng ×3</td>
                <td class="py-3 font-mono font-medium text-ink text-right">Rp 96.000</td>
                <td class="py-3 text-center">
                  <span class="inline-block px-2.5 py-1 text-[11px] font-bold rounded-md bg-ready/20 text-[#085A5A] border border-ready/55">Ready</span>
                </td>
              </tr>
              <tr class="border-b border-ice hover:bg-surface transition-colors">
                <td class="py-3 font-mono text-blue font-medium">#ORD-016</td>
                <td class="py-3 font-medium text-ink">Meja 3</td>
                <td class="py-3 text-muted truncate max-w-[200px]">Teh Tarik ×2</td>
                <td class="py-3 font-mono font-medium text-ink text-right">Rp 30.000</td>
                <td class="py-3 text-center">
                  <span class="inline-block px-2.5 py-1 text-[11px] font-bold rounded-md bg-cancelled/20 text-[#8A2A1A] border border-cancelled/55">Cancelled</span>
                </td>
              </tr>
              <tr class="border-b border-ice hover:bg-surface transition-colors">
                <td class="py-3 font-mono text-blue font-medium">#ORD-015</td>
                <td class="py-3 font-medium text-ink">Meja 1</td>
                <td class="py-3 text-muted truncate max-w-[200px]">Es Kopi Susu ×1, Kentang ×1</td>
                <td class="py-3 font-mono font-medium text-ink text-right">Rp 40.000</td>
                <td class="py-3 text-center">
                  <span class="inline-block px-2.5 py-1 text-[11px] font-bold rounded-md bg-preparing/20 text-[#4A2A7A] border border-preparing/55">Preparing</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col">
        <h3 class="text-ink font-bold text-lg mb-6">Pendapatan per Jam</h3>
        
        <div class="flex items-end justify-between h-32 mb-8 gap-2">
          <div class="w-full bg-ice rounded-t-sm h-[40%] hover:bg-blue transition-colors relative group"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-muted opacity-0 group-hover:opacity-100">120k</span></div>
          <div class="w-full bg-ice rounded-t-sm h-[60%] hover:bg-blue transition-colors relative group"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-muted opacity-0 group-hover:opacity-100">280k</span></div>
          <div class="w-full bg-ice rounded-t-sm h-[80%] hover:bg-blue transition-colors relative group"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-muted opacity-0 group-hover:opacity-100">350k</span></div>
          <div class="w-full bg-blue rounded-t-sm h-[100%] relative"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-navy">420k</span></div>
          <div class="w-full bg-ice rounded-t-sm h-[85%] hover:bg-blue transition-colors relative group"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-muted opacity-0 group-hover:opacity-100">380k</span></div>
          <div class="w-full bg-ice rounded-t-sm h-[65%] hover:bg-blue transition-colors relative group"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-muted opacity-0 group-hover:opacity-100">310k</span></div>
        </div>
        
        <div class="flex justify-between text-[11px] text-muted font-mono mb-8 px-1">
          <span>09</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span>
        </div>

        <div class="mt-auto flex flex-col gap-4">
          <div class="flex items-center gap-3">
            <span class="w-16 text-xs text-muted font-medium">Tunai</span>
            <div class="flex-1 h-2 bg-ice rounded-full overflow-hidden"><div class="h-full bg-blue rounded-full" style="width: 55%"></div></div>
            <span class="w-12 text-right font-mono text-xs font-medium text-ink">1.200k</span>
          </div>
          <div class="flex items-center gap-3">
            <span class="w-16 text-xs text-muted font-medium">QRIS</span>
            <div class="flex-1 h-2 bg-ice rounded-full overflow-hidden"><div class="h-full bg-sky rounded-full" style="width: 35%"></div></div>
            <span class="w-12 text-right font-mono text-xs font-medium text-ink">950k</span>
          </div>
          <div class="flex items-center gap-3">
            <span class="w-16 text-xs text-muted font-medium">Transfer</span>
            <div class="flex-1 h-2 bg-ice rounded-full overflow-hidden"><div class="h-full bg-hint rounded-full" style="width: 10%"></div></div>
            <span class="w-12 text-right font-mono text-xs font-medium text-ink">300k</span>
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

// State untuk menyimpan data statistik dari API
const stats = ref({
  revenue_today: 0,
  total_orders: 0,
  completed_orders: 0,
  pending_orders: 0
});

// Fungsi untuk format angka ke Rupiah
const formatRupiah = (angka) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  }).format(angka);
};

// Fungsi untuk menembak API Laravel
const fetchDashboardStats = async () => {
  try {
    const response = await axios.get('/api/dashboard-stats');
    if (response.data.status === 'success') {
      stats.value = response.data.data;
    }
  } catch (error) {
    console.error('Gagal mengambil data statistik:', error);
  }
};

// Dijalankan otomatis saat halaman Dashboard dibuka
onMounted(() => {
  fetchDashboardStats();
});
</script>