<template>
    <div class="d-flex">
        <NavbarRemaja :name="name" />
        <div class="flex-grow-1 px-4 bg-dark">
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
                    <RouterLink class="btn btn-dark" to="/Remaja/Koleksi"
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
            <FooterRemaja />
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import PeminjamanItem from '@/components/KeranjangRemaja.vue'
import { useCartStore } from '@/stores/cartStore'
import NavbarRemaja from '@/components/NavbarRemaja.vue'
import FooterRemaja from '@/components/FooterRemaja.vue'

export default {
    components: {
        NavbarRemaja,
        FooterRemaja,
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
                    'http://127.0.0.1:8000/api/Peminjaman/PinjamBuku',
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
.bg-dark {
    background-color: #f4f6f9 !important;
    height: 100vh;
}

.text-dark {
    color: #344767 !important;
}

.btn-dark {
    background-color: #344767 !important;
}
</style>
