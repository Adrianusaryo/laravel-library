<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <h5 class="fw-bold mt-4 text-dark" style="line-height: 10px">Rekomendasi Buku</h5>
                <p class="text-muted">Ayo temukan cerita ajaibmu!</p>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
                    <div class="col" v-for="(book, index) in books" :key="index">
                        <div
                            class="card h-100 shadow-sm border-0 position-relative"
                            style="overflow: hidden; border-radius: 8px; cursor: pointer"
                        >
                            <img
                                :src="book.image"
                                class="card-img-top"
                                alt="cover buku"
                                style="
                                    object-fit: cover;
                                    height: 300px;
                                    width: 100%;
                                    transition: transform 0.3s ease;
                                "
                            />

                            <!-- Category di pojok kiri atas -->
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
                                {{ book.category }}
                            </div>

                            <!-- Judul tetap di bawah -->
                            <div
                                class="title-overlay position-absolute bottom-0 start-0 w-100 text-white text-center px-3 py-3"
                                style="
                                    font-weight: 700;
                                    font-size: 1rem;
                                    user-select: none;
                                    z-index: 2;
                                "
                            >
                                {{ book.title }}
                            </div>

                            <!-- Overlay gelap sebagai masking -->
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
                    <h5 class="fw-bold mt-4 text-dark" style="line-height: 10px">
                        Agenda Literasi
                    </h5>
                    <p class="text-muted">Yuk ikuti serunya acara seru di perpustakaan!</p>
                    <div class="row g-4 mb-5">
                        <div class="col-md-4" v-for="(event, index) in events" :key="index">
                            <div
                                class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden"
                                style="transition: all 0.3s ease; cursor: pointer"
                            >
                                <!-- Gambar event -->
                                <div class="position-relative">
                                    <img
                                        :src="event.image"
                                        class="card-img-top"
                                        alt="Event Image"
                                        style="height: 220px; object-fit: cover"
                                    />
                                    <!-- Badge kategori -->
                                    <span
                                        class="position-absolute top-0 start-0 m-3 px-3 py-1 small rounded-pill text-white"
                                        style="
                                            background: rgba(0, 0, 0, 0.6);
                                            backdrop-filter: blur(4px);
                                            font-weight: 500;
                                            font-size: 0.75rem;
                                        "
                                    >
                                        {{ event.category }}
                                    </span>
                                </div>

                                <!-- Konten acara -->
                                <div class="card-body py-3 px-4">
                                    <h5
                                        class="card-title fw-semibold text-purple mb-2"
                                        style="min-height: 30px"
                                    >
                                        {{ event.title }}
                                    </h5>
                                    <ul class="list-unstyled text-muted small mb-0">
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="fa fa-hat-wizard me-2 mt-1"></i>
                                            <span>{{ event.pembicara }}</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="fa fa-calendar-days me-2 mt-1"></i>
                                            <span>{{ event.date }}</span>
                                        </li>
                                        <li class="d-flex align-items-start">
                                            <i class="fa fa-tree-city me-2 mt-1"></i>
                                            <span>{{ event.description }}</span>
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
import router from '@/router'
import bumiManusiaImg from '@/assets/image/bumimanusia.jpg'
import acara from '@/assets/image/acara.webp'
import festival from '@/assets/image/festival.webp'
import akbar from '@/assets/image/akbar.webp'
import Dilan from '@/assets/image/dilan.jpg'
import filosofi from '@/assets/image/filosofi.jpg'
import Footer from '@/components/Footer.vue'
import lautImg from '@/assets/image/laut.jpg'
import negeriImg from '@/assets/image/negeri.jpg'
import NavbarAnak from '@/components/NavbarAnak.vue'

export default {
    components: {
        NavbarAnak,
        Footer,
    },
    data() {
        return {
            name: '',
            token: '',
            books: [
                {
                    title: 'Laut Bercerita',
                    image: lautImg,
                    category: 'Fiksi',
                },
                {
                    title: 'Negeri 5 Menara',
                    image: negeriImg,
                    category: 'Fiksi',
                },
                {
                    title: 'Bumi Manusia',
                    image: bumiManusiaImg,
                    category: 'Fiksi',
                },
                {
                    title: 'Filosofi Teras',
                    image: filosofi,
                    category: 'Fiksi',
                },
                {
                    title: 'Dilan 1990',
                    image: Dilan,
                    category: 'Fiksi',
                },
            ],
            events: [
                {
                    title: 'Workshop Menulis Kreatif',
                    category: 'Literasi',
                    date: '10 Juni 2025 17.00 - 20.00',
                    pembicara: 'DKM Mesjid Amir Hamzah',
                    description: 'Perpustakaan MBK - Tomang',
                    image: akbar,
                },
                {
                    title: 'Workshop Menulis Kreatif',
                    category: 'Literasi',
                    date: '10 Juni 2025 17.00 - 20.00',
                    pembicara: 'DKM Mesjid Amir Hamzah',
                    description: 'Perpustakaan MBK - Tomang',
                    image: acara,
                },
                {
                    title: 'Workshop Menulis Kreatif',
                    category: 'Literasi',
                    date: '10 Juni 2025 17.00 - 20.00',
                    pembicara: 'DKM Mesjid Amir Hamzah',
                    description: 'Perpustakaan MBK - Tomang',
                    image: festival,
                },
            ],
        }
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        this.name = sessionStorage.getItem('name')
    },
    methods: {},
}
</script>

<style scoped>
.text-dark {
    color: #6f4e95 !important;
}

.text-purple {
    color: #6f4e95 !important;
}

.bg-dark {
    background-color: #faf5ff !important;
}
</style>
