<template>
    <div v-if="cerpen" class="container p-5 mb-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-4 text-center">
                <img
                    :src="cerpen.poster ? url + cerpen.poster : defaultCover"
                    :alt="`Cover Buku`"
                    class="img-fluid rounded shadow-lg"
                    style="max-height: 450px; height: 350px; object-fit: cover"
                />
            </div>

            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h4 class="fw-bold mb-0 text-dark" style="line-height: 15px">
                        {{ cerpen.judul }}
                    </h4>
                </div>
                <h5 class="text-muted mb-3">{{ cerpen.penulis }} (Penulis)</h5>
                <div
                    class="text-muted"
                    style="white-space: pre-line; line-height: 1.2; text-align: justify"
                >
                    {{ cerpen.isi }}
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h4 class="fw-semibold text-dark mb-2">Tulis Ulasan</h4>
            <form @submit.prevent="submitReview">
                <div class="mb-3">
                    <textarea
                        class="form-control fs-6"
                        rows="3"
                        v-model="reviewText"
                        placeholder="Tulis ulasan cerpen di sini..."
                    ></textarea>
                </div>
                <button type="submit" class="btn btn-dark px-3 py-2">
                    <i class="fa fa-comment-dots me-2"></i>Kirim
                </button>
            </form>
        </div>

        <div>
            <h4 class="fw-semibold text-dark">Ulasan Pengguna</h4>

            <div v-if="reviewsLocal.length === 0" class="alert alert-warning" role="alert">
                Belum ada ulasan untuk buku ini. Jadilah yang pertama memberikan ulasan!
            </div>

            <!-- List ulasan -->
            <div
                v-else
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
import defaultCover from '../../../frontend/src/assets/image/sapi.jpeg'

export default {
    props: {
        cerpen: {
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
            url: 'http://127.0.0.1:8000/storage/Cerpen/',
            defaultCover,
            reviewsLocal: [],
        }
    },
    watch: {
        cerpen(newCerpen) {
            if (newCerpen && newCerpen.id) {
                this.fetchReviews()
            }
        },
    },
    methods: {
        async fetchReviews() {
            try {
                const response = await fetch(
                    `http://127.0.0.1:8000/api/Cerpen/LihatUlasanCerpen/${this.cerpen.id}`,
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
                const response = await fetch(`http://127.0.0.1:8000/api/Cerpen/UlasanCerpen`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${sessionStorage.getItem('token')}`,
                    },
                    body: JSON.stringify({
                        cerpen_id: this.cerpen.id,
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
.bg-body {
    background-color: #faf5ff !important;
}

.btn-dark {
    background-color: #6f4e95 !important;
    border-color: #6f4e95 !important;
}

.text-dark {
    color: #6f4e95 !important;
}

.form-control:focus {
    border-color: #6f4e95 !important;
    box-shadow: 0 0 0 0.25rem rgba(111, 78, 149, 0.25);
}
</style>
