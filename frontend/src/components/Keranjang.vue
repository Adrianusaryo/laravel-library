<template>
    <div class="card border-0 rounded mb-3 d-flex flex-row align-items-start shadow-sm bg-light">
        <!-- Gambar Cover -->
        <div class="position-relative py-3 px-2" style="min-width: 150px; max-width: 140px">
            <img
                :src="cover"
                alt="Cover Buku"
                class="w-100 h-100 rounded"
                style="object-fit: cover"
            />
        </div>

        <!-- Info Buku -->
        <div class="flex-grow-1 pt-5 px-2" style="line-height: 1rem">
            <h5 class="fw-bold" style="line-height: 0.5rem">{{ judul }}</h5>
            <p class="text-muted" style="font-size: 0.9rem">{{ pengarang }}</p>
            <p class="text-secondary" style="font-size: 0.85rem">
                {{ deskripsi }}
            </p>
            <div class="d-flex align-items-start">
                <input
                    type="text"
                    class="form-control me-2"
                    placeholder="Tulis catatan..."
                    v-model="catatan"
                />
                <button class="btn btn-outline-danger" @click="$emit('hapus', id)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: [String, Number],
        cover: String,
        judul: String,
        pengarang: String,
        deskripsi: String,
    },
    data() {
        return {
            catatan: '',
        }
    },
}
</script>

<style scoped></style>
