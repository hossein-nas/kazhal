<template>
    <div>
        <div class="panel">
            <div class="header">
                دسته بندی پست‌‌ها
            </div><!-- /.header -->

            <div class="body">
                <div class="categories"
                     v-if="!this.addnewcat">

                    <div class="cat-groups">
                        <ul class="node-category root">
                            <template v-for="cat in this.cats" >
                                <node-cat :node="cat"
                                          :key="cat.id"
                                          :init="value.init"> </node-cat>
                            </template>
                        </ul><!-- /.node-category -->
                    </div><!-- /.cat-groups -->

                    <div class="actions flex justify-end"
                         v-if="actionsEnable">
                        <q-btn flat
                               size="sm"
                               color="blue-8"
                               v-if="this.selected.length && this.selected.length < 2">
                            ویرایش
                        </q-btn>
                        <q-btn flat
                               size="sm"
                               color="red-8"
                               v-if="this.selected.length"
                               @click="allcats()">
                            حذف
                        </q-btn>
                        <q-btn flat
                               size="sm"
                               v-if="!this.selected.length"
                               @click="addnewcat = true">
                            ایجاد دسته‌ی جدید
                        </q-btn>
                    </div><!-- /.actions -->
                </div><!-- /.categories -->
                <newCat v-model="newcat"
                        :visible="addnewcat"
                        :cats="this.allcat"
                        @canceled="addnewcat = false"
                        @done="addnewcat = false"/>

            </div><!-- /.body -->
        </div><!-- /.panel -->
    </div>
</template>

<script>
import NodeCat from '@/components/Category/NodeCat'
import newCat from '@/components/Category/newCat'
export default {
    name: 'Category',
    components: {
        NodeCat,
        newCat
    },
    props: {
        value: {
            type: Object
        }
    },
    data () {
        return {
            actionsEnable: true,
            cats: [],
            selected: [],
            addnewcat: false,
            newcat: {

            }
        }
    },
    watch: {
        newcat () {
            this.initCats()
        }
    },
    mounted () {
        this.$root.$on('category_selected', (value) => {
            this.selectCategory(value)
        })
        this.$root.$on('category_deselected', (value) => {
            this.deselectCategory(value)
        })
        if (this.value) {
            // init selected key
            this.value.selected = []
            this.$emit('input', this.value)

            // init selected items
            if (this.value && this.value.init && this.value.init.length) {

            } else {
                this.value.init = []
            }
        }
    },
    created () {
        this.initCats()
        this.$emit('category_mounted')
    },
    computed: {
        allcat () {
            let options = []
            this.allcats().forEach((val, ind) => {
                let prepend = ''
                if (val.depth > 0) {
                    prepend = ' ' + '--'.repeat(val.depth) + ' '
                }
                let title = prepend + val.title
                options.push({
                    label: title,
                    value: val.id
                })
            })
            return options
        }
    },
    methods: {
        initCats () {
            this.$axios.get('api/category/all-cats')
                .then((res) => {
                    this.cats = res.data
                })
        },
        allcats (_parent = null) {
            let cats = []
            if (_parent === null) {
                this.cats.forEach((val, ind) => {
                    cats.push(val)
                    if (val.children && val.children.length) {
                        cats = [...cats, ...this.allcats(val.children)]
                    }
                })
            } else {
                for (let i = 0; i < _parent.length; i++) {
                    cats.push(_parent[i])
                    if (_parent[i].children && _parent[i].children.length) {
                        cats.push(...this.allcats(_parent[i].children))
                    }
                }
                return cats
            }
            return cats
        },
        selectCategory (node) {
            let notSame = true
            this.selected.forEach((val, ind) => {
                if (val.id === node.id) {
                    notSame = false
                }
            })
            if (notSame) {
                this.selected.push(node)
            }
            let value = {
                selected: this.selected
            }
            this.$emit('input', value)
        },
        deselectCategory (node) {
            this.selected.forEach((val, ind) => {
                if (val.id === node.id) {
                    this.selected.splice(ind, 1)
                }
            })
        }
    }
}
</script>

<style lang="scss">
ul{
    display: block;
    padding: 0;;
    list-style: none;
    margin: 0;
    margin-bottom: .25rem;
    &.root{
        padding-right: .5rem #{"/* rtl:ignore */"};
        >div>li{
            padding-right: 0 #{"/* rtl:ignore */"};
        }
    }
    li{
            padding-right: 1.5rem #{"/* rtl:ignore */"};
            user-select: none;
        >span{
            padding: .125rem 0 #{"/* rtl:ignore */"};
            transition: all .3s ease-out;
            display: block;
            &:hover{
                cursor: pointer;
                background-color: rgba(black,.05);
            }
            .clear{
                width: 1.3rem;
                height:1.3rem;
                line-height: 1.55;
                visibility: hidden;
                color: $rp-gray-text-1;
                text-align: center;
                margin-left: .125rem #{"/* rtl:ignore */"};
                transition: all .3s ease-out;
                i{
                    font-size: .75rem;
                }
                &:hover{
                    background-color: rgba($rp-red,.1);
                    color: darken($rp-red, 20);
                    border-radius: 100%;
                }
            }
        }
         > span > .clear.active{
             visibility: visible;
        }
    } // li
}

.cat-groups{
    background-color: #fff;
    padding: .5rem;
    border: 1px solid $rp-gray-2;
    margin-bottom: .5rem;
    max-height: 10rem;
    overflow-y: scroll;
}

</style>
