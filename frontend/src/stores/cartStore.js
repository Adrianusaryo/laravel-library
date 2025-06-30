import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: JSON.parse(localStorage.getItem('cart')) || [],
    }),
    actions: {
        addToCart(book) {
            const exits = this.items.find((item) => item.id === book.id)
            if (!exits) {
                this.items.push(book)
                this.saveToLocalStorage()
            }
        },
        removeFromCart(id) {
            this.items = this.items.filter((item) => item.id !== id)
            this.saveToLocalStorage()
        },
        saveToLocalStorage() {
            localStorage.setItem('cart', JSON.stringify(this.items))
        },
        clearCart() {
            this.items = []
            this.saveToLocalStorage()
        },
    },
})
