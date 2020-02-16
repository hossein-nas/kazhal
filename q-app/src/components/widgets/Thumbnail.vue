<template>
    <div class="panel">
        <div class="header">
            افزودن تصویر شاخص
        </div> <!-- /.header -->
        <div class="body">
            <div class="no-thumb"
                 v-if="!hasThumb" >
                <div class="text">
                    تصویر شاخص انتخاب نشده.
                </div>
                <div class="add-new-thumb"
                     @click="openDialog">
                    افزودن تصویر
                </div>
            </div>

            <div class="thumb"
                 v-if="hasThumb">
                <div class="thumb-area">
                    <img :src="thumbImgSrc"
                         alt="">
                </div>
                <div class="change-thumb add-new-thumb"
                     @click="resetThumbnail" >
                    تغییر تصویر شاخص
                </div>
            </div>

        </div> <!-- /.body -->

        <q-dialog v-model="ThumbnailDialog"
                  persistent
                  position="bottom">
            <q-card style="width:100%; max-width: 700px">
                <q-card-section>
                    <div class="text-h6 text-center">
                        بارگذاری تصویر شاخص
                    </div>
                </q-card-section>
                <q-separator />

                <q-card-section>
                    <div class="cropper-area">
                        <cropper v-model="thumbnail" />
                    </div>
                </q-card-section>
                <q-card-actions class="flex justify-end">
                    <q-btn label="انصراف"
                           flat
                           color="red-4"
                           @click.stop="closeDialog" />
                    <q-btn label="تایید"
                           unelevated
                           v-if="thumbImg"
                           color="secondary"
                           @click.stop="setThumbnail" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </div> <!-- /.panel -->
</template>

<script>
import Cropper from '@/components/Cropper'

export default {
    name: 'Thumbnail',
    components: {
        Cropper
    },
    props: {
        value: {
            type: Object,
            required: true
        }
    },
    watch: {
        thumbnail (val) {
            this.thumbImg = val.previewImage
        }
    },
    data () {
        return {
            thumbnail: {
            },
            ThumbnailDialog: false,
            hasThumb: false,
            thumbImg: null
        }
    },
    mounted () {
        if (this.value.thumbnail_path && this.valu.thumbnail_path.length) {
            this.hasThumb = true
        }
    },
    methods: {
        openDialog () {
            this.ThumbnailDialog = true
        },
        closeDialog () {
            this.ThumbnailDialog = false
        },
        setThumbnail () {
            this.closeDialog()
            this.hasThumb = true
        },
        resetThumbnail () {
            this.hasThumb = false
            this.thumbImg = null
            this.openDialog()
        }
    },
    computed: {
        thumbImgSrc () {
            return 'http://kazhal.test' + this.thumbImg
        }
    }
}
</script>

<style lang="scss">
.panel{
    .body{
        .no-thumb, .thumb{
            text-align: center;
            .text{
                min-height: 4rem;
                line-height:4rem;
                font-size: 1rem;
                color: $rp-danger-light;
                text-align: center;
            }
            .thumb-area{
                display: block;
                padding: .5rem 1.5rem .25rem;
                text-align: center;
                img{
                    width: auto;
                    max-height:120px;
                    border-radius: .5rem;
                    border: 2px solid white;
                    box-shadow: 0 4px 6px -2px $rp-gray-2;
                }
            }
            .add-new-thumb{
                padding: .25rem;
                margin-bottom: .5rem;
                font-size:.8rem;
                display: inline-block;
                color: $rp-blue;
                text-align: center;
                &:hover{
                    color: darken($rp-blue, 15);
                    cursor: pointer;
                    text-decoration: underline;
                }
            }
        }
    }
}
</style>
