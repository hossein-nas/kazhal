<template>
    <div class="ImageUploader">
        <div class="ImageUploader__cropper-area">

        </div>

        <div class="ImageUploader__progressbar">
            <progress-bar v-model="progress"
                          :visibility="progressShowing"></progress-bar>
        </div>

        <div class="ImageUploader__filestat">

        </div>

    </div>
</template>

<script>
import ProgressBar from './ProgressBar'

export default {
    name: 'ImageUploader',

    props: {
        value: {
            type: Object,
        },

        show: {
            required: true,
            type: Boolean,
        },
    },

    components: {
        ProgressBar,
    },

    data () {
        return {
            thumbnail: {},
            visibility: false,
            uploadDone: false,
            progress: 0,
            progressShowing: false,
        }
    },
}
</script>

<style>
</style>
