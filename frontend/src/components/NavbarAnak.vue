<template>
    <div class="d-flex">
        <aside class="sidebar shadow vh-100 position-fixed">
            <div class="p-4 border-bottom">
                <RouterLink
                    class="navbar-brand fs-5 fw-semibold d-flex align-items-center"
                    to="/Anak"
                >
                    <i class="fa fa-book-open me-2"></i> E-Library Kids
                </RouterLink>
            </div>

            <div class="scroll-wrapper">
                <!-- Menu -->
                <ul class="nav flex-column mt-3 px-2">
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link" to="/Anak">
                            <i class="fa fa-house-chimney me-2"></i> Home
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link" to="/Anak/Koleksi">
                            <i class="fa fa-book-open-reader me-2"></i> Daftar Koleksi
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link" to="/Anak/Leaderboard">
                            <i class="fa fa-star me-2"></i> Leaderboard
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link" to="/Anak/Keranjang">
                            <i class="fa fa-gift me-2"></i> Keranjang
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link" to="/Anak/Acara">
                            <i class="fa fa-face-smile me-2"></i> Acara
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link" to="/Anak/Transaksi">
                            <i class="fa fa-rocket me-2"></i>Aktivitas
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link" to="/Anak/Cerpen">
                            <i class="fa fa-wand-magic-sparkles me-2"></i>Cerpen
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link" to="/Anak/Kirim-Cerpen">
                            <i class="fa fa-paper-plane me-2"></i>Kirim Cerpen
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link" to="/Anak/Profil">
                            <i class="fa fa-child me-2"></i> {{ name }}
                        </RouterLink>
                    </li>
                </ul>
            </div>

            <!-- User Profile -->
            <div class="mt-3 px-3 mb-2">
                <button class="btn btn-dark w-100" @click="logout">
                    <i class="fa fa-door-open me-2"></i> Logout
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
    overflow-y: hidden;
    transition: all 0.3s ease-in-out;
    z-index: 1000;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    position: relative;
    scrollbar-width: thin;
    scrollbar-gutter: stable;
    scrollbar-color: #6f4e95 transparent;
}

.sidebar:hover {
    overflow-y: auto;
}

.sidebar::-webkit-scrollbar {
    width: 8px;
}

.sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar::-webkit-scrollbar-thumb {
    background-color: #6f4e95;
    border-radius: 10px;
    border: 2px solid #e9dff7;
}

.navbar-brand {
    color: #6f4e95 !important;
}

.nav-link {
    color: #6f4e95;
    transition:
        background-color 0.2s ease,
        color 0.2s ease;
    border-radius: 20px;
    padding: 8px 12px;
}

.nav-link:hover {
    background-color: #e9dff7;
    color: #4b2991;
}

.btn-dark {
    background-color: #6f4e95 !important;
    border: 2px solid #b39ddb !important;
    color: #fff;
}
</style>
