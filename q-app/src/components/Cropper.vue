<template>
    <div id="cropper" dir="ltr">
        <img   ref="cr_img" :src="imgSrc"  alt="" crossorigin>
        <button @click="clk">clicke me</button>
    </div>
</template>

<script>
import Cropper from 'cropperjs'
export default {
    name: 'croppervue',
    props: {
        value: {
            required: true
        }
    },
    data () {
        return {
            cp: {},
            cropper: {},
            previewImg: null,
            imgSrc: ''
        }
    },
    mounted () {
        this.initImg()
        this.$nextTick(() => {
            let img = this.$refs.cr_img
            this.cropper = new Cropper(img, {
                aspectRatio: 1,
                dragMode: 'move',
                autoCropArea: 0.9,
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
        })
    },
    methods: {
        initImg () {
            this.imgSrc = this.value.src
        },
        async clk () {
            let data = this.cropper.getImageData()
            let canvas = this.cropper.getCroppedCanvas()
            this.previewImg = canvas.toDataURL()
            canvas.toBlob((blob) => {
                // working  with blob
            })
        }
    }
}
</script>

<style lang="scss">
div#cropper{
    max-width: 400px;
    img{
        display: block;
        max-width: 100%;
    }
}
[dir=rtl] .cropper-container{
    direction : ltr;
}

</style>
