import { createRouter, createWebHistory } from 'vue-router';
import Login from '../Pages/Login.vue';
import Dashboard from '../Pages/Dashboard.vue';
import ManajemenMenu from '../Pages/ManajemenMenu.vue';
import RiwayatTransaksi from '../Pages/RiwayatTransaksi.vue';
import LaporanAnalitik from '../Pages/LaporanAnalitik.vue';
import ManajemenKasir from '../Pages/ManajemenKasir.vue';
import ProfileSetting from '../pages/ProfileSetting.vue';

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard
    },
    {
        path: '/menu',           
        name: 'ManajemenMenu',
        component: ManajemenMenu
    },
    {
        path: '/transaksi',
        name: 'RiwayatTransaksi',
        component: RiwayatTransaksi
    },
    {
        path: '/laporan',
        name: 'LaporanAnalitik',
        component: LaporanAnalitik,
        meta: { requiresAuth: true } // Jika kamu pakai guard
    },
    {
        path: '/kasir', // Ganti dari /users jadi /kasir
        name: 'ManajemenKasir',
        component: ManajemenKasir
    },
    {
    path: '/profile-setting',
    name: 'ProfileSetting',
    component: ProfileSetting,
    // (Opsional) tambahkan meta requiresAuth jika kamu pakai navigation guard
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;