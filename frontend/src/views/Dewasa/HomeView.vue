<template>
    <div class="d-flex">
        <NavbarDewasa :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <h5 class="fw-bold mt-4" style="line-height: 10px">Rekomendasi Buku</h5>
                <p class="text-muted">Buku pilihan untuk memperkaya wawasan dan inspirasimu.</p>
                <div
                    v-if="isLoadingBuku"
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
                        Sedang memuat data buku...
                    </p>
                    <small class="text-muted">Mohon tunggu sebentar ya!</small>
                </div>

                <div v-else-if="books.length === 0" class="text-center text-muted my-5">
                    <h4 class="fw-bold text-dark" style="line-height: 15px">
                        Ups, belum ada buku tersedia
                    </h4>
                    <p class="text-muted">Silakan usulkan judul buku favorit Anda kepada kami.</p>
                </div>

                <div
                    class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3"
                    v-if="books.length"
                >
                    <div class="col" v-for="(book, index) in books.slice(0, 5)" :key="index">
                        <div
                            class="card h-100 shadow-sm border-0 position-relative"
                            style="overflow: hidden; border-radius: 8px; cursor: pointer"
                            @click="goToDetailBook(book)"
                        >
                            <img
                                :src="url + book.cover_buku"
                                class="card-img-top"
                                alt="cover buku"
                                style="
                                    object-fit: cover;
                                    height: 300px;
                                    width: 100%;
                                    transition: transform 0.3s ease;
                                "
                            />

                            <div
                                class="category-overlay position-absolute top-0 start-0 m-2 text-white px-3 py-1 rounded-pill fw-semibold"
                                style="
                                    backdrop-filter: blur(6px);
                                    background-color: rgba(0, 0, 0, 0.4);
                                    font-size: 0.8rem;
                                    letter-spacing: 0.03em;
                                    user-select: none;
                                    transition: background-color 0.3s ease;
                                "
                            >
                                {{ book.kategori.map((k) => k.kategori).join(', ') }}
                            </div>

                            <div
                                class="title-overlay position-absolute bottom-0 start-0 w-100 text-white text-center px-3 py-3"
                                style="
                                    font-weight: 700;
                                    font-size: 1rem;
                                    user-select: none;
                                    z-index: 2;
                                "
                            >
                                {{ book.judul }}
                            </div>

                            <div
                                class="position-absolute bottom-0 start-0 w-100"
                                style="
                                    height: 80px;
                                    background: linear-gradient(
                                        to top,
                                        rgba(0, 0, 0, 0.6),
                                        transparent
                                    );
                                    z-index: 1;
                                "
                            ></div>
                        </div>
                    </div>
                </div>

                <div>
                    <h5 class="fw-bold mt-4" style="line-height: 10px">Agenda Literasi</h5>
                    <p class="text-muted">
                        Ikuti berbagai kegiatan literasi yang memperkaya wawasan Anda.
                    </p>
                    <div
                        v-if="isLoadingAcara"
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

                    <div v-else-if="events.length === 0" class="text-center text-muted my-5">
                        <h4 class="fw-bold text-dark" style="line-height: 15px">
                            Ups, belum ada acara yang tersedia
                        </h4>
                        <p class="text-muted">
                            Silakan cek kembali di lain waktu untuk info acara terbaru.
                        </p>
                    </div>

                    <div class="row g-4 mb-5" v-if="events.length">
                        <div class="col-md-4" v-for="(event, index) in events" :key="index">
                            <div
                                class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden"
                                style="transition: all 0.3s ease; cursor: pointer"
                                @click="goToDetailEvent(event)"
                            >
                                <div class="position-relative">
                                    <img
                                        :src="url + event.poster"
                                        class="card-img-top"
                                        alt="Event Image"
                                        style="height: 220px; object-fit: cover"
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
                                        class="card-title fw-semibold text-dark mb-2"
                                        style="min-height: 30px"
                                    >
                                        {{ event.nama_acara }}
                                    </h5>
                                    <ul class="list-unstyled text-muted small mb-0">
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="fa fa-microphone me-2 text-dark mt-1"></i>
                                            <span>{{ event.narasumber }}</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="fa fa-calendar me-2 text-dark mt-1"></i>
                                            <span>{{ formatTanggal(event.tanggal) }}</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="fa fa-clock me-2 text-dark mt-1"></i>
                                            <span
                                                >{{ formatJam(event.jam_mulai) }} -
                                                {{ formatJam(event.jam_selesai) }}</span
                                            >
                                        </li>
                                        <li class="d-flex align-items-start">
                                            <i class="fa fa-location-dot me-2 text-dark mt-1"></i>
                                            <span>{{ event.lokasi }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Footer />
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import NavbarDewasa from '@/components/NavbarDewasa.vue'
import Footer from '@/components/Footer.vue'

export default {
    components: {
        NavbarDewasa,
        Footer,
    },
    data() {
        return {
            name: '',
            token: '',
            books: [],
            events: [],
            url: 'https://laravel-library-production.up.railway.app/storage/',
            isLoadingBuku: false,
            isLoadingAcara: false,
        }
    },
    mounted() {
        this.loadBuku()
        this.loadEvents()
        this.token = sessionStorage.getItem('token')
        this.name = sessionStorage.getItem('name')
    },
    methods: {
        loadBuku() {
            this.isLoadingBuku = true
            axios
                .get('https://laravel-library-production.up.railway.app/api/Buku/KoleksiBukuHome', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    let allBooks = response.data.data
                    allBooks = allBooks.filter((book) => {
                        return book.kategori.some((kategori) => {
                            return kategori.usia.some((u) => u.nama.toLowerCase() === 'dewasa')
                        })
                    })

                    this.books = allBooks
                })
                .catch((error) => {
                    console.error(error)
                })
                .finally(() => {
                    this.isLoadingBuku = false
                })
        },
        loadEvents() {
            this.isLoadingAcara = true
            axios
                .get('https://laravel-library-production.up.railway.app/api/Acara/ListAcaraHome', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    this.events = response.data.data.filter((event) => {
                        return event.usia.some((u) => u.nama.toLowerCase() === 'dewasa')
                    })
                })
                .catch((error) => {
                    console.error('Gagal load acara:', error)
                })
                .finally(() => {
                    this.isLoadingAcara = false
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
        goToDetailBook(book) {
            sessionStorage.setItem('book_id', book.id)
            this.$router.push({ name: 'detailbukudewasa' })
        },
        goToDetailEvent(event) {
            sessionStorage.setItem('event_id', event.id)
            this.$router.push({ name: 'detailacaradewasa' })
        },
    },
}
</script>
