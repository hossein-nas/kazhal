<template>
    <div>
        <div class="input-file"
             v-if="!isFileSelected" >
            <div class="form">
                <div class="form-control">
                    <div class="label">
                        انتخاب تصویر
                    </div>
                    <q-file outlined
                            v-model="selectedFile"
                            ref="file"
                            :rules="[fileValidate]"
                            hint="تصویر مورد نظر را انتخاب کنید" >
                        <template v-slot:append>
                            <q-icon name="attach_file" />
                        </template>
                    </q-file>
                </div>
            </div>

        </div>
        <div class="cropper-area"
             v-if="selectedFile">
            <div class="cropper"
                 dir="ltr" >
                <img   ref="cr_img"
                       :src="imgSrc"
                       alt=""
                       crossorigin>
            </div>
            <div class="preview"
                 v-if="previewImg">
                <img :src="previewImg"
                     alt="">
            </div>
            <div class="buttons"
                 v-if="!uploadingDone" >
                <div class="button upload-server"
                     v-if="previewImg"
                     @click.prevent.stop="uploadCropedImage">
                    آپلود به سرور
                    <q-linear-progress  :value="uploadingValue"
                                        v-if="uploading"
                                        class="q-mt-sm"/>
                </div>
                <div class="button crop-img"
                     v-if="!previewImg"
                     @click="crop_image">
                    بریدن تصویر
                </div>
            </div>

            <div class="success-message"
                 v-if="uploadingDone" >
                تصویر با موفقیت بارگذاری شد.
            </div>
        </div>
    </div>
</template>

<script>
import Cropper from 'cropperjs'
export default {
    name: 'croppervue',
    props: {
        value: {
            required: true
        },
        ratio: {
            type: Number,
            required: true
        }
    },
    data () {
        return {
            selectedFile: null,
            isFileSelected: false,
            uploading: false,
            uploadingDone: false,
            uploadingValue: 0,
            imgBlob: null,
            cropper: {},
            cropperInit: false,
            previewImg: null,
            imgSrc: ''
        }
    },
    watch: {
        selectedFile (file) {
            if (file) {
                this.isFileSelected = !this.$refs.file.innerError
            }
        },
        isFileSelected (val) {
            this.initImg()
        },
        imgSrc (val) {
            if (val) {
                setTimeout(this.init_cropper(), 200)
            }
        }
    },
    mounted () {
    },
    methods: {
        emitEvent (imageData) {
            let data = {
                previewImage: imageData.data.specs[0].relativepath,
                thumbnailId: imageData.data.id
            }
            this.$emit('input', data)
        },
        initImg () {
            let file_reader = new FileReader()
            file_reader.onload = (loadedFile) => {
                let dataURL = loadedFile.target.result
                this.imgSrc = dataURL
            }
            file_reader.readAsDataURL(this.selectedFile)
        },
        init_cropper () {
            let img = this.$refs.cr_img
            this.cropper = new Cropper(img, {
                aspectRatio: this.ratio,
                dragMode: 'move',
                autoCropArea: 1,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: false,
                toggleDragModeOnDblclick: false,
                viewMode: 2,
                checkCrossOrigin: false,
                ready () {
                },
                crop (event) {
                }
            })
            this.cropper.replace(this.imgSrc)
        },
        async crop_image () {
            let data = this.cropper.getImageData()
            let canvas = this.cropper.getCroppedCanvas({
                maxWidth: 1080,
                minWidth: 1080,
                imageSmoothingEnabled: false,
                imageSmoothingQuality: 1
            })
            canvas.toBlob((blob) => {
                this.cropper.destroy()
                this.imgBlob = blob
                this.previewImg = canvas.toDataURL()
            })
        },
        uploadCropedImage () {
            let data = new FormData()
            data.append('file', this.imgBlob)
            data.append('title', 'No Title set')
            data.append('desc', 'No Description.')
            data.append('name', this.selectedFile.name)
            data.append('keywords', [])
            this.uploading = true
            this.$axios.post('/api/files/upload', data, {
                headers: { 'Content-Type': 'multipart/form-data' },
                onUploadProgress: (progressEvent) => {
                    const totalLength = progressEvent.lengthComputable ? progressEvent.total : progressEvent.target.getResponseHeader('content-length') || progressEvent.target.getResponseHeader('x-decompressed-content-length')
                    if (totalLength !== null) {
                        let progress = Math.ceil((progressEvent.loaded * 100) / totalLength)
                        this.uploadingValue = (progress / 100.0)
                    }
                }
            })
                .then((res) => {
                    if (res.data.status === 'success') {
                        this.uploading = false
                        this.uploadingDone = true
                        this.uploadingValue = 0
                        this.emitEvent(res.data)
                    }
                })
                .catch(() => {
                    console.log('error')
                })
        },
        fileValidate (val) {
            if (!val) {
                return
            }
            if (val.type && val.type.length) {
                let type = val.type
                let permitedTypes = ['image/png', 'image/jpeg', 'image/svg+xml']
                if (!permitedTypes.includes(type)) {
                    return false || 'فایل انتخابی پسوند قابل قبولی ندارد'
                }
            }
            if (val.size && val.size > 2500000) {
                return false || 'حجم فایل انتخابی بیش از حد مجاز است.'
            }
        }
    },
    computed: {
    }
}
</script>

<style lang="scss">
div.cropper{
    max-width: 400px;
    margin: 0 auto;
    img{
        display: block;
        max-width: 100%;
    }
}
[dir=rtl] .cropper-container{
    direction : ltr;
    width: 100%;
}
.buttons{
    margin-top: 1rem;
    display: flex;
    justify-content: center;
    .button{
        border: 1px solid $rp-gray-2;
        padding: .125rem .75rem;
        border-radius: .25rem;
        color: $rp-gray-text-1;
        font-weight: 500;
        transition: all .2s ease-out;
        font-size: .85rem;
        &:hover{
            border-color: darken($rp-gray-2, 5);
            color: $rp-gray-text-3;
            cursor: pointer;
        }
        &.crop-img{
            &:hover{
                border-color: lighten($rp-green, 25);
                background-color: lighten($rp-green, 25);
                color: white;
            }
        }
    }
}
.preview{
    display: block;
    height: 150px;
    text-align: center;
    img{
        width: auto;
        height: 100%;
    }
}

.success-message{
    text-align: center;
    font-size: .9rem;
    color: $rp-green;
    padding: 1.5rem 0;
}

</style>
