<template>
    <div class="d-flex">
        <aside :class="['sidebar', { 'is-expanded': isExpanded }]">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                <RouterLink
                    class="navbar-brand fs-5 fw-semibold d-flex align-items-center"
                    to="/Remaja"
                >
                    <i class="fa fa-book-open me-2"></i>
                    <span v-if="isExpanded">E-Library Teen</span>
                </RouterLink>

                <button class="btn btn-sm btn-toggle" @click="toggleSidebar">
                    <i :class="isExpanded ? 'fa fa-chevron-left' : 'fa fa-bars'"></i>
                </button>
            </div>

            <div class="scroll-wrapper">
                <ul class="nav flex-column mt-3 px-2">
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Remaja">
                            <i class="fa fa-house-user me-2"></i>
                            <span v-if="isExpanded">Home</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Remaja/Koleksi">
                            <i class="fa fa-layer-group me-2"></i>
                            <span v-if="isExpanded">Daftar Koleksi</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink
                            class="nav-link d-flex align-items-center"
                            to="/Remaja/Leaderboard"
                        >
                            <i class="fa fa-ranking-star me-2"></i>
                            <span v-if="isExpanded">Leaderboard</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink
                            class="nav-link d-flex align-items-center"
                            to="/Remaja/Keranjang"
                        >
                            <i class="fa fa-cart-shopping me-2"></i>
                            <span v-if="isExpanded">Keranjang</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Remaja/Acara">
                            <i class="fa fa-calendar-days me-2"></i>
                            <span v-if="isExpanded">Acara</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink
                            class="nav-link d-flex align-items-center"
                            to="/Remaja/Transaksi"
                        >
                            <i class="fa fa-rotate-left me-2"></i>
                            <span v-if="isExpanded">Aktivitas</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink
                            class="nav-link d-flex align-items-center"
                            to="/Remaja/Usul-Buku"
                        >
                            <i class="fa fa-circle-plus me-2"></i>
                            <span v-if="isExpanded">Usul Buku</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1">
                        <RouterLink class="nav-link d-flex align-items-center" to="/Remaja/Profil">
                            <i class="fa fa-circle-user me-2"></i>
                            <span v-if="isExpanded">{{ name }}</span>
                        </RouterLink>
                    </li>
                </ul>
            </div>

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
    width: 70px;
    transition: all 0.3s ease;
    background-color: #f4f6f9;
    position: fixed;
    height: 100vh;
    z-index: 1000;
}

.sidebar.is-expanded {
    width: 250px;
}

.nav-link {
    color: #344767;
    border-radius: 20px;
    transition: all 0.2s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.nav-link:hover {
    background-color: #dbe5f1;
    color: #1e3a8a;
    border-radius: 20px;
}

.navbar-brand {
    color: #344767;
    transition: background-color 0.2s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.btn-dark {
    background-color: #344767 !important;
    border: none;
    color: white;
}

.btn-toggle {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #344767;
}
</style>
