<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <h5 class="fw-bold mt-4 text-dark" style="line-height: 10px">
                    Daftar Koleksi Buku
                </h5>
                <p class="text-muted mb-4">Tingkatkan literasi membacamu hari ini!</p>

                <form
                    class="d-flex align-items-center mb-4"
                    role="search"
                    @submit.prevent="handleSubmit"
                >
                    <input
                        v-model="searchKeyword"
                        class="form-control me-2 rounded"
                        type="search"
                        placeholder="Cari buku, penulis, atau kategori..."
                        aria-label="Search"
                    />
                    <button class="btn btn-dark rounded-pill" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <div v-if="isSearching && books.length === 0" class="text-center text-muted my-4">
                    <h4 class="fw-bold text-dark" style="line-height: 15px">
                        Ups, buku tidak ditemukan
                    </h4>
                    <p class="text-muted">Silakan usulkan judul buku favorit Anda kepada kami.</p>
                </div>

                <ul
                    v-if="books.length != 0"
                    class="nav nav-pills mb-4 gap-2 flex-wrap"
                    id="category-tabs"
                >
                    <li class="nav-item" v-for="kategori in kategoriList" :key="kategori">
                        <button
                            class="nav-link bg-dark-plus shadow-sm rounded px-3 py-1 border-0 fw-medium"
                            :class="{ active: selectedKategori === kategori }"
                            @click="filterKategori(kategori)"
                        >
                            {{ kategori }}
                        </button>
                    </li>
                </ul>

                <div
                    class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3"
                    v-if="books.length"
                >
                    <div class="col" v-for="(book, index) in books" :key="index">
                        <div
                            class="card h-100 shadow-sm border-0 position-relative"
                            style="overflow: hidden; border-radius: 8px; cursor: pointer"
                            @click="goToDetail(book)"
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
                                v-for="kategori in book.kategori"
                                :key="kategori.id"
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
                <div
                    v-else-if="books.length === 0 && isLoading"
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

                <nav v-if="books.length != 0" aria-label="Pagination" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item" :class="{ disabled: currentPage === 1 }">
                            <a href="#" class="page-link" @click.prevent="loadBuku(currentPage - 1)"
                                >&laquo;</a
                            >
                        </li>
                        <li
                            class="page-item"
                            v-for="page in totalPages"
                            :key="page"
                            :class="{ active: currentPage === page }"
                        >
                            <a href="#" class="page-link" @click.prevent="loadBuku(page)">{{
                                page
                            }}</a>
                        </li>
                        <li class="page-item" :class="{ disabled: currentPage === lastPage }">
                            <a href="#" class="page-link" @click.prevent="loadBuku(currentPage + 1)"
                                >&raquo;</a
                            >
                        </li>
                    </ul>
                </nav>
            </div>
            <FooterRemaja />
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import FooterRemaja from '@/components/FooterRemaja.vue'
import NavbarAnak from '@/components/NavbarAnak.vue'
export default {
    components: {
        NavbarAnak,
        FooterRemaja,
    },
    data() {
        return {
            name: '',
            token: '',
            books: [],
            url: 'http://127.0.0.1:8000/storage/',
            currentPage: 1,
            lastPage: 1,
            perPage: 10,
            selectedKategori: 'Semua',
            kategoriList: [],
            searchKeyword: '',
            isLoading: false,
            isSearching: false,
        }
    },
    computed: {
        totalPages() {
            return Array.from({ length: this.lastPage }, (_, i) => i + 1)
        },
    },
    mounted() {
        this.token = sessionStorage.getItem('token')
        this.name = sessionStorage.getItem('name')
        this.loadBuku(this.currentPage)
        this.loadKategori()
    },
    methods: {
        loadBuku(page = 1) {
            this.isLoading = true
            const kategoriParam =
                this.selectedKategori && this.selectedKategori.toLowerCase() !== 'semua'
                    ? `&kategori=${this.selectedKategori}`
                    : ''

            axios
                .get(
                    `http://127.0.0.1:8000/api/Buku/KoleksiBuku?usia=anak-anak&page=${page}&per_page=${this.perPage}${kategoriParam}`,
                    {
                        headers: {
                            Authorization: `Bearer ${sessionStorage.getItem('token')}`,
                        },
                    },
                )
                .then((response) => {
                    this.books = response.data.data
                    this.currentPage = response.data.current_page
                    this.lastPage = response.data.last_page
                })
                .catch((error) => {
                    console.error('Gagal memuat buku:', error)
                })
                .finally(() => {
                    this.isLoading = false
                })
        },
        loadKategori() {
            axios
                .get('http://127.0.0.1:8000/api/Buku/DaftarKategori', {
                    headers: { Authorization: `Bearer ${this.token}` },
                })
                .then((response) => {
                    const kategoriData = response.data.data
                        .filter((k) => k.usia.some((u) => u.nama.toLowerCase() === 'anak-anak'))
                        .map((k) => k.kategori)
                    this.kategoriList = ['Semua', ...kategoriData]
                })
                .catch((error) => {
                    console.error('Gagal memuat kategori:', error)
                })
        },
        filterKategori(kategori) {
            this.selectedKategori = kategori
            this.loadBuku(1)
        },
        goToDetail(book) {
            sessionStorage.setItem('book_id', book.id)
            this.$router.push({ name: 'detailbukuanak' })
        },
        handleSubmit() {
            const keyword = this.searchKeyword.trim()

            if (keyword === '') {
                this.isSearching = false
                this.books = []
                this.currentPage = 1
                this.lastPage = 1
                this.loadBuku(1)
            } else {
                this.searchBooks()
            }
        },
        searchBooks() {
            this.isSearching = true
            axios
                .get(`http://127.0.0.1:8000/api/Buku/KoleksiBuku?usia=anak-anak&per_page=1000`, {
                    headers: { Authorization: `Bearer ${this.token}` },
                })
                .then((response) => {
                    let allBooks = response.data.data

                    allBooks = allBooks.filter((book) => {
                        return book.kategori.some((kategori) =>
                            kategori.usia.some((u) => u.nama.toLowerCase() === 'anak-anak'),
                        )
                    })

                    if (this.selectedKategori !== 'Semua') {
                        allBooks = allBooks.filter((book) =>
                            book.kategori.some(
                                (kategori) =>
                                    kategori.kategori.toLowerCase() ===
                                    this.selectedKategori.toLowerCase(),
                            ),
                        )
                    }

                    if (this.searchKeyword.trim() !== '') {
                        const keyword = this.searchKeyword.toLowerCase()
                        allBooks = allBooks.filter((book) => {
                            return book.judul.toLowerCase().includes(keyword)
                        })
                    }

                    this.books = allBooks
                    this.currentPage = 1
                    this.lastPage = Math.ceil(allBooks.length / this.perPage)
                })
                .catch((error) => {
                    console.error('Gagal mencari buku:', error)
                })
        },
    },
}
</script>
<style scoped>
.bg-dark-plus {
    background-color: #6f4e95 !important;
    color: white;
}

.btn-dark {
    background-color: #6f4e95 !important;
    border-color: #6f4e95 !important;
}

.text-dark {
    color: #6f4e95 !important;
}

.active > .page-link,
.page-link.active {
    z-index: 3;
    color: white;
    background-color: #6f4e95;
    border-color: #6f4e95;
}

.form-control:focus {
    border-color: #6f4e95 !important;
    box-shadow: 0 0 0 0.25rem rgba(111, 78, 149, 0.25);
}
</style>
