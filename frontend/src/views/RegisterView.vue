<template>
    <section class="login d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="col-11 col-md-6 col-lg-5">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-4">
                    <!-- Logo & Title -->
                    <div class="text-center">
                        <img src="/View_Logo.png" alt="Logo" width="100" class="mb-2" />
                        <h3 class="fw-bold text-dark">Perpustakaan MBK</h3>
                        <p class="text-secondary small">Nikmati bacaanmu di Perpustakaan MBK.</p>
                    </div>

                    <!-- Login Form -->
                    <form @submit.prevent="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold text-dark"
                                        >Email</label
                                    >
                                    <input
                                        type="email"
                                        id="email"
                                        class="form-control rounded-pill"
                                        placeholder="Masukkan Email"
                                        v-model="email"
                                        :class="{ 'is-invalid': errors.email }"
                                    />
                                    <div v-if="errors.email" class="invalid-feedback">
                                        {{ errors.email[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold text-dark"
                                        >Password</label
                                    >
                                    <div class="input-group">
                                        <input
                                            :type="showPassword ? 'text' : 'password'"
                                            id="password"
                                            class="form-control rounded-start-pill"
                                            placeholder="Masukkan Password"
                                            v-model="password"
                                            :class="{ 'is-invalid': errors.password }"
                                        />
                                        <button
                                            type="button"
                                            class="btn btn-dark rounded-end-pill"
                                            @click="togglePassword"
                                        >
                                            <i
                                                :class="
                                                    showPassword ? 'fas fa-unlock' : 'fas fa-lock'
                                                "
                                            ></i>
                                        </button>
                                        <div
                                            v-if="errors.password"
                                            class="invalid-feedback d-block"
                                        >
                                            {{ errors.password[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold text-dark"
                                        >Nama
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        class="form-control rounded-pill"
                                        placeholder="Masukkan Nama"
                                        v-model="name"
                                        :class="{ 'is-invalid': errors.name }"
                                    />
                                    <div v-if="errors.name" class="invalid-feedback">
                                        {{ errors.name[0] }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold text-dark"
                                        >Tanggal Lahir</label
                                    >
                                    <input
                                        type="date"
                                        id="tanggal_lahir"
                                        class="form-control rounded-pill"
                                        v-model="tanggal_lahir"
                                        :class="{ 'is-invalid': errors.tanggal_lahir }"
                                    />
                                    <div v-if="errors.name" class="invalid-feedback">
                                        {{ errors.tanggal_lahir[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button
                            @click="register()"
                            class="btn btn-dark w-100 rounded-pill fw-semibold"
                        >
                            Register
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Sudah memiliki akun?
                            <RouterLink to="/login" class="fw-semibold text-dark">
                                Masuk di sini
                            </RouterLink>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import axios from 'axios'
import router from '@/router'

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            tanggal_lahir: '',
            errors: [],
            showPassword: false,
        }
    },
    methods: {
        register() {
            axios
                .post('http://127.0.0.1:8000/api/Auth/Register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    tanggal_lahir: this.tanggal_lahir,
                })
                .then((response) => {
                    router.push({ name: 'login' })
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        togglePassword() {
            this.showPassword = !this.showPassword
        },
    },
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap');

.login {
    font-family: 'Nunito';
}

.form-control:focus {
    border-color: #222 !important;
    box-shadow: 0 0 0 0.15rem rgba(0, 0, 0, 0.25) !important;
}

.text-dark {
    line-height: 1.5rem;
}
</style>
