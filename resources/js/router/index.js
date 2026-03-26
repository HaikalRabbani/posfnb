import { createRouter, createWebHistory } from 'vue-router';
import Login from '../Pages/Login.vue';
import Dashboard from '../Pages/Dashboard.vue';
import ManajemenMenu from '../Pages/ManajemenMenu.vue'; // <-- 1. Import ini

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
        path: '/menu',           // <-- 2. Tambahkan block ini
        name: 'ManajemenMenu',
        component: ManajemenMenu
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;