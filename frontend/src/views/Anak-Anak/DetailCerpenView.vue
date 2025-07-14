<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4 bg-white">
            <div class="container">
                <CerpenAnak :cerpen="cerpen" />
            </div>
        </div>
    </div>
</template>
<script>
import CerpenAnak from '@/components/CerpenAnak.vue'
import NavbarAnak from '@/components/NavbarAnak.vue'
import axios from 'axios'

export default {
    components: {
        NavbarAnak,
        CerpenAnak,
    },
    data() {
        return {
            name: '',
            cerpen: null,
            loading: true,
            error: null,
        }
    },
    async mounted() {
        this.name = sessionStorage.getItem('name')
        const cerpenId = sessionStorage.getItem('cerpen_id')
        try {
            const response = await axios.get('http://127.0.0.1:8000/api/Cerpen/LihatCerpen', {
                headers: { Authorization: `Bearer ${sessionStorage.getItem('token')}` },
            })
            const cerpens = response.data.data.data
            this.cerpen = cerpens.find((b) => b.id.toString() === cerpenId.toString())
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
