<template>
    <q-page padding>
        <div class="row">

            <div class="col-12 col-md-9 newpost-inputs">
            </div><!-- /.col-12 col-md-9 -->

            <div class="col-12 col-md-3 side-widgets">
            </div><!-- /.col-12 col-md-3 -->

        </div><!-- /.row -->

    </q-page>
</template>

<script>
export default {
    name: 'newPost',
    data () {
        return {
            newPost: true,
            postModel: null
        }
    },
    async beforeCreate () {
        if (Object.keys(this.$route.params).length) {
            this.newPost = false
            let id = this.$route.params.id
            try {
                let post = await this.$axios.get(`api/posts/${id}/`)
                this.postModel = post.data.post
            } catch (e) {}
        }
    }
}
</script>

<style lang="scss">

</style>
