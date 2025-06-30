<template lang="">
    <div></div>
</template>
<script>
import router from '@/router'
export default {
    mounted() {
        this.token = sessionStorage.getItem('token')
        if (!this.token) {
            router.push({ name: 'login' })
        }
    },
}
</script>
<style lang=""></style>
