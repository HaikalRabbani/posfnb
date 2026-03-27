import { createRouter, createWebHistory } from 'vue-router';
import Login from '../Pages/Login.vue';
import ForgotPassword from '../Pages/ForgotPassword.vue'; 
import ResetPassword from '../Pages/ResetPassword.vue';   
import Dashboard from '../Pages/Dashboard.vue';
import ManajemenMenu from '../Pages/ManajemenMenu.vue';
import RiwayatTransaksi from '../Pages/RiwayatTransaksi.vue';
import LaporanAnalitik from '../Pages/LaporanAnalitik.vue';
import ManajemenKasir from '../Pages/ManajemenKasir.vue';

const routes = [
    { path: '/', name: 'Login', component: Login },
    { path: '/forgot-password', name: 'ForgotPassword', component: ForgotPassword },
    { path: '/reset-password', name: 'ResetPassword', component: ResetPassword },
    { path: '/dashboard', name: 'Dashboard', component: Dashboard },
    { path: '/menu', name: 'ManajemenMenu', component: ManajemenMenu },
    { path: '/transaksi', name: 'RiwayatTransaksi', component: RiwayatTransaksi },
    { path: '/laporan', name: 'LaporanAnalitik', component: LaporanAnalitik },
    { path: '/kasir', name: 'ManajemenKasir', component: ManajemenKasir }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// ==========================================
// PENJAGA PINTU (NAVIGATION GUARD)
// ==========================================
router.beforeEach((to, from, next) => {
    // Ambil data user dari localStorage
    const userString = localStorage.getItem('user');
    const user = userString ? JSON.parse(userString) : null;

    // 1. Daftar halaman yang HANYA boleh dibuka oleh Manager & Developer
    const adminOnlyRoutes = ['/menu', '/laporan', '/kasir'];

    // 2. Cegah akses jika mencoba masuk ke halaman adminOnlyRoutes
    if (adminOnlyRoutes.includes(to.path)) {
        
        // Kalau belum login, lempar ke halaman login
        if (!user) {
            return next('/');
        }
        
        // Kalau yang login KARYAWAN BIASA, tolak aksesnya!
        if (user.role === 'karyawan') {
            alert('Akses Ditolak: Fitur ini khusus untuk Manager dan Developer!');
            return next('/dashboard'); // Kembalikan ke dashboard
        }
    }

    // Kalau lolos semua pengecekan, silakan lewat
    next();
});

export default router;