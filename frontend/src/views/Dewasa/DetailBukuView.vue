<template>
    <div class="d-flex">
        <NavbarDewasa :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <Buku :book="book" />
            </div>
        </div>
    </div>
</template>
<script>
import Buku from '@/components/Buku.vue'
import Footer from '@/components/Footer.vue'
import NavbarDewasa from '@/components/NavbarDewasa.vue'
import axios from 'axios'

export default {
    components: {
        NavbarDewasa,
        Buku,
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
            const response = await axios.get('http://127.0.0.1:8000/api/Buku/KoleksiBuku', {
                headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
            })
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
<style></style>
