<template>
    <div class="add-new-feature"
         v-if="visible">
        <div class="input-wrapper">
            <div class="number"> {{ Index }} </div>
            <div class="inputbox">
                <q-input v-model="newFeature"
                         size="sm"
                         ref="newFeatureInput"
                         :rules="[newFeatureRule]"
                         dense
                         outlined />
            </div>
        </div>
        <div class="submit">
            <q-btn unelevated
                   size="sm"
                   dense
                   class="q-px-xs q-mr-sm"
                   color="red-5"
                   @click="cancelAddNewFeatureProc"
                   label="انصراف" />
            <q-btn unelevated
                   size="sm"
                   dense
                   :disable="!enableSumbit"
                   class="q-px-xs"
                   color="green-5"
                   @click="addNewFeatureItem"
                   label="ثبت" />
        </div>
    </div></template>

<script>
export default {
    name: 'addFeatureInput',
    props: {
        showing: {
            type: Boolean,
        },
        value: {
            required: true,
        },
        editing: {
            type: Boolean,
        },
        index: {
            required: true,
        },
    },
    mounted () {
    },
    data () {
        return {
            newFeature: '',
            visiblity: false,
        }
    },
    updated () {
    },
    watch: {
        showing (val) {
            this.visiblity = val

            if (this.editing == true) {
                this.newFeature = this.value
            }
        },
        editing (val) {
        },
        newFeature () {
        },
    },
    methods: {
        newFeatureRule (val) {
            if (!val && val.length === 0) {
                return false || 'فیلد نباید خالی باشد.'
            }

            if (val && val.length < 5) {
                return false || 'حداثل ۵ کاراکتر وارد کنید.'
            }
        },
        cancelAddNewFeatureProc () {
            this.visiblity = false
            this.newFeature = ''
            this.$emit('cancel')
        },
        addNewFeatureItem () {
            if (this.editing) {
                let data = {
                    index: this.index,
                    data: this.newFeature,
                }
                this.$emit('update', data)
            } else {
                this.$emit('add', this.newFeature)
            }

            this.cancelAddNewFeatureProc()
        },

    },
    computed: {
        visible () {
            return this.visiblity
        },
        enableSumbit () {
            let f = this.newFeature

            if (!this.$refs.newFeatureInput) {
                return false
            }

            if ((this.$refs && this.$refs.newFeatureInput) || this.newFeature) {
                return !this.$refs.newFeatureInput.hasError
            }

            return false
        },
        Index () {
            return '#' + (this.index + 1)
        },
    },
}
</script>

<style lang="scss" scoped>

.add-new-feature{
    margin-bottom: .5rem;
    min-height: 2.5rem;
    padding: 0 1rem;
    >div.input-wrapper{
        display: flex;
        align-items: flex-start;
        margin-bottom: .5rem;
        .number{
            padding: .25rem .25rem .1rem;
            background-color: $rp-gray-2;
            color: $rp-gray-text-1;
            border-radius: .25rem ;
            margin-left: .5rem #{"/* rtl:ignore */"};
            line-height: 2.5;
        }
        .inputbox{
            flex:1;
            .q-field__control{
                height:27px;
                border-radius: 0;
            }
        }
    }
    .submit{
        display: flex;
        justify-content: flex-end;
    }
} // /.add-new-feature
</style>
