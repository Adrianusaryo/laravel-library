<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <AcaraAnak :event="event" />
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import FooterRemaja from '@/components/FooterRemaja.vue'
import NavbarAnak from '@/components/NavbarAnak.vue'
import AcaraAnak from '@/components/AcaraAnak.vue'

export default {
    components: {
        NavbarAnak,
        FooterRemaja,
        AcaraAnak,
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
            const response = await axios.get('http://127.0.0.1:8000/api/Acara/ListAcara', {
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
.text-dark {
    color: #344767 !important;
}

.btn-dark {
    background-color: #344767 !important;
}
</style>
