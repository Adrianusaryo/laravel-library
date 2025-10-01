<template>
    <section class="login d-flex flex-column-reverse flex-md-row">
        <div class="login-left w-md-50 w-100 h-md-100 bg-body-tertiary">
            <div class="row justify-content-center align-items-center h-100 pt-3">
                <div class="col-md-7">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img
                            src="/View_Logo.png"
                            alt="Logo"
                            width="100"
                            class="pb-2 d-none d-md-block"
                        />
                        <h2 class="fw-semibold text-dark">Perpustakaan MBK</h2>
                        <p class="text-muted fs-6">
                            Salamat datang di Perpustakaan MBK, temukan bacaan favoritmu setiap
                            hari.
                        </p>
                    </div>

                    <div class="login-form pb-3">
                        <form @submit.prevent="">
                            <div class="mb-2">
                                <label for="email" class="form-label fw-medium text-dark"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    placeholder="Masukan Email "
                                    v-model="email"
                                    :class="{ 'is-invalid': errors.email }"
                                />
                                <div v-if="errors.email" class="invalid-feedback">
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium text-dark"
                                    >Password</label
                                >
                                <div class="input-group has-validation">
                                    <input
                                        :type="showPassword ? 'text' : 'password'"
                                        class="form-control"
                                        id="password"
                                        placeholder="Masukan Password"
                                        v-model="password"
                                        :class="{ 'is-invalid': errors.password }"
                                    />
                                    <span
                                        class="input-group-text text-dark"
                                        @click="togglePassword"
                                        style="cursor: pointer"
                                    >
                                        <i
                                            :class="showPassword ? 'fas fa-unlock' : 'fas fa-lock'"
                                        ></i>
                                    </span>
                                    <div v-if="errors.password" class="invalid-feedback">
                                        {{ errors.password[0] }}
                                    </div>
                                </div>
                            </div>

                            <button @click="login()" class="btn btn-dark w-100">Login</button>
                        </form>
                        <div class="text-center mt-2">
                            <span class="text-muted"
                                >Don't have an account ?
                                <RouterLink to="/register" class="text-dark fst-italic fw-medium"
                                    >Sign up for free</RouterLink
                                >
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="login-right w-md-50 w-100 h-100">
            <div
                id="carouselExampleFade"
                class="carousel slide carousel-fade"
                data-bs-ride="carousel"
                data-bs-pause="false"
            >
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="4000">
                        <img src="@/assets/image/login_1.png" class="d-block w-100" alt="..." />
                        <div class="overlay"></div>
                    </div>
                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/login_2.png" class="d-block w-100" alt="..." />
                        <div class="overlay"></div>
                    </div>
                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/login_3.png" class="d-block w-100" alt="..." />
                        <div class="overlay"></div>
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
                .post('https://e-library.up.railway.app/api/Auth/Login', {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    sessionStorage.setItem('email', response.data.data.email)
                    sessionStorage.setItem('name', response.data.data.name)
                    sessionStorage.setItem('token', response.data.data.token)
                    sessionStorage.setItem('tanggal_lahir', response.data.data.tanggal_lahir)

                    const today = new Date()
                    const birthDate = new Date(response.data.data.tanggal_lahir)
                    let age = today.getFullYear() - birthDate.getFullYear()
                    const monthDiff = today.getMonth() - birthDate.getMonth()
                    if (
                        monthDiff < 0 ||
                        (monthDiff == 0 && today.getDate() < birthDate.getDate())
                    ) {
                        age--
                    }

                    if (age >= 2 && age <= 12) {
                        router.push({ name: 'anak-anak' })
                    } else if (age >= 13 && age <= 21) {
                        router.push({ name: 'remaja' })
                    } else {
                        router.push({ name: 'dewasa' })
                    }
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
    color: #552801 !important;
    line-height: 1.5rem;
}

.btn-dark {
    background-color: #552801 !important;
}

.carousel-item {
    position: relative;
}

.carousel-item .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

.carousel-item img {
    max-height: 100vh;
    width: auto;
    object-fit: cover;
    object-position: center center;
}

.form-control:focus {
    border-color: #552801 !important;
    box-shadow: 0 0 0 0.2rem rgba(85, 40, 1, 0.25) !important;
}
</style>
