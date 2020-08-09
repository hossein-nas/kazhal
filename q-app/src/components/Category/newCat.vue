<template>
    <div class="addnewcat"
         v-if="isVisible">
        <span>
            افزودن دسته بندی جدید
        </span>

        <div class="box">
            <div class="form no-pad">
                <form >
                    <div class="form-control">
                        <div class="label">
                            نام دسته‌ :
                        </div><!-- /.label -->
                        <q-input outlined
                                 dense
                                 v-model="title"
                                 :rules="[inputRule]"
                                 ref="title"/>
                    </div><!-- /.form-control -->

                    <div class="form-control">
                        <div class="label">
                            زیر شاخه‌ی دسته‌ی :
                        </div><!-- /.label -->
                        <q-select outlined
                                  dense
                                  options-dense
                                  v-model="parent"
                                  :rules="[selectRule]"
                                  ref="select"
                                  :options="this.cats"></q-select>
                    </div><!-- /.form-control -->

                    <div class="form-control flex justify-end">
                        <q-btn outline
                               size=".8rem"
                               dense
                               label="انصراف"
                               color="red-6"
                               class="q-px-md q-mr-sm"
                               @click="reset" />
                        <q-btn :disabled="!anyError"
                               outline
                               size=".8rem"
                               type="submit"
                               dense
                               label="ذخیره"
                               color="green-6"
                               class="q-px-md"
                               @click.prevent="addedCat" />
                    </div><!-- /.form-control -->
                </form>
            </div><!-- /.form -->
        </div><!-- /.box -->
    </div><!-- /.addnewcat -->
</template>

<script>
export default {
    name: 'newCat',
    props: {
        value: {
            required: true,
            type: Object,
        },
        visible: Boolean,
        cats: Array,
    },
    data () {
        return {
            isVisible: false,
            title: null,
            parent: null,
        }
    },
    mounted () {
        this.isVisible = this.visible
    },
    updated () {
        // this is for initial validating inputs
        if (this.$refs && this.isVisible) {
            let ref = this.$refs

            for (let p in ref) {
                ref[p].validate()
            }
        }
    },
    watch: {
        visible (val) {
            this.isVisible = val
        },
    },
    computed: {
        anyError () {
            if (this.title !== null) {
                return true
            }

            return false
        },

    },
    methods: {
        inputRule (val) {
            if (val === null || val === undefined) {
                return false || 'عنوانی برای دسته انتخاب نکردید'
            }

            if (val && val.length < 3) {
                return false || 'طول دسته بسیار کوتاه است.'
            }
        },
        selectRule (val) {
            return true
        },
        reset () {
            this.title = null
            this.parent = null
            this.isVisible = false
            this.$emit('canceled')
        },
        addedCat () {
            let data = {
                title: this.title,
                parent_id: this.parent ? this.parent.value : null,
            }
            this.$axios.post('/api/category/add-new', data)
                .then(res => {
                    this.reset()
                    this.$emit('input', data)
                    this.$emit('done', data)
                    this.isVisible = false
                })
        },
    },
}
</script>

<style lang="scss">

.addnewcat{
    span{
        display: block;
        text-align: center;
        padding: .5rem;
        font-size: .85rem;
        color: $rp-gray-text-2;
    }
    .box{
        background-color: #fff;
        padding: .5rem 1rem;
        border: 1px solid $rp-gray-2;
        margin-bottom: .5rem;
        min-height: 4rem;
    }
}
</style>
