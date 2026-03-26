<template>
  <AdminLayout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
      <div>
        <h2 class="text-2xl font-bold text-ink">Laporan  <span class="text-blue">Analitik</span></h2>
        <p class="text-muted text-sm">Analisis performa penjualan dan produk terlaris Anda</p>
      </div>
      <div class="flex items-center gap-3">
        <select class="bg-white border border-border px-4 py-2 rounded-lg text-sm font-bold outline-none">
          <option>7 Hari Terakhir</option>
          <option>Bulan Ini</option>
          <option>Tahun Ini</option>
        </select>
        <button class="bg-navy text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue transition-colors">
          Unduh PDF
        </button>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div v-for="card in summaryCards" :key="card.title" class="bg-white p-6 rounded-2xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <div :class="`p-2 rounded-lg ${card.bgColor} ${card.textColor}`">
            <component :is="card.icon" class="w-6 h-6" />
          </div>
          <span class="text-[10px] font-bold text-paid bg-paid/10 px-2 py-1 rounded-full">+12.5%</span>
        </div>
        <p class="text-muted text-xs font-bold uppercase tracking-wider">{{ card.title }}</p>
        <h3 class="text-2xl font-black text-ink mt-1">{{ card.value }}</h3>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
      <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-6">
          <h4 class="font-bold text-ink">Tren Penjualan Mingguan</h4>
          <div class="flex items-center gap-2">
            <span class="w-3 h-3 bg-blue rounded-full"></span>
            <span class="text-xs text-muted font-medium">Pendapatan (Rp)</span>
          </div>
        </div>
        <div class="h-[300px]">
          <canvas id="salesChart"></canvas>
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl border border-border shadow-sm">
        <h4 class="font-bold text-ink mb-6">Komposisi Kategori</h4>
        <div class="h-[250px] flex items-center justify-center">
          <canvas id="categoryChart"></canvas>
        </div>
        <div class="mt-6 space-y-2">
          <div v-for="(item, index) in categoryData" :key="index" class="flex items-center justify-between text-xs">
            <div class="flex items-center gap-2">
              <span class="w-2 h-2 rounded-full" :style="{ backgroundColor: chartColors[index] }"></span>
              <span class="text-muted font-medium">{{ item.label }}</span>
            </div>
            <span class="font-bold text-ink">{{ item.value }}%</span>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
      <div class="p-6 border-b border-border">
        <h4 class="font-bold text-ink">5 Produk Paling Laris</h4>
      </div>
      <table class="w-full text-left">
        <thead>
          <tr class="bg-surface/50 text-[11px] uppercase text-muted font-bold">
            <th class="px-6 py-4">Nama Produk</th>
            <th class="px-6 py-4 text-center">Terjual</th>
            <th class="px-6 py-4 text-right">Pendapatan</th>
            <th class="px-6 py-4 text-center">Tren</th>
          </tr>
        </thead>
        <tbody class="text-sm font-bold">
          <tr v-for="product in topProducts" :key="product.name" class="border-b border-ice hover:bg-surface/50 transition-colors">
            <td class="px-6 py-4 text-ink">{{ product.name }}</td>
            <td class="px-6 py-4 text-center text-muted">{{ product.sold }} porsi</td>
            <td class="px-6 py-4 text-right text-navy font-mono">{{ formatRupiah(product.revenue) }}</td>
            <td class="px-6 py-4 text-center">
              <span class="text-paid">▲ {{ product.growth }}%</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AdminLayout from '../Components/AdminLayout.vue';
import Chart from 'chart.js/auto';

// Layouting Icons (Manual SVG for simplicity)
const IconTrend = { template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>` };
const IconOrder = { template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>` };
const IconUser = { template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>` };

const summaryCards = [
  { title: 'Total Pendapatan', value: 'Rp 12.450.000', bgColor: 'bg-blue/10', textColor: 'text-blue', icon: IconTrend },
  { title: 'Pesanan Selesai', value: '1.240', bgColor: 'bg-paid/10', textColor: 'text-paid', icon: IconOrder },
  { title: 'Rata-rata Pesanan', value: 'Rp 45.000', bgColor: 'bg-amber-100', textColor: 'text-amber-600', icon: IconTrend },
  { title: 'Pelanggan Baru', value: '85', bgColor: 'bg-purple-100', textColor: 'text-purple-600', icon: IconUser },
];

const topProducts = [
  { name: 'Kopi Susu Aren', sold: 450, revenue: 9000000, growth: 12 },
  { name: 'Nasi Goreng Spesial', sold: 320, revenue: 8000000, growth: 8 },
  { name: 'Mie Ayam Pangsit', sold: 210, revenue: 4200000, growth: 5 },
  { name: 'Es Teh Manis', sold: 180, revenue: 900000, growth: 15 },
  { name: 'Croissant Coklat', sold: 95, revenue: 2375000, growth: 2 },
];

const categoryData = [
  { label: 'Makanan', value: 55 },
  { label: 'Minuman', value: 35 },
  { label: 'Snack', value: 10 },
];

const chartColors = ['#003366', '#0055AA', '#D4E4F4'];

const formatRupiah = (n) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);

onMounted(() => {
  // Sales Chart
  new Chart(document.getElementById('salesChart'), {
    type: 'bar',
    data: {
      labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
      datasets: [{
        label: 'Pendapatan',
        data: [1200000, 1900000, 1500000, 2200000, 2800000, 4500000, 3800000],
        backgroundColor: '#003366',
        borderRadius: 8,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } }
    }
  });

  // Category Chart
  new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
      labels: categoryData.map(d => d.label),
      datasets: [{
        data: categoryData.map(d => d.value),
        backgroundColor: chartColors,
        borderWidth: 0,
        cutout: '70%'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } }
    }
  });
});
</script>