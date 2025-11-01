<template>
    <div class="d-flex">
        <aside :class="['sidebar', { 'is-expanded': isExpanded }]">
            <div class="p-3 border-bottom d-flex align-items-center">
                <RouterLink
                    class="navbar-brand fs-5 fw-semibold d-flex align-items-center"
                    to="/Dewasa"
                >
                    <span v-if="isExpanded">Perpustakaan MBK</span>
                </RouterLink>

                <button class="btn btn-sm btn-toggle" @click="toggleSidebar">
                    <i :class="isExpanded ? 'fa fa-angles-left' : 'fa fa-bars'"></i>
                </button>
            </div>

            <div class="scroll-wrapper">
                <ul class="nav flex-column mt-2 px-2">
                    <li class="nav-item my-1" style="font-size: 15px">
                        <RouterLink
                            class="nav-link text-dark d-flex align-items-center"
                            to="/Dewasa"
                        >
                            <i class="fa fa-house-chimney me-2"></i>
                            <span v-if="isExpanded">Beranda</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1" style="font-size: 15px">
                        <RouterLink
                            class="nav-link text-dark d-flex align-items-center"
                            to="/Dewasa/Koleksi"
                        >
                            <i class="fa fa-book-open me-2"></i>
                            <span v-if="isExpanded">Daftar Koleksi</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1" style="font-size: 15px">
                        <RouterLink
                            class="nav-link text-dark d-flex align-items-center"
                            to="/Dewasa/Leaderboard"
                        >
                            <i class="fa fa-chart-simple me-2"></i>
                            <span v-if="isExpanded">Papan Peringkat</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1" style="font-size: 15px">
                        <RouterLink
                            class="nav-link text-dark d-flex align-items-center"
                            to="/Dewasa/Keranjang"
                        >
                            <i class="fa fa-briefcase me-2"></i>
                            <span v-if="isExpanded">Keranjang</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1" style="font-size: 15px">
                        <RouterLink
                            class="nav-link text-dark d-flex align-items-center"
                            to="/Dewasa/Acara"
                        >
                            <i class="fa fa-calendar-days me-2"></i>
                            <span v-if="isExpanded">Acara</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1" style="font-size: 15px">
                        <RouterLink
                            class="nav-link text-dark d-flex align-items-center"
                            to="/Dewasa/Aktivitas"
                        >
                            <i class="fa fa-history me-2"></i>
                            <span v-if="isExpanded">Riwayat Peminjaman</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1" style="font-size: 15px">
                        <RouterLink
                            class="nav-link text-dark d-flex align-items-center"
                            to="/Dewasa/Usul-Buku"
                        >
                            <i class="fa fa-paper-plane me-2"></i>
                            <span v-if="isExpanded">Usulan Koleksi</span>
                        </RouterLink>
                    </li>
                    <li class="nav-item my-1" style="font-size: 15px">
                        <RouterLink
                            class="nav-link text-dark d-flex align-items-center"
                            to="/Dewasa/Profil"
                        >
                            <i class="fa fa-user-gear me-2"></i>
                            <span v-if="isExpanded">{{ name }}</span>
                        </RouterLink>
                    </li>
                </ul>
            </div>

            <div class="px-3 my-2">
                <button
                    class="btn btn-outline-dark btn-sm w-100 d-flex align-items-center justify-content-center py-2"
                    @click="logout"
                >
                    <i class="fa fa-right-from-bracket mx-2"></i>
                    <span v-if="isExpanded" style="font-family: Nunito">Keluar Akun</span>
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
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap');

.sidebar {
    width: 70px;
    transition: all 0.3s ease;
    background-color: #f4f6f9;
    position: fixed;
    height: 100vh;
    z-index: 1000;
}

.sidebar.is-expanded {
    width: 240px;
}

.nav-link {
    border-radius: 20px;
    transition: all 0.2s ease;
    font-family: 'Nunito';
}

.nav-link:hover {
    background-color: #e8ecf1;
    color: #6c757d;
    border-radius: 20px;
}

.navbar-brand {
    transition: background-color 0.2s ease;
    font-family: 'Nunito';
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.btn-toggle {
    background: none;
    border: none;
    font-size: 1rem;
    color: #344767;
}
</style>
