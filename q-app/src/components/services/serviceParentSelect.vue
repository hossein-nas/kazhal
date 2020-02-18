<template>
    <div class="panel">
        <div class="header">
            انتخاب سرویس والد
        </div>
        <div class="body">
            <div class="parent-services-list"
                 v-if="loadingDone">
                <ul>
                    <template v-for="(item, index) in categoryServicesList" >
                        <li :key="index"
                            :class="{ default : item.default, active : index === selectedItem }"
                            @click="checkItem(index)">
                            <q-radio v-model="selectedItem"
                                     size="1.8rem"
                                     :color="item.default?'green-4': '' "
                                     :val="index" />
                            {{ item.title}}
                        </li>
                    </template>
                </ul>
            </div>

            <q-inner-loading :showing="!loadingDone">
                <q-spinner size="2rem"
                           color="blue"
                           :thickness="3"/>
            </q-inner-loading>
        </div> <!-- /.body -->
    </div>

</template>

<script>
export default {
    name: 'serviceParentSelect',
    props: {
        value: {
            required: true
        }
    },
    data () {
        return {
            init: false,
            selectedItem: null,
            loadingDone: false,
            categoryServicesList: []
        }
    },
    mounted () {
        this.selectDefault()
        this.initServices()
    },
    watch: {
        selectedItem (val) {
            if (val !== undefined) {
                this.$emit('input', this.categoryServicesList[val].id)
            }
        }
    },
    methods: {
        initServices () {
            this.$axios.post('/api/services/get-all/category/services')
                .then(res => {
                    for (let ind in res.data) {
                        let service = res.data[ind]
                        this.categoryServicesList.push(service)
                    }
                    this.loadingDone = true
                })
        },
        selectDefault () {
            this.categoryServicesList.push({
                id: null,
                title: 'بدون سرویس والد',
                parent_id: null,
                default: true
            })
            this.selectedItem = 0
        },
        checkItem (id) {
            this.selectedItem = id
        }
    }
}
</script>

<style lang="scss" scoped>
    .panel{
        .header{

        } // /.header

        .body{
            position: relative;
            div.parent-services-list{
                margin: .5rem 1rem;
                border: 1px solid $rp-gray-2;
                max-height:8rem;
                min-height:5rem;
                overflow-y: scroll;
                ul{
                    list-style-type:none;
                    padding: 0 .2rem;
                    margin: 0;
                    li{
                        padding: .25rem 1.25rem .25rem .25rem #{"/* rtl:ignore */"} ;
                        transition: all .2s;
                        cursor: pointer;
                        color: $rp-gray-text-2;
                        font-size: .8rem;
                        font-weight: 600;
                        display: flex;
                        align-items: center;
                        &:not(:last-child){
                            border-bottom: 1px solid $rp-gray-2;
                        }
                        &:hover{
                            background-color: $rp-gray-1;
                        }
                        &.active{
                            color: $blue-8;
                        }
                        &.default{
                            padding: .25rem;
                            background-color: $rp-gray-1;
                            position: relative;
                            &::before{
                                content:'';
                                position: absolute;
                                left: 100% #{"/* rtl:ignore */"};
                                width: .2rem;
                                top: 0;
                                background-color: $green-4;
                                height: 100%;
                            }
                        }
                    }
                }
            } // /.parent-services-list

        } // /.body
    }
</style>
