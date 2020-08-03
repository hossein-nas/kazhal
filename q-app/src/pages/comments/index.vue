<template>
    <q-page padding>
        <div id="comments">
            <div class="row">
                <div class="col-md-9 col-12">
                    <div id="main-area">
                        <div class="head-section user-select">
                            <span class="label">
                                بخش مدیریت نظرات
                            </span>
                            <router-link to=""
                                         class="action success">
                                ارسال نظر جدید
                                <q-icon name="add_box"
                                        size="sm">
                                </q-icon>
                            </router-link>
                        </div><!-- /.head-section -->

                        <div>
                            <q-table
                                :flat="true"
                                :data="unapprovedComments"
                                :columns="columns"
                                :pagination.sync="pagination"
                                row-key="id"
                            >
                                <template v-slot:body-cell-content="props">
                                    <q-td :props="props"
                                    >
                                        <div  style="white-space: normal; text-align: right;">
                                            {{ props.row.body }}
                                        </div>
                                    </q-td>
                                </template>
<!--                                 <template v-slot:body-cell-username="props">
                                    <q-td :props="props"
                                    >
                                    </q-td>
                                </template>
 -->                            </q-table>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <section class="side-widgets">
                        <user-stats v-model="userStats"></user-stats>

                    </section>
                </div>
            </div>
        </div>
    </q-page>
</template>

<script>
import UserStats from '@/components/UserStats'
import { mapActions, mapGetters } from 'vuex'

export default {
    name: 'index',

    components: {
        UserStats
    },

    data () {
        return {
            comments: [],
            userStats: {},
            pagination: {
                rowsPerPage: 10,
                page: 1,
                sortBy: 'date',
                descending: false
                // rowsNumber: xx if getting data from a server
            }
        }
    },

    created () {
        this.fetchAllComments()
    },

    methods: {
        ...mapActions('comment', [
            'fetchAllComments'
        ])
    },

    computed: {
        ...mapGetters('comment', [
            'allComments',
            'unapprovedComments'
        ]),
        columns () {
            return [
                { name: 'id', required: true, label: '', align: 'right', sortable: true, field: 'id' },
                { name: 'username', required: true, label: 'نام ارسال کننده', align: 'center', sortable: false, field: 'name' },
                { name: 'content', required: true, label: 'متن دیدگاه', align: 'center', sortable: false, field: 'body', style: 'width: 50%' },
                { name: 'date', required: true, label: 'تاریخ ارسال', align: 'center', sortable: true, field: 'local_time' }
            ]
        }
    }
}
</script>

<style>
</style>
