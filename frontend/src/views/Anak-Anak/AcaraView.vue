<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <h5 class="fw-bold mt-4 text-dark" style="line-height: 10px">Acara</h5>
                <p class="text-muted">Temukan beragam event menarik kami!</p>

                <form class="d-flex align-items-center mb-4" role="search">
                    <input
                        class="form-control me-2 rounded"
                        type="search"
                        placeholder="Cari buku, penulis, atau kategori..."
                        aria-label="Search"
                    />
                    <button class="btn btn-dark rounded-pill" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <div class="row g-4 mb-5" v-if="events.length">
                    <div class="col-md-4" v-for="(event, index) in events" :key="index">
                        <div
                            class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden"
                            style="transition: all 0.3s ease; cursor: pointer"
                            @click="goToDetail(event)"
                        >
                            <div class="position-relative">
                                <img
                                    :src="url + event.poster"
                                    class="card-img-top"
                                    alt="Event Image"
                                    style="
                                        height: 250px;
                                        object-fit: cover;
                                        object-position: center;
                                    "
                                />
                                <span
                                    class="position-absolute top-0 start-0 m-3 px-3 py-1 small rounded-pill text-white"
                                    style="
                                        background: rgba(0, 0, 0, 0.6);
                                        backdrop-filter: blur(4px);
                                        font-weight: 500;
                                        font-size: 0.75rem;
                                    "
                                >
                                    {{ event.kategori }}
                                </span>
                            </div>

                            <div class="card-body py-3 px-4">
                                <h5
                                    class="card-title fw-bold text-dark mb-2"
                                    style="min-height: 30px"
                                >
                                    {{ event.nama_acara }}
                                </h5>
                                <ul class="list-unstyled text-dark small mb-0">
                                    <li class="mb-2 d-flex align-items-start">
                                        <i class="fa fa-hat-wizard me-2 mt-1"></i>
                                        <span>{{ event.narasumber }}</span>
                                    </li>
                                    <li class="mb-2 d-flex align-items-start">
                                        <i class="fa fa-calendar-days me-2 mt-1"></i>
                                        <span>{{ formatTanggal(event.tanggal) }} </span>
                                    </li>
                                    <li class="mb-2 d-flex align-items-start">
                                        <i class="fa fa-clock me-2 mt-1"></i>
                                        <span
                                            >{{ formatJam(event.jam_mulai) }} -
                                            {{ formatJam(event.jam_selesai) }}</span
                                        >
                                    </li>

                                    <li class="d-flex align-items-start">
                                        <i class="fa fa-tree-city me-2 mt-1"></i>
                                        <span>{{ event.lokasi }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    v-else
                    class="d-flex flex-column align-items-center justify-content-center text-center p-5"
                >
                    <div
                        class="spinner-border text-dark mb-3"
                        role="status"
                        style="width: 3rem; height: 3rem"
                    >
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted fw-semibold mb-0" style="font-size: 1.1rem">
                        Sedang memuat data acara...
                    </p>
                    <small class="text-muted">Mohon tunggu sebentar ya!</small>
                </div>
            </div>
            <Footer />
        </div>
    </div>
</template>
<script>
import router from '@/router'
import axios from 'axios'
import NavbarAnak from '@/components/NavbarAnak.vue'
import Footer from '@/components/Footer.vue'

export default {
    components: {
        NavbarAnak,
        Footer,
    },
    data() {
        return {
            name: '',
            token: '',
            events: [],
            url: 'http://127.0.0.1:8000/storage/',
        }
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        this.name = sessionStorage.getItem('name')
        this.loadEvents()
    },
    methods: {
        loadEvents() {
            axios
                .get('http://127.0.0.1:8000/api/Acara/ListAcara', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    this.events = response.data.filter((event) => {
                        return event.usia.some((u) => u.nama.toLowerCase() === 'anak-anak')
                    })
                })
                .catch((error) => {
                    console.error('Gagal load acara:', error)
                })
        },
        formatTanggal(tanggal) {
            const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
            const bulan = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ]

            const date = new Date(tanggal)
            const namaHari = hari[date.getDay()]
            const tanggalNum = date.getDate()
            const namaBulan = bulan[date.getMonth()]
            const tahun = date.getFullYear()

            return `${namaHari}, ${tanggalNum} ${namaBulan} ${tahun}`
        },

        formatJam(jam) {
            if (!jam) return ''
            const [hour, minute] = jam.split(':')
            return `${hour}.${minute}`
        },

        goToDetail(event) {
            sessionStorage.setItem('event_id', event.id)
            this.$router.push({ name: 'detailacaraanak' })
        },
    },
}
</script>
<style scoped>
.text-dark {
    color: #6f4e95 !important;
}

.btn-dark {
    background-color: #6f4e95 !important;
    border-color: #6f4e95 !important;
}

.form-control:focus {
    border-color: #6f4e95 !important;
    box-shadow: 0 0 0 0.25rem rgba(111, 78, 149, 0.25);
}
</style>
