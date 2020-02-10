<template>
    <div>
        <li>
            <span @click.prevent="itemclicked">
                <q-radio v-model="selectedCategory" size="1.4rem" :val="this.node.id" ref='radio' @input="checked"/>
                <span > {{ this.node.title }}</span>
                <span class="clear float-right" @click.stop="clearselected" :class="{ active : this.selectedCategory }">
                    <q-icon name="clear"></q-icon>
                </span><!-- /.clear -->
            </span>
            <template v-if="nodes">
                <ul class="node-category">
                    <template v-for="cat in nodes" >
                        <node-cat  :node="cat" :key="cat.id"> </node-cat>
                    </template>
                </ul><!-- /.node-category -->
            </template>
        </li>
    </div>
</template>

<script>
export default {
    name: 'NodeCat',
    props: [
        'node'
    ],
    data () {
        return {
            selectedCategory: null
        }
    },
    computed: {
        nodes () {
            if (this.node.children && this.node.children.length) {
                return this.node.children
            }
            return null
        }
    },
    mounted () {
    },
    methods: {
        checked (value) {
            this.$root.$emit('category_selected', this.node)
        },
        itemclicked () {
            this.selectedCategory = this.node.id
            this.$root.$emit('category_selected', this.node)
        },
        clearselected () {
            if (this.selectedCategory !== 0) {
                this.selectedCategory = 0
                this.$root.$emit('category_deselected', this.node)
            }
        }
    }
}
</script>

<style lang="scss"></style>
