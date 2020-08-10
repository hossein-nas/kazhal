<template>
    <div class="change-thumbnail" >
        <div class="row justify-center">
            <div class="col-md-7 col-12 ">
                <div class="form" >
                    <form action=""
                          ref="form">

                        <div class="UserThumbnail">
                            <div class="Thumbnail__area">
                                <img :src="userThumbSrc"
                                     :alt="user.photo.title">
                            </div>
                            <div class="Thumbnail__change q-py-md ">
                                <q-btn label="تغییر تصویر شاخص"
                                       flat
                                       size=".75rem"
                                       color="blue-8"
                                       :ripple="false"
                                       @click.prevent="changeThumbnail"></q-btn>
                            </div>
                        </div>

                        <div class="success-message text-center q-my-md non-selectable"
                             v-show="fileChanged">
                            <p class="text-body1 text-green-7 q-ma-none q-mb-sm">فایل با موفقیت انتخاب شد</p>
                            <p class="text-caption text-grey-7">برای تکمیل <strong>فرآیند تغییر تصویر شاخص</strong> دکمه <strong>ثبت تصویر شاخص</strong> را بزنید</p>
                        </div>

                        <q-separator spaced="xl" ></q-separator>

                        <div class="submit flex justify-end q-mt-md">
                            <q-btn unelevated
                                   class=""
                                   label="ثبت تصویر شاخص"
                                   size=".75rem"
                                   :disabled="!fileChanged"
                                   @click.prevent="submitThumb"
                                   color="teal-4"
                                   padding="sm md"
                            />
                        </div>
                    </form>
                </div><!-- /.form -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import CropperDialog from '@/components/widgets/CropperDialog'

export default {
    name: 'changeThumbnail',

    components: {
    },

    data () {
        return {
            file: null,
            userThumb: {},
            fileChanged: false,
            newThumb: null,
        }
    },

    computed: {
        ...mapGetters({ user: 'auth/getUserInfo', }),

        userThumbSrc () {
            if (this.fileChanged) return this.newThumb.dataURL

            return window.baseURL + this.user.photo.specs[0].relativepath
        },
    },

    created () {
    },

    methods: {
        fileRule ($file) {
            if ($file === null) {
                return false || 'فایلی انتخاب نشده است'
            }

            if ($file.size > 500000) {
                return false || 'حجم فایل بیش از حد مجاز است.'
            }

            return true
        },

        changeThumbnail () {
            this.$q.dialog({
                component: CropperDialog,
                parent: this,
                url: '/api/files/upload',
            }).onOk((payload) => {
                this.fileChanged = true
                this.newThumb = { id: payload.data.data.id, dataURL: payload.dataURL, }
            })
        },

        submitThumb () {
            let uri = `/api/user/change-thumbnail/${this.user.id}`
            let data = {
                thumbnail_id: this.newThumb.id,
            }

            this.$axios.post(uri, data)
                .then((data) => {
                })
        },
    },
}
</script>

<style lang="scss" scoped>
.form{

    .UserThumbnail{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;

        .Thumbnail__area{
            position: relative;
            overflow: hidden;
            width: 9rem;
            height: 9rem;
            border-radius: 100%;
            box-shadow: 0 4px 20px -4px rgba(black, .3);
            border: 2px solid #d8d8d8;

            img{
                position: absolute;
                right: 0  #{"/* rtl:ignore */"};
                margin-right: 50%  #{"/* rtl:ignore */"};
                transform: translateX(50%)  #{"/* rtl:ignore */"};
                width: auto;
                height: 100%;
            }
        } // !.Thumbnail__area

        .Thumbnail__change{
            flex:0 0 100%;
            display: flex;
            justify-content: center;
        }// .Thumbnail__change
    }// !.UserThumbnail
}
</style>
