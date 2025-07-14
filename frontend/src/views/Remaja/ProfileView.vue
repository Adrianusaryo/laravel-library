<template>
    <div class="d-flex min-vh-100">
        <NavbarRemaja :name="name" />
        <div class="flex-grow-1 px-4 py-4 bg-dark">
            <div class="container">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fa fa-address-card me-2 text-dark"></i>Biodata
                            </h5>
                            <button
                                class="btn btn-dark rounded btn-sm py-2 px-3"
                                @click="showForm = !showForm"
                            >
                                <i class="fa fa-pen-to-square me-1"></i>
                                {{ showForm ? 'Batal' : 'Perbarui Data' }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-darkk">Nama Lengkap</label>
                                <div class="text-muted">{{ biodata.name }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-darkk">Email</label>
                                <div class="text-muted">{{ biodata.email }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-dark">Jenis Kelamin</label>
                                <div class="text-muted">
                                    {{ biodata.jenis_kelamin }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-dark">No. WhatsApp</label>
                                <div class="text-muted">{{ biodata.nomor_telfon || '-' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-dark">Alamat</label>
                                <div class="text-muted">{{ biodata.alamat || '-' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-dark">Tanggal Lahir</label>
                                <div class="text-muted">{{ biodata.tanggal_lahir }}</div>
                            </div>
                        </div>

                        <!-- Form Update -->
                        <div v-if="showForm" class="mt-4 border-top pt-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Nama Lengkap</label>
                                    <input v-model="biodata.name" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Email</label>
                                    <input v-model="biodata.email" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark"
                                        >Jenis Kelamin</label
                                    >
                                    <select v-model="biodata.jenis_kelamin" class="form-select">
                                        <option value="-">Pilih</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">No. WhatsApp</label>
                                    <input v-model="biodata.nomor_telfon" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Alamat</label>
                                    <input v-model="biodata.alamat" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark"
                                        >Tanggal Lahir</label
                                    >
                                    <input
                                        type="date"
                                        v-model="biodata.tanggal_lahir"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button class="btn btn-dark btn-sm px-2 py-2" @click="submitUpdate">
                                    <i class="fa fa-floppy-disk me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <FooterRemaja />
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import NavbarRemaja from '@/components/NavbarRemaja.vue'
import FooterRemaja from '@/components/FooterRemaja.vue'

export default {
    components: {
        NavbarRemaja,
        FooterRemaja,
    },
    data() {
        return {
            name: '',
            showForm: false,
            biodata: {
                name: '',
                email: '',
                jenis_kelamin: '',
                nomor_telfon: '',
                alamat: '',
                tanggal_lahir: '',
            },
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
        this.fetchUserData()
    },
    methods: {
        fetchUserData() {
            axios
                .get('http://127.0.0.1:8000/api/Auth/Profile', {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    const user = response.data.data
                    console.log(user)

                    this.biodata.name = user.name || ''
                    this.biodata.email = user.email || ''
                    this.biodata.jenis_kelamin = user.jenis_kelamin || '-'
                    this.biodata.nomor_telfon = user.nomor_telfon || ''
                    this.biodata.alamat = user.alamat || ''
                    this.biodata.tanggal_lahir = user.tanggal_lahir || ''
                })
                .catch((error) => {
                    console.error('Gagal mengambil data user:', error)
                })
        },
        submitUpdate() {
            axios
                .put('http://127.0.0.1:8000/api/Auth/ProfileUpdate', this.biodata, {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                })
                .then((response) => {
                    console.log('Update berhasil:', response.data)
                    this.showForm = false
                    location.reload()
                })
                .catch((error) => {
                    console.error('Gagal mengambil data user:', error)
                })
        },
    },
}
</script>

<style scoped>
.card {
    border-radius: 1rem;
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

.form-control:focus {
    border-color: #344767 !important;
    box-shadow: 0 0 0 0.2rem rgba(52, 71, 103, 0.25) !important;
}
</style>
