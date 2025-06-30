import HomeView from '@/views/HomeView.vue'
import HomeAnak from '@/views/Anak-Anak/HomeView.vue'
import HomeRemaja from '@/views/Remaja/HomeView.vue'
import HomeDewasa from '@/views/Dewasa/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import { createRouter, createWebHistory } from 'vue-router'
import DaftarKoleksiRemaja from '@/views/Remaja/DaftarKoleksiView.vue'
import DaftarKoleksi from '@/views/Dewasa/DaftarKoleksi.vue'
import AcaraView from '@/views/Dewasa/AcaraView.vue'
import LeaderboardView from '@/views/Dewasa/LeaderboardView.vue'
import ProfileView from '@/views/Dewasa/ProfileView.vue'
import KeranjangView from '@/views/Dewasa/KeranjangView.vue'
import TransaksiView from '@/views/Dewasa/AktivitasView.vue'
import DetailBukuView from '@/views/Dewasa/DetailBukuView.vue'
import DetailAcaraView from '@/views/Dewasa/DetailAcaraView.vue'
import UsulBukuView from '@/views/Dewasa/UsulBukuView.vue'
import LeaderboardRemaja from '@/views/Remaja/LeaderboardView.vue'
import KeranjangRemaja from '@/views/Remaja/KeranjangView.vue'
import AcaraRemaja from '@/views/Remaja/AcaraView.vue'
import TransaksiRemaja from '@/views/Remaja/AktivitasView.vue'
import UsulBukuRemaja from '@/views/Remaja/UsulBukuView.vue'
import ProfileRemaja from '@/views/Remaja/ProfileView.vue'
import DetailBukuViewRemaja from '@/views/Remaja/DetailBukuView.vue'
import DetailAcaraViewRemaja from '@/views/Remaja/DetailAcaraView.vue'
import DaftarKoleksiAnak from '@/views/Anak-Anak/DaftarKoleksiView.vue'
import DetailBukuAnak from '@/views/Anak-Anak/DetailBukuView.vue'
import LeaderboardAnak from '@/views/Anak-Anak/LeaderboardView.vue'
import KeranjangAnak from '@/views/Anak-Anak/KeranjangView.vue'
import AcaraAnak from '@/views/Anak-Anak/AcaraView.vue'
import DetailAcaraAnak from '@/views/Anak-Anak/DetailAcaraView.vue'
import TransaksiAnak from '@/views/Anak-Anak/AktivitasView.vue'
import ProfilAnak from '@/views/Anak-Anak/ProfileView.vue'
import CerpenAnak from '@/views/Anak-Anak/CerpenView.vue'
import KirimCerpenAnak from '@/views/Anak-Anak/KirimCerpenView.vue'
import DetailCerpenAnak from '@/views/Anak-Anak/DetailCerpenView.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView,
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView,
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterView,
        },

        // Group: Anak
        {
            path: '/Anak',
            children: [
                { path: '', name: 'anak-anak', component: HomeAnak },
                { path: 'Koleksi', name: 'daftarkoleksianak', component: DaftarKoleksiAnak },
                { path: 'Detail-Buku', name: 'detailbukuanak', component: DetailBukuAnak },
                { path: 'Leaderboard', name: 'leaderboardanak', component: LeaderboardAnak },
                { path: 'Keranjang', name: 'keranjanganak', component: KeranjangAnak },
                { path: 'Acara', name: 'acaraanak', component: AcaraAnak },
                { path: 'Detail-acara', name: 'detailacaraanak', component: DetailAcaraAnak },
                { path: 'Transaksi', name: 'transaksianak', component: TransaksiAnak },
                { path: 'Cerpen', name: 'cerpenanak', component: CerpenAnak },
                { path: 'Kirim-Cerpen', name: 'kirimcerpenanak', component: KirimCerpenAnak },
                { path: 'Detail-Cerpen', name: 'cerpenanakdetail', component: DetailCerpenAnak },
                { path: 'Profil', name: 'profileanak', component: ProfilAnak },
            ],
        },

        // Group: Remaja
        {
            path: '/Remaja',
            children: [
                { path: '', name: 'remaja', component: HomeRemaja },
                { path: 'Koleksi', name: 'daftarkoleksiremaja', component: DaftarKoleksiRemaja },
                {
                    path: 'Detail-Buku',
                    name: 'detailbukuremaja',
                    component: DetailBukuViewRemaja,
                    props: true,
                },
                { path: 'Leaderboard', name: 'leaderboardremaja', component: LeaderboardRemaja },
                { path: 'Keranjang', name: 'keranjangremaja', component: KeranjangRemaja },
                { path: 'Acara', name: 'acararemaja', component: AcaraRemaja },
                {
                    path: 'Detail-Acara',
                    name: 'detailacararemaja',
                    component: DetailAcaraViewRemaja,
                    props: true,
                },
                { path: 'Transaksi', name: 'transaksiremaja', component: TransaksiRemaja },
                { path: 'Usul-Buku', name: 'usulbukuremaja', component: UsulBukuRemaja },
                { path: 'Profil', name: 'profileremaja', component: ProfileRemaja },
            ],
        },

        // Group: Dewasa
        {
            path: '/Dewasa',
            children: [
                { path: '', name: 'dewasa', component: HomeDewasa },
                { path: 'Koleksi', name: 'daftarkoleksidewasa', component: DaftarKoleksi },
                {
                    path: 'Detail-Buku',
                    name: 'detailbukudewasa',
                    component: DetailBukuView,
                    props: true,
                },
                { path: 'Leaderboard', name: 'leaderboarddewasa', component: LeaderboardView },
                { path: 'Keranjang', name: 'keranjangdewasa', component: KeranjangView },
                { path: 'Acara', name: 'acaradewasa', component: AcaraView },
                {
                    path: 'Detail-Acara',
                    name: 'detailacaradewasa',
                    component: DetailAcaraView,
                    props: true,
                },
                { path: 'Aktivitas', name: 'transaksidewasa', component: TransaksiView },
                { path: 'Usul-Buku', name: 'usulbukudewasa', component: UsulBukuView },
                { path: 'Profil', name: 'profiledewasa', component: ProfileView },
            ],
        },
    ],
})

export default router
