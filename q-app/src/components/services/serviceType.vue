<template>
    <div class="panel">
        <div class="header">
            انتخاب نوع سرویس
        </div>
        <div class="body">
            <div class="service-types">
                <div class="type main"
                     @click="changeType('main')"
                     :class="{active : mainActive}" >اصلی</div>
                <div class="type category"
                     @click="changeType('category')"
                     :class="{active : categoryActive}">دسته</div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: 'serviceType',
    props: {
        value: {
            required: true
        }
    },
    data () {
        return {
            type: null
        }
    },
    mounted () {
        this.type = this.value
    },
    methods: {
        changeType (type) {
            this.type = type
            this.$emit('input', this.type)
        }
    },
    computed: {
        mainActive () {
            if (this.type === 'main') {
                return true
            }
            return false
        },
        categoryActive () {
            if (this.type === 'category') {
                return true
            }
            return false
        }
    }
}
</script>

<style lang="scss" scoped >
    .panel{
        .body{
            padding-top: .5rem;
            min-height: 4.5rem;
            .service-types{
                margin: 0 auto;
                width: 60%;
                min-width: 100px;
                padding: .25rem ;
                border: 1px solid $rp-gray-2;
                border-radius: .25rem;
                display: flex;
                justify-content: center;
                .type{
                    padding: .25rem 1rem;
                    border-radius: .2rem;
                    flex:1;
                    text-align: center;
                    transition: all .2s linear;
                    cursor: pointer;
                    color: $rp-gray-text-1;
                    &:first-child{
                        margin-left: .25rem #{"/* rtl:ignore */"};
                    }
                    &:hover{
                        color: darken($rp-gray-text-1,15);
                        background-color: $rp-gray-1;
                    }
                } // /.type
                .main{
                    &.active{
                        background-color: $secondary;
                        color:white;
                    }
                } // /.main
                .category{
                    &.active{
                        background-color: $warning;
                        color:white;
                    }

                } // /.category
            } // /.service-types
        } // /.body
    }
</style>
