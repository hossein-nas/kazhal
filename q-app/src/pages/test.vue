<template>
    <q-page >
        <div  class="q-pa-lg">
            <h2 class="q-ma-none">این یک پیغام آزمایشی می‌باشد.</h2>
            <q-ajax-bar ref="bar" position="top" color="accent" size="4px" skip-hijack />
        </div>
    </q-page>
</template>

<script>
export default {
    name: 'Test',

    data () {
        return {
            bar: null
        }
    },

    mounted () {
        this.$refs.bar.start()
        setTimeout(() => {
            if (this.$refs.bar) {
                this.$refs.bar.stop()
            }
        }, 500)
    }
}
</script>

<style lang="css" scoped></style>
