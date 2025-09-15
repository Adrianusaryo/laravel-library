<template>
    <div class="d-flex">
        <NavbarRemaja :name="name" />
        <div class="flex-grow-1 px-4 bg-dark">
            <div class="container">
                <AcaraRemaja :event="event" />
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import NavbarRemaja from '@/components/NavbarRemaja.vue'
import AcaraRemaja from '@/components/AcaraRemaja.vue'

export default {
    components: {
        NavbarRemaja,
        AcaraRemaja,
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
            const response = await axios.get('https://laravel-library-production.up.railway.app/api/Acara/ListAcara', {
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
