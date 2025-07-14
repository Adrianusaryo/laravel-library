<template>
    <div class="d-flex">
        <NavbarRemaja :name="name" />
        <div class="flex-grow-1 px-4 bg-dark">
            <div class="container">
                <BukuRemaja :book="book" />
            </div>
        </div>
    </div>
</template>
<script>
import BukuRemaja from '@/components/BukuRemaja.vue'
import FooterRemaja from '@/components/FooterRemaja.vue'
import NavbarRemaja from '@/components/NavbarRemaja.vue'
import axios from 'axios'

export default {
    components: {
        NavbarRemaja,
        FooterRemaja,
        BukuRemaja,
    },
    data() {
        return {
            name: '',
            book: null,
            loading: true,
            error: null,
        }
    },
    async mounted() {
        this.name = sessionStorage.getItem('name')
        const bookId = sessionStorage.getItem('book_id')
        try {
            const response = await axios.get(
                'http://127.0.0.1:8000/api/Buku/KoleksiBuku?per_page=1000',
                {
                    headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
                },
            )
            const books = response.data.data
            this.book = books.find((b) => b.id.toString() === bookId.toString())
        } catch (err) {
            this.error = 'Gagal mengambil data buku'
            console.error(err)
        } finally {
            this.loading = false
        }
    },
}
</script>
<style scoped>
.bg-dark {
    background-color: #f4f6f9 !important;
    min-height: 100vh;
}

.btn-dark {
    background-color: #344767 !important;
}

.text-dark {
    color: #344767 !important;
}
</style>
