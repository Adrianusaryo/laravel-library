<template>
    <div class="d-flex min-vh-100">
        <NavbarDewasa :name="name" />
        <div class="flex-grow-1 px-4 py-4 bg-light">
            <div class="container">
                <!-- Biodata Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-medium mb-0">
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
                            <!-- Display Biodata -->
                            <div class="col-md-6" v-for="(value, key) in displayBiodata" :key="key">
                                <label class="fw-semibold">{{ value.label }}</label>
                                <div>{{ value.value }}</div>
                            </div>
                        </div>

                        <div v-if="showForm" class="mt-4 border-top pt-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input
                                        v-model="biodata.name"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.name }"
                                        required
                                    />
                                    <div v-if="errors.name" class="invalid-feedback">
                                        {{ errors.name[0] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input
                                        v-model="biodata.email"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.email }"
                                        required
                                    />
                                    <div v-if="errors.email" class="invalid-feedback">
                                        {{ errors.email[0] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select
                                        v-model="biodata.jenis_kelamin"
                                        class="form-select"
                                        :class="{ 'is-invalid': errors.jenis_kelamin }"
                                        required
                                    >
                                        <option value="-">Pilih</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <div v-if="errors.jenis_kelamin" class="invalid-feedback">
                                        {{ errors.jenis_kelamin[0] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. WhatsApp</label>
                                    <input
                                        v-model="biodata.nomor_telfon"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.nomor_telfon }"
                                        required
                                    />
                                    <div v-if="errors.nomor_telfon" class="invalid-feedback">
                                        {{ errors.nomor_telfon[0] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input
                                        v-model="biodata.alamat"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.alamat }"
                                        required
                                    />
                                    <div v-if="errors.alamat" class="invalid-feedback">
                                        {{ errors.alamat[0] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input
                                        type="date"
                                        v-model="biodata.tanggal_lahir"
                                        class="form-control"
                                        :class="{ 'is-invalid': errors.tanggal_lahir }"
                                        required
                                    />
                                    <div v-if="errors.tanggal_lahir" class="invalid-feedback">
                                        {{ errors.tanggal_lahir[0] }}
                                    </div>
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

            <Footer />
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Footer from '@/components/Footer.vue'
import NavbarDewasa from '@/components/NavbarDewasa.vue'

export default {
    components: {
        NavbarDewasa,
        Footer,
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
            errors: {},
        }
    },
    computed: {
        displayBiodata() {
            return {
                name: { label: 'Nama Lengkap', value: this.biodata.name },
                email: { label: 'Email', value: this.biodata.email },
                jenis_kelamin: { label: 'Jenis Kelamin', value: this.biodata.jenis_kelamin },
                nomor_telfon: { label: 'No. WhatsApp', value: this.biodata.nomor_telfon },
                alamat: { label: 'Alamat', value: this.biodata.alamat },
                tanggal_lahir: { label: 'Tanggal Lahir', value: this.biodata.tanggal_lahir },
            }
        },
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
                    this.biodata = {
                        name: user.name || '',
                        email: user.email || '',
                        jenis_kelamin: user.jenis_kelamin || '-',
                        nomor_telfon: user.nomor_telfon || '',
                        alamat: user.alamat || '',
                        tanggal_lahir: user.tanggal_lahir || '',
                    }
                })
                .catch((error) => {
                    console.error('Gagal mengambil data user:', error)
                })
        },
        submitUpdate() {
            // Reset error object
            this.errors = {}

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
                    if (error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                        console.log(this.errors)
                    } else {
                        console.error('Gagal update data:', error)
                    }
                })
        },
    },
}
</script>

<style scoped>
.card {
    border-radius: 1rem;
}
</style>
