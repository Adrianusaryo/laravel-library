<template>
    <div class="d-flex">
        <NavbarRemaja :name="name" />
        <div class="flex-grow-1 px-4 bg-dark">
            <div class="container">
                <h5 class="fw-bold text-dark mt-4" style="line-height: 10px">Aktivitas</h5>
                <p class="text-muted mb-4">Yuk lihat kembali aktivitas kamu di Perpustakaan!</p>

                <div
                    v-if="isLoading"
                    class="d-flex flex-column align-items-center justify-content-center text-center p-5"
                >
                    <div
                        class="spinner-border text-dark mb-3"
                        role="status"
                        style="width: 3rem; height: 3rem"
                    >
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted fw-semibold mb-1" style="font-size: 1.1rem">
                        Menyiapkan aktivitasmu di Perpustakaan...
                    </p>
                    <small class="text-muted">Sedang memuat data, mohon tunggu sejenak ✨</small>
                </div>

                <div v-show="!isLoading">
                    <div class="d-flex align-items-center mb-3">
                        <button class="btn btn-sm btn-dark rounded-circle me-2">
                            <i class="fa fa-clock"></i>
                        </button>
                        <span class="fw-semibold fs-6 text-dark">Peminjaman Buku Aktif</span>
                    </div>
                    <div v-if="peminjamanAktif.length > 0">
                        <div
                            v-for="(pinjam, index) in peminjamanAktif"
                            :key="'active-' + index"
                            class="card border-0 shadow-sm mb-3"
                            style="border-radius: 14px"
                        >
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold mb-0 text-dark">
                                        {{ pinjam.kode_peminjaman }}
                                    </h5>

                                    <span
                                        class="badge text-white px-3 py-2"
                                        :class="{
                                            'bg-warning': pinjam.status === 'Menunggu Konfirmasi',
                                            'bg-primary': pinjam.status === 'Dipinjam',
                                        }"
                                    >
                                        {{ pinjam.status }}
                                    </span>
                                </div>
                                <p class="mb-2 text-muted" style="font-size: 0.85rem">
                                    Detail peminjaman buku dari daftar koleksi
                                </p>
                                <div
                                    class="d-flex align-items-center text-muted mb-2"
                                    style="font-size: 0.9rem"
                                >
                                    <i class="fa fa-clock me-2 text-dark"></i>
                                    <span class="text-dark fw-medium">
                                        Tanggal Peminjaman :
                                        <strong>{{ pinjam.tanggalPinjam }}</strong>
                                    </span>
                                </div>
                                <div
                                    class="d-flex align-items-center text-muted"
                                    style="font-size: 0.9rem"
                                >
                                    <i class="fa fa-calendar me-2 text-dark"></i>
                                    <span class="text-dark fw-medium">
                                        Estimasi Pengembalian :
                                        <strong>{{ pinjam.tanggalKembali }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center my-5">
                        <h4 class="fw-bold text-dark" style="line-height: 15px">
                            Belum ada peminjaman
                        </h4>
                        <p class="text-muted">Yuk cari buku dan mulai membaca sekarang!</p>
                    </div>

                    <div class="d-flex align-items-center mb-3 mt-5">
                        <button class="btn btn-sm btn-dark rounded-circle me-2">
                            <i class="fa fa-check"></i>
                        </button>
                        <span class="fw-semibold fs-6 text-dark">Riwayat Peminjaman Buku</span>
                    </div>

                    <div v-if="peminjamanSelesai.length > 0">
                        <div
                            v-for="(pinjam, index) in peminjamanSelesai"
                            :key="'selesai-' + index"
                            class="card border-0 shadow-sm mb-5 bg-white"
                            style="border-radius: 14px"
                        >
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold mb-0 text-dark">
                                        {{ pinjam.kode_peminjaman }}
                                    </h5>

                                    <span
                                        class="badge text-white px-3 py-2"
                                        :class="{
                                            'bg-success': pinjam.status === 'Selesai',
                                        }"
                                    >
                                        {{ pinjam.status }}
                                    </span>
                                </div>
                                <p class="mb-2 text-muted" style="font-size: 0.85rem">
                                    Detail peminjaman buku dari daftar koleksi
                                </p>
                                <div
                                    class="d-flex align-items-center text-muted mb-2"
                                    style="font-size: 0.9rem"
                                >
                                    <i class="fa fa-clock text-dark me-2"></i>
                                    <span class="text-dark">
                                        Tanggal Peminjaman :
                                        <strong>{{ pinjam.tanggalPinjam }}</strong>
                                    </span>
                                </div>
                                <div
                                    class="d-flex align-items-center text-muted"
                                    style="font-size: 0.9rem"
                                >
                                    <i class="fa fa-calendar text-dark me-2"></i>
                                    <span class="text-dark">
                                        Tanggal Pengembalian :
                                        <strong>{{ pinjam.tanggalKembali }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-center my-5">
                        <h4 class="fw-bold text-dark" style="line-height: 15px">
                            Belum ada riwayat peminjaman
                        </h4>
                        <p class="text-muted">Yuk cari buku dan mulai membaca sekarang!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavbarRemaja from '@/components/NavbarRemaja.vue'
import axios from 'axios'

export default {
    components: {
        NavbarRemaja,
    },
    data() {
        return {
            name: '',
            token: '',
            peminjamanAktif: [],
            peminjamanSelesai: [],
            isLoading: true, // loading state
        }
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        this.name = sessionStorage.getItem('name')
        axios
            .get('http://127.0.0.1:8000/api/Peminjaman/LihatPeminjamanBuku', {
                headers: { Authorization: `Bearer ${this.token}` },
            })
            .then((response) => {
                const peminjaman = response.data.data
                const options = { year: 'numeric', month: 'long', day: 'numeric' }

                this.peminjamanAktif = peminjaman
                    .filter(
                        (item) =>
                            item.status === 'Menunggu Konfirmasi' || item.status === 'Dipinjam',
                    )
                    .map((item) => {
                        const tanggalPinjam = new Date(item.tanggal_pinjam)
                        const tanggalKembali = new Date(item.tanggal_pinjam)
                        tanggalKembali.setDate(tanggalPinjam.getDate() + 7)

                        return {
                            ...item,
                            tanggalPinjam: tanggalPinjam.toLocaleDateString('id-ID', options),
                            tanggalKembali: tanggalKembali.toLocaleDateString('id-ID', options),
                        }
                    })

                this.peminjamanSelesai = peminjaman
                    .filter((item) => item.status === 'Selesai')
                    .map((item) => {
                        const tanggalPinjam = new Date(item.tanggal_pinjam)
                        const tanggalKembali = new Date(item.tanggal_kembali)

                        return {
                            ...item,
                            tanggalPinjam: tanggalPinjam.toLocaleDateString('id-ID', options),
                            tanggalKembali: tanggalKembali.toLocaleDateString('id-ID', options),
                        }
                    })
            })
            .catch((error) => {
                console.error('Peminjaman Error:', error)
            })
            .finally(() => {
                this.isLoading = false
            })
    },
}
</script>

<style scoped>
.badge {
    font-size: 0.75rem;
    padding: 0.4em 0.6em;
    border-radius: 20px;
}

.bg-dark {
    background-color: #f4f6f9 !important;
    min-height: 100vh;
}

.text-dark {
    color: #344767 !important;
}

.btn-dark {
    background-color: #344767 !important;
}
</style>
