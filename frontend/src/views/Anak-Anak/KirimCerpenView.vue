<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <h5 class="fw-bold mt-4 text-dark" style="line-height: 10px">Kirim Cerpen</h5>
                <p class="text-muted">
                    "Yuk kirim cerita buatan kamu! Seru, lucu, atau ajaib – kami mau baca semua!"
                </p>

                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-dark" @click="showForm = !showForm">
                        <i
                            :class="
                                showForm
                                    ? 'fa fa-face-grin-beam-sweat me-1'
                                    : 'fa fa-face-smile-wink me-1'
                            "
                        ></i>
                        {{ showForm ? 'Malu Deh' : 'Ceritaku Siap' }}
                    </button>
                </div>

                <div
                    v-if="showForm"
                    class="card border-0 bg-white shadow-sm mb-4 p-4"
                    style="border-radius: 14px"
                >
                    <h5 class="fw-bold mb-3 text-dark text-center">Bagikan Cerita Serumu</h5>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-medium">Judul Cerpen Kamu</label>
                        <input type="text" class="form-control" v-model="judul" />
                        <small class="text-danger" v-if="errors?.judul">{{
                            errors.judul[0]
                        }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-medium">Nama Kamu</label>
                        <input type="text" class="form-control" v-model="penulis" />
                        <small class="text-danger" v-if="errors?.penulis">{{
                            errors.penulis[0]
                        }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-medium">Isi Cerpen Kamu</label>
                        <textarea
                            name=""
                            id=""
                            rows="8"
                            class="form-control"
                            v-model="isi"
                        ></textarea>
                        <small class="text-danger" v-if="errors?.isi">{{ errors.isi[0] }}</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-medium"
                            >Cover Cerpen Kamu
                            <small class="text-muted">(Boleh dikosongkan ya)</small></label
                        >
                        <input
                            class="form-control"
                            type="file"
                            id="formFile"
                            @change="handleFileUpload"
                        />
                    </div>
                    <button class="btn btn-dark" @click="kirimCerpen" :disabled="loadingSubmit">
                        <span
                            v-if="loadingSubmit"
                            class="spinner-border spinner-border-sm me-2"
                            role="status"
                            aria-hidden="true"
                        ></span>
                        Bagikan Cerpen
                    </button>
                    <p v-if="successMessage" class="text-success mt-2">{{ successMessage }}</p>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-sm btn-dark rounded-circle me-2">
                        <i class="fa fa-book-open"></i>
                    </button>
                    <span class="fw-semibold fs-6 text-dark">Riwayat Kirim Cerpen</span>
                </div>

                <div
                    v-if="loadingCerpen"
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
                        Sedang memuat data riwayat cerpen...
                    </p>
                    <small class="text-muted">Mohon tunggu sebentar ya!</small>
                </div>

                <div v-else-if="KirimCerpen.length > 0">
                    <div
                        v-for="(cerpen, index) in KirimCerpen"
                        :key="'cerpen-' + index"
                        class="card border-0 mb-3 d-flex flex-row align-items-start shadow-sm"
                        style="border-radius: 12px; overflow: hidden; background-color: #f9f9f9"
                    >
                        <!-- Gambar Cover -->
                        <div
                            class="position-relative px-2 py-4"
                            style="min-width: 100px; max-width: 140px"
                        >
                            <img
                                :src="cerpen.poster ? url + cerpen.poster : defaultCover"
                                alt="Cover Cerpen"
                                class="w-100 h-100 rounded"
                                style="object-fit: cover"
                            />
                        </div>

                        <!-- Info Cerpen -->
                        <div class="flex-grow-1 px-2 py-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <!-- Judul -->
                                <h5 class="fw-bold text-dark mb-0" style="line-height: 1.3">
                                    {{ cerpen.judul }}
                                </h5>

                                <!-- Status Badge -->
                                <span
                                    class="badge rounded-pill px-3 py-2 fw-semibold"
                                    :class="{
                                        'bg-warning-subtle text-warning':
                                            cerpen.status === 'Pending',
                                        'bg-success-subtle text-success':
                                            cerpen.status === 'Approved',
                                        'bg-danger-subtle text-danger':
                                            cerpen.status === 'Rejected',
                                    }"
                                >
                                    <i
                                        :class="{
                                            'fa fa-hourglass-half': cerpen.status === 'Pending',
                                            'fa fa-check-circle': cerpen.status === 'Approved',
                                            'fa fa-times-circle': cerpen.status === 'Rejected',
                                        }"
                                        class="me-1"
                                    ></i>
                                    {{ statusMessage(cerpen.status) }}
                                </span>
                            </div>
                            <p class="text-muted" style="font-size: 0.9rem; line-height: 5px">
                                Penulis: {{ cerpen.penulis }}
                            </p>
                            <p class="mb-3 text-secondary" style="font-size: 0.7rem">
                                {{ cerpen.isi }}
                            </p>
                            <!-- <p class="mb-3 text-secondary" style="font-size: 0.85rem">
                                Status:
                                <span
                                    class="badge rounded-pill px-3 py-2 fw-semibold"
                                    :class="{
                                        'bg-warning-subtle text-warning':
                                            cerpen.status === 'Pending',
                                        'bg-success-subtle text-success':
                                            cerpen.status === 'Approved',
                                        'bg-danger-subtle text-danger':
                                            cerpen.status === 'Rejected',
                                    }"
                                >
                                    <i
                                        :class="{
                                            'fa fa-hourglass-half': cerpen.status === 'Pending',
                                            'fa fa-check-circle': cerpen.status === 'Approved',
                                            'fa fa-times-circle': cerpen.status === 'Rejected',
                                        }"
                                        class="me-1"
                                    ></i>
                                    {{ statusMessage(cerpen.status) }}
                                </span>
                            </p> -->
                        </div>
                    </div>
                </div>

                <div v-else class="text-center my-5">
                    <h4 class="fw-bold text-dark" style="line-height: 10px">
                        Belum ada kiriman cerpen
                    </h4>
                    <p class="text-muted">Yuk kirim cerpen terbaik kamu disini!</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavbarAnak from '@/components/NavbarAnak.vue'
import axios from 'axios'
import defaultCover from '../../../src/assets/image/sapi.jpeg'

export default {
    components: {
        NavbarAnak,
    },
    data() {
        return {
            name: '',
            judul: '',
            penulis: '',
            isi: '',
            successMessage: '',
            KirimCerpen: [],
            errors: null,
            showForm: false,
            token: '',
            poster: null,
            url: 'http://127.0.0.1:8000/storage/Cerpen/',
            defaultCover,
            loadingCerpen: false,
            loadingSubmit: false,
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
        this.token = sessionStorage.getItem('token')
        this.getKirimCerpen()
    },
    methods: {
        getKirimCerpen() {
            this.loadingCerpen = true
            axios
                .get('http://127.0.0.1:8000/api/Cerpen/LihatRiwayatPengiriman', {
                    headers: { Authorization: `Bearer ${this.token}` },
                })
                .then((response) => {
                    this.KirimCerpen = response.data.data.sort((a, b) => {
                        if (a.status === 'Pending' && b.status !== 'Pending') return -1
                        if (a.status !== 'Pending' && b.status === 'Pending') return 1
                        return 0
                    })
                })
                .catch((error) => {
                    console.error('Kirim Cerpen Error:', error)
                })
                .finally(() => {
                    this.loadingCerpen = false
                })
        },
        kirimCerpen() {
            this.loadingSubmit = true
            const formData = new FormData()
            formData.append('judul', this.judul)
            formData.append('penulis', this.penulis)
            formData.append('isi', this.isi)
            formData.append('poster', this.poster)
            axios
                .post('http://127.0.0.1:8000/api/Cerpen/KirimCerpen', formData, {
                    headers: {
                        Authorization: `Bearer ${this.token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                })
                .then((response) => {
                    this.successMessage = response.data.message || 'Usulan buku berhasil dikirim!'
                    this.judul = ''
                    this.penulis = ''
                    this.isi = ''
                    this.poster = null
                    this.errors = null
                    this.showForm = false
                    this.getKirimCerpen()
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
        statusMessage(status) {
            switch (status) {
                case 'Pending':
                    return 'Sedang Ditinjau '
                case 'Approved':
                    return 'Disetujui '
                case 'Rejected':
                    return 'Ditolak '
                default:
                    return status
            }
        },
        handleFileUpload(event) {
            this.poster = event.target.files[0]
            console.log('File dipilih:', this.poster)
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
