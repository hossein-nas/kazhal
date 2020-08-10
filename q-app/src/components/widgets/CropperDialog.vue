<template>
    <q-dialog ref="dialog"
              position="bottom"
              transition-show="slide-up"
              @hide="onDialogHide">
        <q-card class="q-dialog-plugin"
                style="min-width: 80%">
            <q-card-section>
                <div class="FileSelection__area"
                     v-show="!fileSelected">
                    <div class="row flex justify-center">
                        <q-file
                            v-model="file"
                            size=".75rem"
                            @input="selected"
                            outlined
                            accept="image/*"
                            style="max-width: 50%"
                            max-file-size="2097152"
                            @rejected="fileSelectionReject"
                            label="تصویری را انتخاب کنید" >
                            <template v-slot:append>
                                <q-icon name="attach_file" />
                            </template>
                        </q-file>
                    </div><!--  /.row -->
                </div>

                <div class="Cropper__area"
                     v-show="cropping">
                    <cropper
                        classname="cropper"
                        :src="fileData"
                        :stencil-props="{
                            aspectRatio:1
                        }"
                        ref="cropper"
                        @change="change"
                    ></cropper>

                    <div class="q-mt-md flex justify-center">
                        <q-btn flat
                               label="برش تصویر"
                               size=".75rem"
                               color="primary"
                               @click="crop" />
                    </div>
                </div>

                <div class="Cropper__preview"
                     v-show="cropped">
                    <div class="img_preview">
                        <img :src="croppedImage">
                    </div>

                    <div class="q-mt-md flex justify-center full-width">
                        <q-btn unelevated
                               :ripple="false"
                               v-show="!uploading && !uploaded"
                               label="آپلود تصویر"
                               size=".875rem"
                               color="primary"
                               @click="upload" />
                    </div>
                </div>

                <div class="Uploading__area flex justify-center"
                     v-show="uploading || uploaded">
                    <progress-bar v-model="uploadProgress" ></progress-bar>
                </div>
            </q-card-section>

            <!-- buttons example -->
            <q-card-actions align="right">
                <q-btn label="تأیید و ثبت"
                       color="secondary"
                       padding="sm lg"
                       unelevated
                       v-if="uploaded"
                       size=".75rem"
                       @click="onOKClick" />
                <q-btn label="انصراف"
                       size=".75rem"
                       padding="sm md"
                       flat
                       color="red-6"
                       @click="onCancelClick" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import { Cropper } from 'vue-advanced-cropper'
import ProgressBar from '@/components/Image/ProgressBar'

export default {
    name: 'CropperDialog',

    props: {
        url: {
            type: String,
            required: true,
        },
        headerText: {
            type: String,
        },
        prop: {
            type: Object,
            default: () => {
                return {
                    title: 'تصویر شاخص بدون نام',
                    desc: 'بدون درج توضیح.',
                }
            },
        },
    },

    components: {
        ProgressBar,
    },

    data () {
        return {
            fileSelected: false,
            uploading: false,
            uploaded: false,
            uploadProgress: 0,
            uploadResponseData: null,
            cropping: false,
            cropped: false,
            file: null,
            fileData: null,
            fileToUpload: null,
            croppedImage: null,
            fileStat: {
                name: null,
                title: this.prop.title,
                desc: this.prop.desc,
            },
        }
    },

    created () {
        console.log(this.props)
    },

    methods: {
        upload () {
            this.uploading = true

            let data = new FormData()

            data.append('file', this.fileToUpload)
            data.append('title', this.fileStat.title)
            data.append('desc', this.fileStat.desc)
            data.append('name', this.fileStat.name)

            this.$axios.post(this.url, data, this.progressConfig())
                .then((res) => {
                    this.uploading = false
                    this.uploaded = true

                    this.uploadResponseData = res.data
                })
        },

        progressConfig () {
            return {
                onUploadProgress: (progressEvent) => {
                    var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    this.uploadProgress = percentCompleted
                },
            }
        },

        uploadDone (data) {

        },

        crop () {
            const { coordinates, canvas, } = this.$refs.cropper.getResult()

            canvas.toBlob((blob) => {
                this.fileToUpload = blob
            }, 'image/jpeg')
            // You able to do different manipulations at a canvas
            // but there we just get a cropped image
            this.croppedImage = canvas.toDataURL()

            this.cropping = false
            this.cropped = true

            // this.$nextTick(() => this.$emit('ok', this.file))
        },

        async selected () {
            this.fileSelected = true
            this.fileStat.name = this.file.name

            await this.converToDataURL()
            this.cropping = true
        },

        converToDataURL () {
            return new Promise((resolve, reject) => {
                if (this.file && typeof this.file === 'object') {
                    let fileReader = new FileReader()

                    fileReader.onload = (e) => {
                        this.fileData = e.target.result

                        resolve()
                    }

                    fileReader.readAsDataURL(this.file)
                } else {
                    return reject()
                }
            })
        },

        fileSelectionReject () {

        },

        change ({ coordinates, canvas, }) {
            // console.log(coordinates, canvas)
        },
        // following method is REQUIRED
        // (don't change its name --> "show")
        show () {
            this.$refs.dialog.show()
        },

        // following method is REQUIRED
        // (don't change its name --> "hide")
        hide () {
            this.$refs.dialog.hide()
        },

        onDialogHide () {
            // required to be emitted
            // when QDialog emits "hide" event
            this.$emit('hide')
        },

        onOKClick () {
            // on OK, it is REQUIRED to
            // emit "ok" event (with optional payload)
            // before hiding the QDialog
            // or with payload: this.$emit('ok', { ... })

            // then hiding dialog

            this.$emit('ok', {
                data: this.uploadResponseData,
                dataURL: this.fileData,
            })

            this.hide()
        },

        onCancelClick () {
            // we just need to hide dialog
            this.hide()
        },
    },

}
</script>

<style lang="scss">
.Cropper__area{
    margin-top: 2rem;

    .vue-advanced-cropper.cropper{
        height: 400px;
        overflow: hidden;
    }
}

.Cropper__preview{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;

    .img_preview{
        width: 12rem;
        height: 12rem;
        position: relative;
        display: inline-block;
        border: 2px solid lighten($rp-input-border,8);
        box-shadow: 0 5px 15px -4px rgba(black, .2);
        padding: .25rem;
        border-radius:3px;
        // flex: 0 0 100%;
        background-color: #fff;
        text-align: center;

        img{
            height: 100%;
            width: auto;
        }
    }
}
</style>
