<template>
    <div class="d-flex">
        <aside :class="['sidebar', { 'is-expanded': isExpanded }]">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <RouterLink
                    class="navbar-brand fs-5 fw-semibold d-flex align-items-center"
                    to="/Anak"
                >
                    <i class="fa fa-book-open me-2"></i>
                    <span v-if="isExpanded">E-Library Kids</span>
                </RouterLink>

                <!-- Tombol toggle sidebar -->
                <button class="btn btn-sm btn-toggle" @click="toggleSidebar">
                    <i :class="isExpanded ? 'fa fa-chevron-left' : 'fa fa-bars'"></i>
                </button>
            </div>

            <div class="scroll-wrapper">
                <!-- Menu -->
                <ul class="nav flex-column mt-3 px-2">
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Anak">
                            <i class="fa fa-house-chimney me-2"></i>
                            <span v-if="isExpanded">Home</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Anak/Koleksi">
                            <i class="fa fa-book-open-reader me-2"></i>
                            <span v-if="isExpanded">Daftar Koleksi</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink
                            class="nav-link d-flex align-items-center"
                            to="/Anak/Leaderboard"
                        >
                            <i class="fa fa-star me-2"></i>
                            <span v-if="isExpanded">Leaderboard</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Anak/Keranjang">
                            <i class="fa fa-gift me-2"></i>
                            <span v-if="isExpanded">Keranjang</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Anak/Acara">
                            <i class="fa fa-face-smile me-2"></i>
                            <span v-if="isExpanded">Acara</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Anak/Transaksi">
                            <i class="fa fa-rocket me-2"></i>
                            <span v-if="isExpanded">Aktivitas</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Anak/Cerpen">
                            <i class="fa fa-wand-magic-sparkles me-2"></i>
                            <span v-if="isExpanded">Cerpen</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink
                            class="nav-link d-flex align-items-center"
                            to="/Anak/Kirim-Cerpen"
                        >
                            <i class="fa fa-paper-plane me-2"></i>
                            <span v-if="isExpanded">Kirim Cerpen</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Anak/Profil">
                            <i class="fa fa-child me-2"></i>
                            <span v-if="isExpanded">{{ name }}</span>
                        </RouterLink>
                    </li>
                </ul>
            </div>

            <!-- Tombol Logout -->
            <div class="mt-3 px-3 mb-2">
                <button
                    class="btn btn-dark w-100 d-flex align-items-center justify-content-center"
                    @click="logout"
                >
                    <i class="fa fa-door-open me-2"></i>
                    <span v-if="isExpanded">Logout</span>
                </button>
            </div>
        </aside>

        <!-- Konten -->
        <div class="flex-grow-1" :style="{ marginLeft: isExpanded ? '250px' : '50px' }">
            <router-view />
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import router from '@/router'

export default {
    props: ['name'],
    data() {
        return {
            isExpanded: localStorage.getItem('sidebar_expanded') === 'true',
        }
    },
    methods: {
        toggleSidebar() {
            this.isExpanded = !this.isExpanded
            localStorage.setItem('sidebar_expanded', this.isExpanded)
        },
        logout() {
            axios
                .get('https://laravel-library-production.up.railway.app/api/Auth/Logout', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then(() => {
                    sessionStorage.clear()
                    router.push({ name: 'login' })
                })
                .catch((err) => console.error('Logout error:', err))
        },
    },
}
</script>

<style scoped>
.sidebar {
    width: 70px;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
    position: fixed;
    overflow-y: hidden;
    height: 100vh;
    overflow-y: auto;
    z-index: 1000;
}

.sidebar.is-expanded {
    width: 250px;
}

.sidebar:hover {
    overflow-y: auto;
}

.sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar::-webkit-scrollbar-thumb {
    background-color: #6f4e95;
    border-radius: 10px;
    border: 2px solid #e9dff7;
}

.sidebar::-webkit-scrollbar {
    width: 8px;
    opacity: 0;
    display: none;
}

.sidebar:hover::-webkit-scrollbar {
    display: block;
}

.nav-link {
    color: #6f4e95;
    border-radius: 20px;
    transition: all 0.2s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.nav-link:hover {
    background-color: #e9dff7;
    color: #4b2991;
}

.navbar-brand {
    color: #6f4e95;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.btn-dark {
    background-color: #6f4e95 !important;
    border: none;
    color: white;
}

.btn-toggle {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #6f4e95;
}
</style>
