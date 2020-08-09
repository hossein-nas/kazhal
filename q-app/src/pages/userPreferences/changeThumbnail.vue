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

                        <image-uploader :show="uploaderShowing"></image-uploader>

                        <q-separator spaced="xl" ></q-separator>

                        <div class="submit flex justify-end q-mt-md">
                            <q-btn unelevated
                                   class=""
                                   label="ثبت تصویر شاخص"
                                   size=".75rem"
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
import ImageUploader from '@/components/Image/ImageUploader'

export default {
    name: 'changeThumbnail',

    components: {
        ImageUploader,
    },

    data () {
        return {
            file: null,
            userThumb: {},
            uploaderShowing: false,
        }
    },

    computed: {
        ...mapGetters({ user: 'auth/getUserInfo', }),

        userThumbSrc () {
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
