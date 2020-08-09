<template>
    <div class="panel">
        <div class="header">
            {{ title }}
        </div><!--  /.header -->
        <div class="body"
             v-if="isLoading"
        >
            <template v-if="hasContent">
                <q-list>
                    <div  v-for="(item, index) in data"
                          :key="item.id">
                        <q-item
                            clickable
                            :to="'detail/comment/' + item.id + '/'"
                        >
                            <q-item-section>
                                <q-item-label >
                                    <span>تأیید دیدگاه </span>
                                    {{ item.name }}
                                </q-item-label>
                                <q-item-label caption
                                              lines="2"
                                              v-text="item.body"> </q-item-label>
                            </q-item-section>

                            <q-item-section side
                                            top
                            >
                                <q-item-label v-text="item.local_time"
                                              style="font-size:10px"></q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-separator spaced
                                     inset
                                     v-if="index != Object.keys(data).length - 1"
                        ></q-separator>
                    </div>
                </q-list>

                <div class="flex flex-center"
                     v-if="maxPages > 1">

                    <q-pagination
                        size="sm"
                        flat
                        color="grey-7"
                        text-color="white"
                        v-model="currentPage"
                        :max="maxPages"
                    ></q-pagination>
                </div>
            </template>

            <p v-else
               class="no-data">
                هنوز داده‌ای ثبت نشده !
            </p>
        </div>

        <q-inner-loading :showing="!isLoading">
            <q-spinner size="2rem"
                       color="blue"
                       :thickness="3"/>
        </q-inner-loading>
    </div><!--  /.panel -->
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'LatestApproved',

    props: ['value', 'title', 'owns'],

    data () {
        return {
            defaultReplier: 'شما',
            currentPage: 1,
            totalPages: 4,
        }
    },

    computed: {
        ...mapGetters('comment', ['isLoading']),

        hasContent () {
            return !!this.value.length
        },

        data () {
            let startingPoint = (this.currentPage - 1) * (this.totalPages)
            let endingPoint = startingPoint + this.totalPages

            return this.value.slice(startingPoint, endingPoint)
        },

        maxPages () {
            let allCount = this.value.length
            let allPages = parseInt((allCount / this.totalPages), 10) + (allCount % this.totalPages ? 1 : 0)

            return allPages
        },
    },

    methods: {

        replier (item) {
            if (this.owns === false && item.verified) {
                return [item.verifier.firstname, item.verifier.lastname].join(' ')
            }

            return this.defaultReplier
        },
    },
}
</script>

<style lang="scss">
.q-list{
    .q-item__label{
        >span{
            color: $grey-7;
            font-weight: normal;
        }
    }
}
.no-data{
    margin: 0;
    text-align: center;
    padding:1.5rem;
    color: $rp-error;
    font-size: .875rem;
    line-height: 1.5;
}
</style>
