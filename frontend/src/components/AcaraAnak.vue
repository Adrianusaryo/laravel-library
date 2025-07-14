<template>
    <div v-if="event" class="container mt-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-4 text-center">
                <img
                    :src="url + event.poster"
                    :alt="`Cover Acara ${event.title}`"
                    class="img-fluid rounded shadow-lg"
                    style="width: 500px; height: 400px; object-fit: cover; object-position: center"
                />
            </div>

            <div class="col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <span
                        class="badge bg-body-secondary text-dark me-3"
                        style="font-size: 0.8rem"
                        >{{ event.kategori }}</span
                    >
                    <h6 class="fw-bold mb-0 text-dark">{{ event.nama_acara }}</h6>
                </div>

                <table class="table table-bordered mt-2 px-2" style="font-size: 0.8rem">
                    <tbody>
                        <tr>
                            <td class="fw-medium text-dark w-25">
                                <i class="fa fa-calendar px-2"></i>Waktu
                            </td>
                            <td class="">{{ formatTanggal(event.tanggal) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-medium text-dark"><i class="fa fa-clock px-2"></i>Jam</td>
                            <td class="">
                                {{ formatJam(event.jam_mulai) }} -
                                {{ formatJam(event.jam_selesai) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-medium text-dark">
                                <i class="fa fa-microphone px-2"></i>Narasumber
                            </td>
                            <td class="">{{ event.narasumber }}</td>
                        </tr>
                        <tr>
                            <td class="fw-medium text-dark">
                                <i class="fa fa-building px-2"></i>Lokasi
                            </td>
                            <td class="">{{ event.lokasi }}</td>
                        </tr>
                        <tr>
                            <td class="fw-medium text-dark">
                                <i class="fa fa-location-dot px-2"></i>Alamat
                            </td>
                            <td class="">{{ event.alamat }}</td>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <h4 class="fw-medium text-dark mb-1">Deskripsi</h4>
                    <p class="fs-6 text-muted">{{ event.deskripsi }}</p>
                </div>
            </div>
        </div>
    </div>
    <div
        v-else
        class="d-flex flex-column align-items-center justify-content-center text-center p-5"
    >
        <div class="spinner-border text-dark mb-3" role="status" style="width: 3rem; height: 3rem">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="text-muted fw-semibold mb-0" style="font-size: 1.1rem">
            Sedang memuat data acara...
        </p>
        <small class="text-muted">Mohon tunggu sebentar ya!</small>
    </div>
</template>

<script>
export default {
    data() {
        return {
            url: 'http://127.0.0.1:8000/storage/',
        }
    },
    props: {
        event: {
            type: Object,
            required: true,
        },
    },
    methods: {
        formatTanggal(tanggal) {
            const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
            const bulan = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ]

            const date = new Date(tanggal)
            const namaHari = hari[date.getDay()]
            const tanggalNum = date.getDate()
            const namaBulan = bulan[date.getMonth()]
            const tahun = date.getFullYear()

            return `${namaHari}, ${tanggalNum} ${namaBulan} ${tahun}`
        },
        formatJam(jam) {
            if (!jam) return '-'
            return jam.slice(0, 5)
        },
    },
}
</script>

<style scoped>
img {
    width: 100%;
    height: auto;
    object-fit: cover;
}

.text-dark {
    color: #6f4e95 !important;
}

.btn-dark {
    background-color: #6f4e95 !important;
    border-color: #6f4e95 !important;
}
</style>
