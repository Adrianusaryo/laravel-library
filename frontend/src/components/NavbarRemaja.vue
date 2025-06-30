<template>
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="sidebar bg-white shadow vh-100 position-fixed">
            <div class="p-4 border-bottom">
                <RouterLink
                    class="navbar-brand fs-5 fw-semibold d-flex align-items-center"
                    to="/Remaja"
                >
                    <i class="fa fa-book-open me-2"></i> E-Library Teenager
                </RouterLink>
            </div>

            <!-- Menu -->
            <ul class="nav flex-column mt-3 px-2">
                <li class="nav-item my-1">
                    <RouterLink class="nav-link" to="/Remaja">
                        <i class="fa fa-house-user me-2"></i> Home
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link" to="/Remaja/Koleksi">
                        <i class="fa fa-layer-group me-2"></i> Daftar Koleksi
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link" to="/Remaja/Leaderboard">
                        <i class="fa fa-ranking-star me-2"></i> Leaderboard
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link" to="/Remaja/Keranjang">
                        <i class="fa fa-cart-shopping me-2"></i> Keranjang
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link" to="/Remaja/Acara">
                        <i class="fa fa-calendar-days me-2"></i> Acara
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link" to="/Remaja/Transaksi">
                        <i class="fa fa-rotate-left me-2"></i>Aktivitas
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link" to="/Remaja/Usul-Buku">
                        <i class="fa fa-circle-plus me-2"></i>Usul Buku
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link" to="/Remaja/Profil">
                        <i class="fa fa-circle-user me-2"></i> {{ name }}
                    </RouterLink>
                </li>
            </ul>

            <!-- User Profile -->
            <div class="mt-3 px-3 mb-2">
                <button class="btn btn-dark w-100" @click="logout">
                    <i class="fa fa-right-from-bracket me-2"></i> Logout
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow-1" style="margin-left: 250px">
            <router-view />
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import router from '@/router'

export default {
    props: ['name'],
    methods: {
        logout() {
            axios
                .get('http://127.0.0.1:8000/api/Auth/Logout', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then(() => {
                    sessionStorage.clear()
                    router.push({ name: 'login' })
                })
                .catch((error) => {
                    console.error('Logout Error:', error)
                })
        },
    },
}
</script>

<style scoped>
.sidebar {
    width: 250px;
    min-height: 100vh;
    transition: all 0.3s;
    z-index: 1000;
    background-color: #f4f6f9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.navbar-brand {
    color: #344767;
    transition: background-color 0.2s ease;
}

.nav-link {
    color: #344767;
    transition: background-color 0.2s ease;
}

.nav-link:hover {
    background-color: #dbe5f1;
    color: #1e3a8a;
    border-radius: 20px;
}

.btn-dark {
    background-color: #344767 !important;
}
</style>
