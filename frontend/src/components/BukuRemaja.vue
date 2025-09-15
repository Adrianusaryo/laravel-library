<template>
    <div v-if="book" class="container bg-dark p-5 rounded">
        <div class="row align-items-center mb-5">
            <div class="col-md-4 text-center">
                <img
                    :src="url + book.cover_buku"
                    :alt="`Cover Buku ${book.judul}`"
                    class="img-fluid rounded shadow-lg"
                    style="max-height: 450px; object-fit: cover"
                />
            </div>

            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h4 class="fw-bold mb-0 text-dark" style="line-height: 15px">
                        {{ book.judul }}
                    </h4>
                </div>
                <h5 class="text-muted mb-3">{{ book.penulis }} (Pengarang)</h5>

                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td class="fw-bold text-dark w-25">Edisi</td>
                            <td class="text-muted">{{ book.edisi }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark">Penerbit</td>
                            <td class="text-muted">{{ book.penerbit }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark">Deskripsi Fisik</td>
                            <td class="text-muted">{{ book.deskripsi_fisik }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark">ISBN</td>
                            <td class="text-muted">{{ book.isbn }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark">Subjek</td>
                            <td
                                v-for="kategori in book.kategori"
                                :key="kategori.id"
                                class="text-muted"
                            >
                                {{ kategori.kategori }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-dark">Bahasa</td>
                            <td class="text-muted">{{ book.bahasa }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status Buku</td>
                            <td>
                                <span
                                    class="badge px-3 py-2 rounded-pill fw-medium"
                                    :class="
                                        book.status === 'Tersedia'
                                            ? 'text-success bg-success bg-opacity-10'
                                            : 'text-danger bg-danger bg-opacity-10'
                                    "
                                >
                                    {{ book.status }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end" v-if="book.status === 'Tersedia'">
                    <button class="btn btn-dark px-4 py-2" @click="addToCart">
                        <i class="fa fa-plus me-2"></i> Pinjam Buku
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h4 class="fw-semibold text-dark mb-2">Deskripsi</h4>
            <p class="fs-6 text-muted">{{ book.deskripsi }}</p>
        </div>

        <div class="mb-4">
            <h4 class="fw-semibold text-dark mb-2">Tulis Ulasan</h4>
            <form @submit.prevent="submitReview">
                <div class="mb-3">
                    <textarea
                        class="form-control fs-6"
                        rows="3"
                        v-model="reviewText"
                        placeholder="Tulis ulasan buku di sini..."
                    ></textarea>
                </div>
                <button type="submit" class="btn btn-dark px-3 py-2">
                    <i class="fa fa-comment-dots me-2"></i>Kirim
                </button>
            </form>
        </div>

        <div>
            <h4 class="fw-semibold text-dark">Ulasan Pengguna</h4>

            <div v-if="reviewsLocal.length === 0" class="alert alert-info" role="alert">
                Belum ada ulasan untuk buku ini.
            </div>

            <div
                class="px-3 pt-3 bg-white rounded shadow-sm mb-2"
                v-for="(review, index) in reviewsLocal"
                :key="index"
            >
                <div class="d-flex justify-content-between align-items-start">
                    <p class="fs-6 fw-medium text-dark">{{ review.text }}</p>
                    <span class="fw-medium ms-3 text-dark" style="white-space: nowrap"
                        >~ {{ review.user }}</span
                    >
                </div>
            </div>
        </div>
    </div>
    <div
        v-else
        class="d-flex flex-column align-items-center justify-content-center text-center p-5"
    >
        <div class="spinner-border text-dark mb-3" role="status" style="width: 3rem; height: 3rem">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="text-muted fw-semibold mb-0" style="font-size: 1.1rem">
            Sedang memuat data buku...
        </p>
        <small class="text-muted">Mohon tunggu sebentar ya!</small>
    </div>
</template>

<script>
import { useCartStore } from '@/stores/cartStore'
import { mapActions } from 'pinia'

export default {
    props: {
        book: {
            type: Object,
            required: true,
        },
        reviews: {
            type: Array,
            default: () => [],
        },
    },
    data() {
        return {
            reviewText: '',
            url: 'https://laravel-library-production.up.railway.app/storage/',
            cart: null,
            reviewsLocal: [],
        }
    },
    created() {
        this.cart = useCartStore()
    },
    watch: {
        book(newBook) {
            if (newBook && newBook.id) {
                this.fetchReviews()
            }
        },
    },
    methods: {
        addToCart() {
            this.cart.addToCart(this.book)
            alert('Buku ditambahkan ke keranjang')
        },
        async fetchReviews() {
            try {
                const response = await fetch(
                    `https://laravel-library-production.up.railway.app/api/Buku/LihatUlasanBuku/${this.book.id}`,
                    {
                        headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                    },
                )
                const data = await response.json()

                if (data.ulasans || Array.isArray(data.ulasans)) {
                    this.reviewsLocal = data.ulasans.map((u) => ({
                        text: u.comment,
                        user: u.user?.name || 'Anonim',
                    }))
                } else {
                    this.reviewsLocal = []
                    console.warn('Response ulasan tidak valid:', data)
                }
            } catch (error) {
                console.error('Gagal mengambil ulasan:', error)
            }
        },
        async submitReview() {
            if (!this.reviewText.trim()) {
                alert('Teks ulasan tidak boleh kosong.')
                return
            }

            try {
                const response = await fetch(`https://laravel-library-production.up.railway.app/api/Buku/UlasanBuku`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${sessionStorage.getItem('token')}`,
                    },
                    body: JSON.stringify({
                        buku_id: this.book.id,
                        comment: this.reviewText.trim(),
                    }),
                })

                const data = await response.json()

                if (response.ok) {
                    this.reviewText = ''
                    this.fetchReviews()
                    alert('Ulasan berhasil dikirim!')
                } else {
                    console.error('Gagal kirim ulasan:', data)
                    alert(data.message || 'Gagal mengirim ulasan.')
                }
            } catch (err) {
                console.error('Error kirim ulasan:', err)
                alert('Terjadi kesalahan saat mengirim ulasan.')
            }
        },
    },
}
</script>

<style scoped>
.bg-dark {
    background-color: #f4f6f9 !important;
    min-height: 100vh;
}

.btn-dark {
    background-color: #344767 !important;
}

.text-dark {
    color: #344767 !important;
}

.form-control:focus {
    border-color: #344767 !important;
    box-shadow: 0 0 0 0.2rem rgba(52, 71, 103, 0.25) !important;
}
</style>
