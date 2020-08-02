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
                                :grid="false"
                                :flat="true"
                                :data="comments"
                                :columns="columns"
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
                            </q-table>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <section class="side-widgets">

                    </section>
                </div>
            </div>
        </div>
    </q-page>
</template>

<script>

export default {
    name: 'index',

    data () {
        return {
            comments: []
        }
    },

    created () {
        this.fetchComments()
    },

    methods: {
        fetchComments () {
            this.$axios.get('/comments?all=1')
                .then((res) => {
                    this.comments = res.data
                })
        }
    },

    computed: {
        columns () {
            return [
                { name: 'id', required: true, label: '', align: 'right', sortable: false, field: 'id' },
                { name: 'username', required: true, label: 'نام ارسال کننده', align: 'center', sortable: false, field: 'name' },
                { name: 'content', required: true, label: 'متن دیدگاه', align: 'center', sortable: false, field: 'body', style: 'max-width: 50%' },
                { name: 'date', required: true, label: 'تاریخ ارسال', align: 'center', sortable: false, field: 'local_time' }
            ]
        }
    }
}
</script>

<style>
</style>
