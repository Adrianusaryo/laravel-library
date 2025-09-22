<template>
    <div class="d-flex">
        <NavbarDewasa :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <Acara :event="event" />
            </div>
            <Footer />
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import Acara from '@/components/Acara.vue'
import Footer from '@/components/Footer.vue'
import NavbarDewasa from '@/components/NavbarDewasa.vue'

export default {
    components: {
        NavbarDewasa,
        Footer,
        Acara,
    },
    data() {
        return {
            name,
            event: null,
            loading: true,
            error: null,
        }
    },
    async mounted() {
        this.name = sessionStorage.getItem('name')
        const acaraId = sessionStorage.getItem('event_id')
        try {
            const response = await axios.get('https://e-library.up.railway.app/api/Acara/ListAcara', {
                headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
            })
            const events = response.data.data || response.data
            this.event = events.find((e) => e.id.toString() === acaraId.toString())
        } catch (err) {
            this.error = 'Gagal mengambil data acara'
            console.error(err)
        } finally {
            this.loading = false
        }
    },
}
</script>
<style scoped></style>
