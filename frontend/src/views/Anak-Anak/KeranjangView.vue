<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <h5 class="fw-bold mt-4 text-dark" style="line-height: 10px">
                    Keranjang Peminjaman
                </h5>
                <p class="text-muted">Yuk selesaikan peminjaman!</p>
                <div v-if="daftarBuku.length === 0" class="text-center my-5">
                    <h4 class="fw-bold text-dark" style="line-height: 15px">
                        Ups, keranjang kamu kosong
                    </h4>
                    <p class="text-muted">Yuk tambahkan buku favorit kamu ke keranjang</p>
                    <RouterLink class="btn btn-dark" to="/DaftarKoleksiRemaja"
                        >Cari Buku Sekarang</RouterLink
                    >
                </div>
                <div v-else>
                    <PeminjamanItem
                        v-for="(buku, index) in daftarBuku"
                        :key="index"
                        :id="buku.id"
                        :cover="url + buku.cover_buku"
                        :judul="buku.judul"
                        :pengarang="buku.penulis"
                        :deskripsi="buku.deskripsi"
                        @hapus="hapusBuku"
                    />
                </div>
                <button
                    v-if="daftarBuku.length > 0"
                    class="btn btn-dark w-100 rounded fw-semibold"
                    @click="pinjamBuku"
                >
                    <i class="fa fa-shopping-bag me-2"></i>Pinjam Buku
                </button>
            </div>
            <Footer />
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import PeminjamanItem from '@/components/KeranjangAnak.vue'
import { useCartStore } from '@/stores/cartStore'
import NavbarAnak from '@/components/NavbarAnak.vue'
import Footer from '@/components/Footer.vue'

export default {
    components: {
        NavbarAnak,
        Footer,
        PeminjamanItem,
    },
    data() {
        return {
            name: '',
            url: 'http://127.0.0.1:8000/storage/',
            cart: useCartStore(),
        }
    },
    computed: {
        daftarBuku() {
            return this.cart.items
        },
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
    },
    methods: {
        hapusBuku(id) {
            this.cart.removeFromCart(id)
        },
        async pinjamBuku() {
            const bukuId = this.daftarBuku.map((buku) => buku.id)

            try {
                const response = await axios.post(
                    'https://laravel-library-production.up.railway.app/api/Peminjaman/PinjamBuku',
                    { buku_id: bukuId },
                    {
                        headers: {
                            Authorization: `Bearer ${sessionStorage.getItem('token')}`,
                        },
                    },
                )
                alert('Peminjaman Berhasil')
                this.cart.clearCart()
            } catch (error) {
                console.error('Gagal meminjam buku:', error)
                alert('Gagal meminjam buku. Silakan coba lagi.')
            }
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
</style>
