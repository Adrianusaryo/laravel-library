<template>
    <div class="d-flex">
        <NavbarAnak :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <h5 class="fw-bold mt-4 text-dark" style="line-height: 10px">Leaderboard</h5>
                <p class="text-muted">Peringkat pengguna berdasarkan aktivitas.</p>
                <div
                    class="alert alert-warning py-2 px-3 mb-4"
                    role="alert"
                    style="font-size: 14px"
                >
                    <i class="fas fa-info-circle me-2"></i>
                    Pinjam buku, kumpulkan <strong>10 poin</strong> tiap transaksi. 3 peringkat
                    teratas akan mendapat hadiah menarik!.
                </div>

                <LeaderboardChartsAnak :leaderboardUsers="leaderboardUsers" />
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import NavbarAnak from '@/components/NavbarAnak.vue'
import LeaderboardChartsAnak from '@/components/LeaderboardChartsAnak.vue'

export default {
    components: {
        NavbarAnak,
        LeaderboardChartsAnak,
    },
    data() {
        return {
            name: '',
            token: '',
            leaderboardUsers: [],
        }
    },
    mounted() {
        this.name = sessionStorage.getItem('name')
        this.token = sessionStorage.getItem('token')
        this.leaderboard()
    },
    methods: {
        leaderboard() {
            axios
                .get('http://127.0.0.1:8000/api/Leaderboard/LihatLeaderboardDewasa', {
                    headers: { Authorization: `Bearer ${this.token}` },
                })
                .then((response) => {
                    this.leaderboardUsers = response.data.data
                })
                .catch((error) => {
                    console.error('Gagal load leaderboard:', error)
                })
        },
    },
}
</script>

<style scoped>
.bg-dark {
    background-color: #faf5ff !important;
}

.text-dark {
    color: #6f4e95 !important;
}
</style>
