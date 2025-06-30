<template>
    <div
        class="card border-0 mb-3 d-flex flex-row align-items-start shadow"
        style="border-radius: 12px; overflow: hidden"
    >
        <div class="position-relative p-3" style="min-width: 100px; max-width: 140px">
            <img
                :src="cover"
                alt="Cover Buku"
                class="w-100 h-100 rounded"
                style="object-fit: cover"
            />
        </div>

        <div class="flex-grow-1 p-3">
            <h5 class="fw-bold mb-1 text-dark" style="line-height: 17px">{{ judul }}</h5>
            <p class="mb-2 text-muted" style="font-size: 0.9rem">{{ pengarang }}</p>
            <p class="mb-3 text-secondary" style="font-size: 0.85rem">
                {{ deskripsi }}
            </p>

            <!-- Catatan + Tombol Hapus -->
            <div class="d-flex align-items-start">
                <input
                    type="text"
                    class="form-control me-2"
                    placeholder="Tulis catatan..."
                    v-model="catatan"
                />
                <button class="btn btn-outline-danger" @click="$emit('hapus', id)">
                    <i class="fa fa-trash-alt"></i>
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

<style scoped>
.bg-dark {
    background-color: #f4f6f9 !important;
}

.btn-dark {
    background-color: #6f4e95 !important;
    border-color: #6f4e95 !important;
}

.text-dark {
    color: #6f4e95 !important;
}
.form-control:focus {
    border-color: #6f4e95 !important;
    box-shadow: 0 0 0 0.25rem rgba(111, 78, 149, 0.25);
}
</style>
