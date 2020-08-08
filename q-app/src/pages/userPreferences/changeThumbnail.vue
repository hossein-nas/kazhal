<template>
    <div class="change-thumbnail" >
        <div class="row justify-center">
            <div class="col-md-7 col-12 ">
                <div class="form" >
                    <form action=""
                          ref="form"
                          @input="changed">

                        <progress-bar :value="100" />

                    </form>
                </div><!-- /.form -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
</template>

<script>
import ProgressBar from '@/components/Image/ProgressBar'
import { mapGetters } from 'vuex'

export default {
    name: 'changeThumbnail',

    components: {
        ProgressBar
    },

    data () {
        return {
            file: null,
            anyChange: false,
            thumbnail: {
                title: '',
                desc: ''
            }
        }
    },
    watch: {
        file ($el) {
            console.log(this.$refs.form)
        }

    },
    computed: {
        ...mapGetters({ user: 'auth/getUserInfo' })
    },
    created () {
        this.initData()
    },
    methods: {
        changed () {
            this.anyChange = true
        },
        initData () {
            this.thumbnail.title = this.user.photo.title
            this.thumbnail.desc = this.user.photo.desc
        },
        submitFileUpload () {
            let data = {
                file: this.file,
                name: this.file.name,
                title: this.thumbnail.title,
                desc: this.thumbnail.desc
            }
            console.log(data)
        },
        fileRule ($file) {
            if ($file === null) {
                return false || 'فایلی انتخاب نشده است'
            }
            if ($file.size > 500000) {
                return false || 'حجم فایل بیش از حد مجاز است.'
            }
            return true
        }

    }
}
</script>

<style lang="scss" scoped>
.change-thumbnail{

}
</style>
