<template>
  <div class="min-h-screen flex text-ink bg-surface">
    
    <aside 
      class="bg-white border-r border-border flex flex-col relative transition-all duration-300 ease-in-out z-20 flex-shrink-0 h-screen"
      :class="isSidebarMinimized ? 'w-20' : 'w-64'"
    >
      <button 
        @click="toggleSidebar" 
        class="absolute -right-3 top-8 bg-white border border-border rounded-full p-1 text-muted hover:text-navy hover:bg-ice transition-colors shadow-sm z-30"
      >
        <svg v-if="!isSidebarMinimized" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
      </button>

      <div class="h-20 flex items-center justify-center p-4 mb-2 overflow-hidden flex-shrink-0 border-b border-ice">
        <h1 class="text-navy font-bold flex items-center gap-2 transition-all duration-300" :class="isSidebarMinimized ? 'text-sm' : 'text-xl'">
          <span class="bg-navy text-white p-2 rounded-lg flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
          </span>
          <div v-show="!isSidebarMinimized" class="flex flex-col">
            <span class="whitespace-nowrap leading-tight">POS F&B</span>
            <span class="text-[10px] text-muted font-normal leading-none">Admin Panel</span>
          </div>
        </h1>
      </div>

      <nav class="flex flex-col gap-1 flex-1 px-3 overflow-y-auto overflow-x-hidden custom-scrollbar pb-4 mt-3">
        
        <div v-show="!isSidebarMinimized" class="text-[11px] font-medium text-muted uppercase tracking-wider mt-2 mb-1 px-3">
          Main
        </div>
        <hr v-show="isSidebarMinimized" class="border-border my-3 mx-2" />

        <router-link to="/dashboard" class="flex items-center gap-3 py-2.5 bg-ice text-navy rounded-lg font-medium transition-colors" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Dashboard">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap">Dashboard</span>
        </router-link>

        <a href="#" class="flex items-center gap-3 py-2.5 text-muted hover:bg-ice hover:text-navy rounded-lg transition-colors" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Laporan & Analitik">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap">Laporan & Analitik</span>
        </a>

        <a href="#" class="flex items-center gap-3 py-2.5 text-muted hover:bg-ice hover:text-navy rounded-lg transition-colors" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Produk Terlaris">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap">Produk Terlaris</span>
        </a>

        <a href="#" class="flex items-center justify-between py-2.5 text-muted hover:bg-ice hover:text-navy rounded-lg transition-colors group" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Riwayat Transaksi">
          <div class="flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span v-show="!isSidebarMinimized" class="whitespace-nowrap">Riwayat Transaksi</span>
          </div>
          <span v-show="!isSidebarMinimized" class="bg-cancelled text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center">3</span>
        </a>

        <div v-show="!isSidebarMinimized" class="text-[11px] font-medium text-muted uppercase tracking-wider mt-5 mb-1 px-3">
          Manajemen
        </div>
        <hr v-show="isSidebarMinimized" class="border-border my-3 mx-2" />

        <a href="#" class="flex items-center gap-3 py-2.5 text-muted hover:bg-ice hover:text-navy rounded-lg transition-colors" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Manajemen Menu">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap">Manajemen Menu</span>
        </a>

        <a href="#" class="flex items-center gap-3 py-2.5 text-muted hover:bg-ice hover:text-navy rounded-lg transition-colors" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Manajemen Kasir">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap">Manajemen Kasir</span>
        </a>

        <div v-show="!isSidebarMinimized" class="text-[11px] font-medium text-muted uppercase tracking-wider mt-5 mb-1 px-3">
          Akun
        </div>
        <hr v-show="isSidebarMinimized" class="border-border my-3 mx-2" />

        <a href="#" class="flex items-center gap-3 py-2.5 text-muted hover:bg-ice hover:text-navy rounded-lg transition-colors" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Profil">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
          <span v-show="!isSidebarMinimized" class="whitespace-nowrap">Profil</span>
        </a>

        <div class="mt-auto pt-5">
            <button @click="handleLogout" class="w-full flex items-center gap-3 py-2.5 text-cancelled hover:bg-red-50 rounded-lg transition-colors font-medium" :class="isSidebarMinimized ? 'justify-center px-0' : 'px-3'" title="Logout">
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
              <span v-show="!isSidebarMinimized" class="whitespace-nowrap">Logout</span>
            </button>
        </div>

      </nav>
      
      </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-surface">
      
      <header class="h-20 bg-surface border-b border-border flex items-center justify-between px-8 flex-shrink-0 z-10">
        <div>
          <h2 class="text-2xl font-bold text-ink">Dashboard</h2>
          <p class="text-muted text-sm">Selamat datang kembali</p>
        </div>

        <div class="flex items-center gap-5">
          
          <div class="hidden md:flex items-center gap-2 text-navy bg-white border border-border px-4 py-2 rounded-full shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="text-[13px] font-medium">{{ currentDate }}</span>
          </div>

          <button class="relative p-2 text-muted hover:text-navy hover:bg-ice rounded-full transition-colors" title="Notifikasi">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="absolute top-1.5 right-2 w-2.5 h-2.5 bg-cancelled rounded-full border-2 border-surface"></span>
          </button>

          <div class="h-8 w-px bg-border"></div>

          <button class="flex items-center gap-3 hover:bg-ice p-1.5 pr-3 rounded-xl transition-colors text-left group">
            <div class="w-9 h-9 rounded-full bg-navy text-white flex items-center justify-center font-bold text-sm shadow-sm group-hover:bg-blue transition-colors">
              AD
            </div>
            <div class="hidden md:block">
              <span class="block text-sm font-bold text-ink leading-tight">Administrator</span>
              <span class="block text-[11px] text-blue font-medium leading-tight mt-0.5">Owner</span>
            </div>
            <svg class="w-4 h-4 text-muted group-hover:text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>

        </div>
      </header>

      <div class="p-8 overflow-y-auto flex-1 custom-scrollbar">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          
          <div class="bg-white border border-border rounded-xl p-5 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex justify-between items-start mb-2">
              <p class="text-muted text-[11px] uppercase tracking-wider font-semibold">Pendapatan Hari Ini</p>
              <div class="p-1.5 bg-ice text-navy rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
            </div>
            <p class="font-mono text-2xl font-bold text-ink">Rp 2.450.000</p>
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
            <p class="font-mono text-2xl font-bold text-ink">38</p>
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
            <p class="font-mono text-2xl font-bold text-ink">35</p>
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
            <p class="font-mono text-2xl font-bold text-ink">3</p>
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
                <div class="flex-1 h-2 bg-ice rounded-full overflow-hidden">
                  <div class="h-full bg-blue rounded-full" style="width: 55%"></div>
                </div>
                <span class="w-12 text-right font-mono text-xs font-medium text-ink">1.200k</span>
              </div>
              <div class="flex items-center gap-3">
                <span class="w-16 text-xs text-muted font-medium">QRIS</span>
                <div class="flex-1 h-2 bg-ice rounded-full overflow-hidden">
                  <div class="h-full bg-sky rounded-full" style="width: 35%"></div>
                </div>
                <span class="w-12 text-right font-mono text-xs font-medium text-ink">950k</span>
              </div>
              <div class="flex items-center gap-3">
                <span class="w-16 text-xs text-muted font-medium">Transfer</span>
                <div class="flex-1 h-2 bg-ice rounded-full overflow-hidden">
                  <div class="h-full bg-hint rounded-full" style="width: 10%"></div>
                </div>
                <span class="w-12 text-right font-mono text-xs font-medium text-ink">300k</span>
              </div>
            </div>
            
          </div>

        </div>

      </div>

    </main>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

// State reaktif
const isSidebarMinimized = ref(false);
const currentDate = ref(''); // Variabel untuk tanggal di topbar

// Generate tanggal hari ini saat komponen dimuat
onMounted(() => {
  const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
  currentDate.value = new Date().toLocaleDateString('id-ID', options);
});

// Fungsi Toggle Sidebar
const toggleSidebar = () => {
  isSidebarMinimized.value = !isSidebarMinimized.value;
};

// Fungsi Logout
const handleLogout = () => {
  // Simulasi logout, hapus session/token nanti di sini
  router.push('/');
};
</script>

<style>
/* Custom style sederhana untuk scrollbar yang rapi */
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #D4E4F4; /* color-border */
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #8AAFCC; /* color-hint */
}
</style>