<template>
    <div class="change-thumbnail" >
        <div class="row justify-center">
            <div class="col-md-7 col-12 ">
                <div class="form" >
                    <form action="" ref="form" @input="changed">

                        <div class="form-control">
                            <div class="label">
                                انتخاب فایل
                            </div><!-- /.label -->
                            <q-file outlined v-model="file" :rules="[fileRule]">
                                <template v-slot:prepend>
                                <q-icon name="attach_file" />
                                </template>
                            </q-file>
                        </div><!-- /.form-control file-picker -->

                        <div class="form-control">
                            <div class="label">
                                عنوان عکس
                            </div><!-- /.label -->
                            <q-input v-model="thumbnail.title" outlined ref="title" hint="یک عنوان برای عکس مورد نظر انتخاب کنید."/>

                        </div><!-- /.form-control -->

                        <div class="form-control">
                            <div class="label">
                                توضیح :
                            </div><!-- /.label -->
                            <q-input v-model="thumbnail.desc" type="textarea" :row="3" outlined ref="title" hint="توضیح مختصری برای عکس بنویسید"/>

                        </div><!-- /.form-control -->

                        <div class="form-control  submit ">
                            <q-btn  flat style="color: #1c4440"
                            type="submit" @click.prevent="submitFileUpload" label="ثبت تغییرات" :disable="!anyChange"
                             />
                        </div><!-- /.form-control .submit -->

                    </form>
                </div><!-- /.form -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'changeThumbnail',
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
