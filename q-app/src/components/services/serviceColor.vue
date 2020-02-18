<template>
    <div class="panel">
        <div class="header">
            انتخاب رنگ سرویس
        </div>
        <div class="body">
            <div class="colors-list-area">
                <template v-for="color in allColors" >
                    <div class="item"
                         :class="{active : color.id === activeColor}"
                         :key="color.id"
                         @click="check(color.id)">
                        <div class="color-gradient"
                             :style="{ background : color.gradient}">
                        </div>
                        <div class="info">
                            رنگ شماره‌ی <span> {{ color.id }}#</span>
                            <div class="action">
                                انتخاب
                            </div>
                        </div>
                        <q-icon name="check_circle"
                                size="1.1rem"/>
                    </div> <!-- /.item -->
                </template>
            </div>
            <div class="actions">

            </div>
            <q-inner-loading :showing="!colorsLoaded">
                <q-spinner size="2rem"
                           color="blue"
                           :thickness="3"/>
            </q-inner-loading>
        </div>
    </div>
</template>

<script>
export default {
    name: 'serviceColor',
    props: {
        value: {
            required: true
        }
    },
    data () {
        return {
            activeColor: 1,
            colorsLoaded: false,
            allColors: []
        }
    },
    async mounted () {
        let response = await this.$axios.get('api/colors/all')
        this.allColors = response.data
        this.colorsLoaded = true
        this.$emit('input', this.activeColor)

        // this is for updating functionality when default value set
        if (this.value !== null) {
            this.activeColor = this.value
        }
    },
    methods: {
        check (el) {
            this.activeColor = el
            this.$emit('input', this.activeColor)
        }
    }
}
</script>

<style lang="scss" scoped>
.panel{
    .header{

    }
    .body{
        position: relative;
        .colors-list-area{
            padding: .25rem;
            border: 1px solid $rp-gray-2;
            max-height: 10rem;
            overflow-y: scroll;
            .item{
                display:flex;
                padding: .5rem .5rem;
                align-items: stretch;
                height: 48px;
                position: relative;
                &:not(:last-child){
                    border-bottom: 1px solid $rp-gray-2;
                }
                &::after{
                    content: '';
                    display: block;
                    clear:both;
                }
                .color-gradient{
                    // float: right #{"/* rtl:ignore */"};
                    width: 50px;
                    border-radius: .25rem;
                }
                .info{
                    flex: 1;
                    height: 100%;
                    padding: .25rem .75rem;
                    line-height:1.7;
                    color: $rp-gray-text-1;
                    span{
                        color: $rp-gray-text-2;
                        font-size: 1rem;
                        margin-right: .5rem #{"/* rtl:ignore */"};
                    }
                    .action{
                        visibility: hidden;
                        float: left #{"/* rtl:ignore */"};
                        font-size: .7rem;
                        color: $rp-gray-text-3;
                        padding: .125rem .75rem;
                        line-height: 1.5;
                        margin-top: .15rem;
                        border-radius: .25rem;
                        &:hover{
                            cursor:pointer;
                            background-color: $rp-gray-2;
                        }
                    }
                }
                >i {
                    visibility: hidden;
                    color: $blue;
                    position: absolute;
                    left: 1.8rem #{"/* rtl:ignore */"};
                    top: 50%;
                    transform: translateY(-50%);
                }
                &:hover{
                    .action{
                        transition: none;
                        visibility: visible;
                    }
                }
                &.active{
                    transition: none;
                    .info{
                        color: $blue;
                        span{
                            color:inherit;
                        }
                    }
                    .action{
                        transition: none;
                        visibility: hidden;
                    }
                    i{
                        visibility: visible;
                    }
                }
            } // /.item
        } // /.colors-list-area
        .actions{
            min-height: 2rem;
        }
    }
}
</style>
