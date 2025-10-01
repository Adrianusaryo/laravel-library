<template>
    <section class="login d-flex vh-100">
        <div class="login-left w-50 h-100">
            <div
                id="carouselExampleFade"
                class="carousel slide carousel-fade"
                data-bs-ride="carousel"
                data-bs-pause="false"
            >
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="4000">
                        <img src="@/assets/image/login_1.png" class="d-block w-100" alt="..." />
                    </div>
                    <!-- <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/ayam-goreng.jpg" class="d-block w-100" alt="..." />
                    </div>
                    <div class="carousel-item" data-bs-interval="4000">
                        <img src="@/assets/image/cendol.jpg" class="d-block w-100" alt="..." />
                    </div> -->
                </div>
            </div>
        </div>
        <div class="login-right w-50 h-100 bg-light-subtle">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-md-9">
                    <div class="header text-center">
                        <h2 class="fw-semibold text-dark">
                            <i class="fa fa-book-open px-2"></i>E-Library
                        </h2>
                        <p class="text-muted fs-6">
                            Join us and start your journey to endless knowledge!
                        </p>
                    </div>
                    <div class="login-form">
                        <form @submit.prevent="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="email" class="form-label fw-medium text-dark"
                                            >Email</label
                                        >
                                        <input
                                            type="email"
                                            class="form-control"
                                            id="email"
                                            placeholder="Masukan Email"
                                            :class="{ 'is-invalid': errors.email }"
                                            v-model="email"
                                        />
                                        <div v-if="errors.email" class="invalid-feedback">
                                            {{ errors.email[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                                :class="
                                                    showPassword ? 'fas fa-unlock' : 'fas fa-lock'
                                                "
                                            ></i>
                                        </span>
                                        <div v-if="errors.password" class="invalid-feedback">
                                            {{ errors.password[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-medium text-dark">
                                            Nama
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            placeholder="Masukan Nama Anda"
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
                                        <label
                                            for="tanggal_lahir"
                                            class="form-label fw-medium text-dark"
                                            >Tanggal Lahir</label
                                        >
                                        <input
                                            type="date"
                                            class="form-control"
                                            id="date"
                                            :class="{ 'is-invalid': errors.tanggal_lahir }"
                                            v-model="tanggal_lahir"
                                        />
                                        <div v-if="errors.tanggal_lahir" class="invalid-feedback">
                                            {{ errors.tanggal_lahir[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button @click="register()" class="btn btn-dark w-100">Register</button>
                        </form>
                        <div class="text-center mt-2">
                            <span class="text-muted"
                                >Already have an account ?
                                <RouterLink to="/login" class="text-dark fst-italic fw-medium"
                                    >Login Now</RouterLink
                                >
                            </span>
                        </div>
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
                .post('https://e-library.up.railway.app/api/Auth/Register', {
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
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

.login {
    font-family: 'Roboto', sans-serif;
}

.carousel-inner {
    height: 100vh;
    display: flex;
    align-items: center;
}

.carousel-item {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.carousel-item img {
    max-height: 100vh;
    width: auto;
    object-fit: cover;
    object-position: center center;
}

.form-control:focus {
    border-color: #344767 !important;
    box-shadow: 0 0 0 0.2rem rgba(52, 71, 103, 0.25) !important;
}

* {
    box-sizing: border-box;
}

.login {
    overflow: hidden;
}

.bg-dark {
    background-color: #f4f6f9 !important;
}

.text-dark {
    color: #344767 !important;
}

.btn-dark {
    background-color: #344767 !important;
}
</style>
