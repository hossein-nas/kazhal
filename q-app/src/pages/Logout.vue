<template>
    <q-page padding class="flex flex-center">
        <h5 v-if="show">شما با موفقیت خارج شدید</h5>
    </q-page>
</template>

<script>
export default {
    name: 'Logout',
    data () {
        return {
            show: false
        }
    },
    created () {
        this.$axios.post('/api/logout')
            .then(response => {
                this.show = true
                setTimeout(() => { this.$router.push('/login') }, 1000)
            })
            .catch(() => {
            })
    }
}
</script>
