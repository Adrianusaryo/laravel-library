<template>
    <div v-if="book" class="container p-5">
        <!-- Bagian Atas: Gambar & Informasi Buku -->
        <div class="row align-items-center mb-5">
            <!-- Gambar Buku -->
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
                    <h4 class="fw-bold mb-0" style="line-height: 15px">{{ book.judul }}</h4>
                </div>
                <h5 class="text-muted mb-3">{{ book.penulis }} (Pengarang)</h5>

                <table class="table table-bordered mt-3 bg-white">
                    <tbody>
                        <tr>
                            <td class="fw-bold w-25">Edisi</td>
                            <td>{{ book.edisi }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Penerbit</td>
                            <td>{{ book.penerbit }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Deskripsi Fisik</td>
                            <td>{{ book.deskripsi_fisik }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">ISBN</td>
                            <td>{{ book.isbn }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Subjek</td>
                            <td>
                                {{ book.kategori.map((k) => k.kategori).join(', ') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Bahasa</td>
                            <td>{{ book.bahasa }}</td>
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

        <!-- Deskripsi Buku -->
        <div class="mb-4">
            <h4 class="fw-medium mb-2">Deskripsi</h4>
            <p class="fs-6 text-muted">{{ book.deskripsi }}</p>
        </div>

        <!-- Form Ulasan -->
        <div class="mb-4">
            <h4 class="fw-medium mb-2">Tulis Ulasan</h4>
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

        <!-- Daftar Ulasan -->
        <div>
            <h4 class="fw-semibold">Ulasan Pengguna</h4>

            <!-- Alert jika belum ada ulasan -->
            <div v-if="reviewsLocal.length === 0" class="alert alert-warning" role="alert">
                Belum ada ulasan untuk buku ini. Jadilah yang pertama memberikan ulasan!
            </div>

            <!-- Daftar ulasan -->
            <div
                class="px-3 pt-3 pb-2 bg-body-tertiary rounded shadow-sm mb-2"
                v-for="(review, index) in reviewsLocal"
                :key="index"
                v-else
            >
                <div class="d-flex justify-content-between align-items-start">
                    <p class="fs-6 fw-medium mb-1">{{ review.text }}</p>
                    <span class="fw-medium ms-3" style="white-space: nowrap">
                        ~ {{ review.user }}
                    </span>
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
import Swal from 'sweetalert2'

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
            url: 'http://127.0.0.1:8000/storage/',
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
            Swal.fire({
                title: 'Berhasil',
                text: 'Buku telah berhasil dimasukkan ke dalam keranjang.',
                icon: 'success',
                confirmButtonText: 'Lanjutkan',
            })
        },
        async fetchReviews() {
            try {
                const response = await fetch(
                    `http://127.0.0.1:8000/api/Buku/LihatUlasanBuku/${this.book.id}`,
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
                const response = await fetch(`http://127.0.0.1:8000/api/Buku/UlasanBuku`, {
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
.form-control:focus {
    border-color: black !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.25) !important;
}
</style>
