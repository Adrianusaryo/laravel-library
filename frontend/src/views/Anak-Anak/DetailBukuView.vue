<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4 bg-white">
            <div class="container">
                <BukuAnak :book="book" />
            </div>
        </div>
    </div>
</template>
<script>
import BukuAnak from '@/components/BukuAnak.vue'
import NavbarAnak from '@/components/NavbarAnak.vue'
import axios from 'axios'

export default {
    components: {
        NavbarAnak,
        BukuAnak,
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
                'https://laravel-library-production.up.railway.app/api/Buku/KoleksiBuku?per_page=1000',
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
<style scoped></style>
