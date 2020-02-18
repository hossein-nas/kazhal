<template>
    <div class="panel">
        <div class="header">
            انتخاب تصویر شاخص
        </div>
        <div class="body">
            <div id="file">
                <q-file outlined
                        ref="file"
                        @input="pickFile"
                        v-model="file" />
            </div>
            <div class="select-file-area"
                 v-if="!fileSelected">
                <span class="label">
                    فایلی انتخاب نشده است.
                </span>
                <span class="select-file"
                      @click="selectFile">
                    انتخاب فایل
                </span>

            </div>
            <div class="file-preview-area"
                 v-if="fileSelected">
                <q-img :src="filePreview" />
                <div class="info">

                </div>
                <div class="actions">
                    <div class="upload-done"
                         v-if="uploadDone">
                        فایل با موفقیت افزوده شد.
                    </div>
                    <div class="button upload-button"
                         v-if="!uploadDone"
                         @click="uploadThumb">
                        آپلود به سرور
                    </div>
                    <div class="button change-thumbnail"
                         v-if="uploadDone"
                         @click="changeThumb">
                        تغییر تصویر
                    </div>
                    <q-linear-progress :value="uploadProgress"
                                       v-if="uploading"
                                       reversed
                                       size="sm" />
                </div>

            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'serviceSvgThumb',
    data () {
        return {
            fileSelected: false,
            file: null,
            fileInfo: {},
            uploading: false,
            uploadDone: false,
            uploadProgress: 0,
            uploadedFile: null,
            filePreview: null
        }
    },
    computed: {
        fileIsValid () {
            return true
        }
    },
    methods: {
        selectFile () {
            this.$refs.file.pickFiles()
        },
        pickFile (file) {
            if (file && file.type !== 'image/svg+xml') {
                alert('فایل انتخابی مورد قبول نیست')
                this.file = null
                return
            }
            this.fileSelected = true
            this.loadPreviewImage()
        },
        loadPreviewImage () {
            let fileReader = new FileReader()
            fileReader.onload = (theFile) => {
                this.filePreview = theFile.target.result
            }
            fileReader.readAsDataURL(this.file)
        },
        uploadThumb () {
            let $data = new FormData()
            $data.append('file', this.file)
            $data.append('title', 'Services Thumbnail.')
            $data.append('desc', 'No description set.')
            $data.append('name', this.file.name)

            // this is for loading progress bar
            this.uploading = true

            this.$axios.post('/api/files/upload', $data, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress (progressEvent) {
                    console.log(progressEvent)
                }
            })
                .then((res) => {
                    this.uploadFinished(res.data)
                })
        },
        uploadFinished (data) {
            this.uploading = false
            this.uploadDone = true
            this.uploadedFile = data
            this.$emit('input', this.uploadedFile.data.id)
        },
        changeThumb () {

        }
    }
}
</script>

<style lang="scss" scoped>
.panel{
    .body{
        position: relative;
        #file{
            display: none;
        }
        .select-file-area{
            min-height: 6rem;
            span{
                display: block;
                text-align: center;
                width:100%;
                &.label{
                    min-height: 3.5rem;
                    line-height: 3.5rem;
                    color: $red-4;
                }
                &.select-file{
                    font-size: .8rem;
                    color: $blue-8;
                    &:hover{
                        color: $blue-10;
                        cursor: pointer;
                        text-decoration: underline;
                    }
                }
            }

        } // /.select-file-area
        .file-preview-area{
            display: block;
            text-align: center;
            padding: .5rem 0;
            .q-img{
                max-width: 120px;
                margin: 0 auto;
                margin-bottom: .5rem;
            }
            .info{

            }
            .actions{
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                .button{
                    padding: .3rem 1.125rem;
                    font-size: .7rem;
                    color: $blue-6;
                    font-weight: 600;
                    border-radius: .15rem;
                    border: 1px solid $blue-4;
                    &:hover{
                        cursor: pointer;
                        color: darken($blue-6, 10);
                        border-color: darken($blue-4, 10);
                    }
                    &.change-thumbnail{
                        border-color: $red-4;
                        color: $red-6;
                        padding: .2rem .75rem;
                        &:hover{
                            cursor: pointer;
                            color: darken($red-6, 10);
                            border-color: darken($red-4, 10);
                        }
                    } // /.button.change-thumbnail
                }
                .upload-done{
                    display: inline-block;
                    font-size: .75rem;
                    font-weight: 600;
                    color: $green-6;
                    width:100%;
                    margin-bottom: .5rem;
                }

                .q-linear-progress{
                    position: absolute;
                    bottom: 0;
                }
            } // /.actions
        } // /.file-preview-area
    }
}
</style>
