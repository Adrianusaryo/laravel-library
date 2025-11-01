<template>
    <div class="d-flex">
        <NavbarDewasa :name="name" />
        <div class="flex-grow-1 px-4">
            <div class="container">
                <h5 class="fw-bold mt-4" style="line-height: 10px">Papan Peringkat</h5>
                <p class="text-muted">
                    Daftar peringkat anggota berdasarkan jumlah peminjaman buku terbanyak.
                </p>
                <div class="alert alert-dark py-2 px-3 mb-4" role="alert" style="font-size: 14px">
                    <i class="fa fa-info-circle me-2"></i>
                    Dapatkan 10 poin untuk setiap peminjaman buku dan raih posisi tiga teratas
                    bulanan untuk memperoleh penghargaan menarik.
                </div>

                <!-- Kirim leaderboardUsers sebagai prop ke child component -->
                <LeaderboardCharts :leaderboardUsers="leaderboardUsers" />
            </div>
            <Footer />
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Footer from '@/components/Footer.vue'
import LeaderboardCharts from '@/components/LeaderboardCharts.vue'
import NavbarDewasa from '@/components/NavbarDewasa.vue'

export default {
    components: {
        NavbarDewasa,
        LeaderboardCharts,
        Footer,
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
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap');
* {
    font-family: 'Nunito';
}
.fa {
    font-family: 'Font Awesome 6 Free' !important;
}
</style>
