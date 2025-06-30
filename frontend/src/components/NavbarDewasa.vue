<template>
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="sidebar bg-white shadow vh-100 position-fixed">
            <div class="p-4 border-bottom">
                <RouterLink
                    class="navbar-brand text-dark fs-5 fw-semibold d-flex align-items-center"
                    to="/Dewasa"
                >
                    <i class="fa fa-book-open me-2"></i> E-Library Adult
                </RouterLink>
            </div>

            <!-- Menu -->
            <ul class="nav flex-column mt-3 px-2">
                <li class="nav-item my-1">
                    <RouterLink class="nav-link text-dark text-muted" to="/Dewasa">
                        <i class="fa fa-home me-2"></i> Home
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link text-dark text-muted" to="/Dewasa/Koleksi">
                        <i class="fa fa-book me-2"></i> Daftar Koleksi
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link text-dark text-muted" to="/Dewasa/Leaderboard">
                        <i class="fa fa-trophy me-2"></i> Leaderboard
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link text-dark text-muted" to="/Dewasa/Keranjang">
                        <i class="fa fa-bag-shopping me-2"></i> Keranjang
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link text-dark text-muted" to="/Dewasa/Acara">
                        <i class="fa fa-calendar me-2"></i> Acara
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link text-dark text-muted" to="/Dewasa/Aktivitas">
                        <i class="fa fa-repeat me-2"></i>Aktivitas
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link text-dark text-muted" to="/Dewasa/Usul-Buku">
                        <i class="fa fa-download me-2"></i>Usul Buku
                    </RouterLink>
                </li>
                <li class="nav-item my-1">
                    <RouterLink class="nav-link text-dark text-muted" to="/Dewasa/Profil">
                        <i class="fa fa-user-secret me-2"></i> {{ name }}
                    </RouterLink>
                </li>
            </ul>

            <!-- User Profile -->
            <div class="mt-3 px-3 mb-2">
                <button class="btn btn-dark w-100" @click="logout">
                    <i class="fa fa-sign-out-alt me-2"></i> Logout
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
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Lebih tegas dari shadow-sm */
}

.nav-link:hover {
    background-color: #f8f9fa;
    border-radius: 5px;
}
</style>
