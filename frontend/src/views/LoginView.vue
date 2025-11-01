<template>
    <section class="login d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="col-11 col-md-6 col-lg-4">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-4">
                    <!-- Logo & Title -->
                    <div class="text-center">
                        <img src="/View_Logo.png" alt="Logo" width="110" class="mb-2" />
                        <h3 class="fw-bold text-dark">Perpustakaan MBK</h3>
                        <p class="text-secondary small">Nikmati bacaanmu di Perpustakaan MBK.</p>
                    </div>

                    <!-- Login Form -->
                    <form @submit.prevent="">
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
                                    <i :class="showPassword ? 'fas fa-unlock' : 'fas fa-lock'"></i>
                                </button>
                                <div v-if="errors.password" class="invalid-feedback d-block">
                                    {{ errors.password[0] }}
                                </div>
                            </div>
                        </div>

                        <button
                            @click="login()"
                            class="btn btn-dark w-100 rounded-pill fw-semibold"
                        >
                            Login
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Belum punya akun?
                            <RouterLink to="/register" class="fw-semibold text-dark">
                                Daftar Gratis
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
            email: '',
            password: '',
            errors: [],
            showPassword: false,
        }
    },
    methods: {
        login() {
            axios
                .post('http://127.0.0.1:8000/api/Auth/Login', {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    sessionStorage.setItem('email', response.data.data.email)
                    sessionStorage.setItem('name', response.data.data.name)
                    sessionStorage.setItem('token', response.data.data.token)

                    router.push({ name: 'dewasa' })
                    // const today = new Date()
                    // const birthDate = new Date(response.data.data.tanggal_lahir)
                    // let age = today.getFullYear() - birthDate.getFullYear()
                    // const monthDiff = today.getMonth() - birthDate.getMonth()
                    // if (
                    //     monthDiff < 0 ||
                    //     (monthDiff == 0 && today.getDate() < birthDate.getDate())
                    // ) {
                    //     age--
                    // }

                    // if (age >= 2 && age <= 12) {
                    //     router.push({ name: 'anak-anak' })
                    // } else if (age >= 13 && age <= 21) {
                    //     router.push({ name: 'remaja' })
                    // } else {
                    //     router.push({ name: 'dewasa' })
                    // }
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
    mounted() {
        this.token = sessionStorage.getItem('token')
        if (this.token) {
            router.push({ name: 'home' })
        }
    },
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap');

.login {
    font-family: 'Nunito';
}

.text-dark {
    line-height: 1.5rem;
}

/* .btn-dark {
    background-color: #552801 !important;
} */

.form-control:focus {
    border-color: #222 !important;
    box-shadow: 0 0 0 0.15rem rgba(0, 0, 0, 0.25) !important;
}
</style>
