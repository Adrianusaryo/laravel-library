<template>
    <div class="d-flex">
        <NavbarRemaja :name="name" />
        <div class="flex-grow-1 px-4 bg-dark">
            <div class="container">
                <h5 class="fw-bold mt-4 text-dark" style="line-height: 10px">Usulan Buku</h5>
                <p class="text-muted">
                    Harap isi data dengan benar. Kami akan menginformasikan status usulan buku
                    melalui WhatsApp kamu
                </p>

                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-dark" @click="showForm = !showForm">
                        <i :class="showForm ? 'fa fa-times me-1' : 'fa fa-plus me-1'"></i>
                        {{ showForm ? 'Tutup Form Usulan' : 'Usulkan Buku' }}
                    </button>
                </div>

                <div
                    v-if="showForm"
                    class="card border-0 bg-white shadow-sm mb-4 p-4"
                    style="border-radius: 14px"
                >
                    <h5 class="fw-bold mb-3 text-dark">Form Usulan Buku</h5>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-medium">Judul Buku</label>
                        <input type="text" class="form-control" v-model="judul" />
                        <small class="text-danger" v-if="errors?.judul">{{
                            errors.judul[0]
                        }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-medium">Pengarang</label>
                        <input type="text" class="form-control" v-model="pengarang" />
                        <small class="text-danger" v-if="errors?.pengarang">{{
                            errors.pengarang[0]
                        }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-medium">Penerbit</label>
                        <input type="text" class="form-control" v-model="penerbit" />
                        <small class="text-danger" v-if="errors?.penerbit">{{
                            errors.penerbit[0]
                        }}</small>
                    </div>
                    <button class="btn btn-dark" @click="usulBuku" :disabled="loadingSubmit">
                        <span
                            v-if="loadingSubmit"
                            class="spinner-border spinner-border-sm me-2"
                            role="status"
                            aria-hidden="true"
                        ></span>
                        Kirim Usulan
                    </button>
                    <p v-if="successMessage" class="text-success mt-2">{{ successMessage }}</p>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-sm btn-dark rounded-circle me-2">
                        <i class="fa fa-book-open"></i>
                    </button>
                    <span class="fw-semibold fs-6 text-dark">Riwayat Usulan Buku</span>
                </div>

                <div
                    v-if="loadingUsulan"
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
                        Sedang memuat data riwayat...
                    </p>
                    <small class="text-muted">Mohon tunggu sebentar ya!</small>
                </div>

                <div v-else-if="UsulBuku.length > 0">
                    <div
                        v-for="(usul, index) in UsulBuku"
                        :key="'usul-' + index"
                        class="card border-0 shadow-sm mb-3 bg-white"
                        style="border-radius: 14px"
                    >
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-bold mb-0 text-dark">{{ usul.judul }}</h5>
                                <span
                                    class="badge d-flex align-items-center gap-2 px-3 py-2 rounded-pill fw-semibold"
                                    :class="{
                                        'bg-light text-warning border border-warning':
                                            usul.status === 'Proses',
                                        'bg-light text-success border border-success':
                                            usul.status === 'Diterima',
                                        'bg-light text-danger border border-danger':
                                            usul.status === 'Ditolak',
                                    }"
                                >
                                    <i
                                        :class="{
                                            'fa fa-hourglass-half': usul.status === 'Proses',
                                            'fa fa-circle-check': usul.status === 'Diterima',
                                            'fa fa-circle-xmark': usul.status === 'Ditolak',
                                        }"
                                    ></i>
                                    {{ usul.status }}
                                </span>
                            </div>
                            <div class="text-muted mb-1" style="font-size: 0.9rem">
                                <i class="fa fa-pen-nib me-2"></i> Penulis:
                                <strong>{{ usul.pengarang }}</strong>
                            </div>
                            <div class="text-muted mb-1" style="font-size: 0.9rem">
                                <i class="fa fa-building-columns me-2"></i> Penerbit:
                                <strong>{{ usul.penerbit }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center my-5">
                    <h4 class="fw-bold text-dark" style="line-height: 10px">
                        Belum ada usulan buku
                    </h4>
                    <p class="text-muted">Yuk usulkan buku yang ingin kamu baca!</p>
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
            judul: '',
            penerbit: '',
            pengarang: '',
            successMessage: '',
            UsulBuku: [],
            errors: null,
            showForm: false,
            token: '',
            loadingUsulan: false,
            loadingSubmit: false,
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
        this.token = sessionStorage.getItem('token')
        this.getUsulanBuku()
    },
    methods: {
        getUsulanBuku() {
            this.loadingUsulan = true
            axios
                .get('https://laravel-library-production.up.railway.app/api/Buku/LihatUsulBuku', {
                    headers: { Authorization: `Bearer ${this.token}` },
                })
                .then((response) => {
                    this.UsulBuku = response.data.data.sort((a, b) => {
                        if (a.status === 'Proses' && b.status !== 'Proses') return -1
                        if (a.status !== 'Proses' && b.status === 'Proses') return 1
                        return 0
                    })
                })
                .catch((error) => {
                    console.error('Peminjaman Error:', error)
                })
                .finally(() => {
                    this.loadingUsulan = false
                })
        },
        usulBuku() {
            this.loadingSubmit = true
            axios
                .post(
                    'https://laravel-library-production.up.railway.app/api/Buku/UsulBuku',
                    {
                        judul: this.judul,
                        penerbit: this.penerbit,
                        pengarang: this.pengarang,
                    },
                    { headers: { Authorization: `Bearer ${this.token}` } },
                )
                .then((response) => {
                    this.successMessage = response.data.message || 'Usulan buku berhasil dikirim!'
                    this.judul = ''
                    this.penerbit = ''
                    this.pengarang = ''
                    this.errors = null
                    this.showForm = false
                    this.getUsulanBuku()
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
                .finally(() => {
                    this.loadingSubmit = false
                })
        },
    },
}
</script>

<style scoped>
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

.form-control:focus {
    border-color: #344767 !important;
    box-shadow: 0 0 0 0.2rem rgba(52, 71, 103, 0.25) !important;
}
</style>
