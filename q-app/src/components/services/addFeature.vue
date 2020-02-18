<template>
    <div class="panel">
        <div class="header">
            ویژگی های منتخب
        </div>
        <div class="body">

            <div class="feature-list">
                <template v-for="(f, index) in features" >
                    <div class="item"
                         :class="{active : selectedItem === index}"
                         @click="checkItem(index)"
                         :key="index">
                        <q-icon name="check_circle"
                                color="green-3"
                                class="q-mr-sm"
                                size="1.2rem" />
                        <div class="text">{{ f }}</div>
                    </div>
                </template>
            </div>

            <div class="no-feature-yet"
                 v-if="isEmpty">
                موردی وارد نشده
            </div>

            <addFeatureInput v-model="newFeature"
                             :showing="addNewFeature"
                             :editing="false"
                             :index="newItemNumber"
                             @add="addNewItem"
                             @cancel="closeAddNewItem"
            />

            <addFeatureInput v-model="newFeature"
                             :showing="editFeature"
                             :editing="true"
                             :index="editFeatureItem"
                             @update="updateFeature"
                             @cancel="closeAddNewItem"
            />

            <div class="actions"
                 v-if="!addNewFeature">
                <q-btn outline
                       v-if="!itemSelected && !editFeature"
                       @click="triggleAddNewItem"
                       size="sm"
                       color="blue-grey-5"
                       label="افزودن مورد جدید" />

                <template v-if="!editFeature">
                    <q-btn unelevated
                           v-if="itemSelected"
                           @click="triggleEditingItem"
                           size=".5rem"
                           color="blue-5"
                           label="ویرایش" />

                    <q-btn unelevated
                           v-if="itemSelected"
                           @click="triggleDeletingItem"
                           class="q-ml-xs"
                           size=".5rem"
                           color="red-4"
                           label="حذف" />
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import addFeatureInput from '@/components/services/addFeatureInput'

export default {
    name: 'addFeature',
    components: {
        addFeatureInput
    },
    props: {
        value: {
            required: true
        }
    },
    watch: {
        features () {
            this.$emit('input', this.features)
        }
    },
    data () {
        return {
            features: [
            ],
            addNewFeature: false,
            newFeature: '',
            editFeature: false,
            editFeatureItem: null,
            selectedItem: null
        }
    },
    computed: {
        isEmpty () {
            if (this.features && this.features.length === 0) {
                return true
            }
            return false
        },
        newItemNumber () {
            return this.features.length
        },
        itemSelected () {
            if (this.selectedItem === null) {
                return false
            }
            return true
        }
    },
    methods: {
        checkItem (item) {
            if (this.selectedItem === item) {
                this.selectedItem = null
            } else {
                this.selectedItem = item
            }
        },
        triggleAddNewItem () {
            this.addNewFeature = true
        },
        closeAddNewItem () {
            this.addNewFeature = false
            this.editFeature = false
        },
        addNewItem (val) {
            this.addNewFeature = false
            this.features.push(val)
        },
        updateFeature (val) {
            this.features.splice(val.index, 1, val.data)
        },
        triggleDeletingItem () {
            this.features.splice(this.selectedItem, 1)
            this.selectedItem = null
        },
        triggleEditingItem () {
            this.editFeatureItem = this.selectedItem
            this.newFeature = this.features[this.selectedItem]
            this.selectedItem = null
            this.editFeature = true
        }
    }
}
</script>

<style lang="scss" scoped>
    .panel{
        .header{

        } // /. header
        .body{
            .feature-list{
                .item{
                    display: flex;
                    align-items: center;
                    padding: .5rem 0;
                    margin: 0 1rem;
                    &:hover{
                        cursor: pointer;
                        background-color: $rp-gray-1;
                    }
                    &:not(:last-child){
                        border-bottom: 1px dashed $rp-gray-2;
                    }
                    .text{
                        color: $rp-gray-text-3;
                        font-size: .9rem;
                        flex: 1;
                    }
                    .q-icon{
                    }
                    &.active{
                        .q-icon{
                            color: $blue-6 !important;
                        }
                        .text{
                            color : $blue-6;
                        }
                    }
                } // /.item

            } // /.feature-list

            .no-feature-yet{
                min-height: 4rem;
                line-height: 4rem;
                text-align: center;
                color: $brown-4;
            }

            .actions{
                padding-left: .5rem #{"/* rtl:ignore */"};
                margin-bottom: .25rem;
                display: flex;
                justify-content: flex-end;
            }// /.actions

        } // /.body
    } // /.panel
</style>
