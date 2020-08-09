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
                            <router-link to="answer/to/"
                                         class="action success">
                                ارسال نظر جدید
                                <q-icon name="add_box"
                                        size="sm">
                                </q-icon>
                            </router-link>
                        </div><!-- /.head-section -->

                        <div>
                            <h2 class="table-header">
                                دیدگاه‌های در انتظار تأیید
                                <span class="count"
                                      v-text="unapprovedCount">

                                </span>
                            </h2><!--  /.table-header -->
                            <q-table
                                :flat="true"
                                :data="unapprovedComments"
                                :columns="columns"
                                :pagination.sync="pagination"
                                selection="multiple"
                                :selected.sync="selectedComments"
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
                            <div class="single-actions"
                                 v-if="isItemSelected && ! isMultipleItemSelected">
                                <q-btn outline
                                       class="cm-detail"
                                       color="teal-7"
                                       padding="4px 8px"
                                       size="sm"
                                       @click="approve"
                                       label="تأییـــد دیــــدگاه" />
                                <q-btn outline
                                       class="cm-detail"
                                       color="blue-grey-5"
                                       padding="4px 8px"
                                       :to="detailPageLink"
                                       size="sm"
                                       label="مشاهده‌ی جزئیات" />
                                <q-btn outline
                                       class="cm-answer"
                                       color="lime-7"
                                       padding="4px 8px"
                                       :to="answerToLink"
                                       size="sm"
                                       label="ارسال پاسخ" />
                                <q-btn outline
                                       class="cm-edit"
                                       color="green-5"
                                       padding="4px 8px"
                                       :to="editPageLink"
                                       size="sm"
                                       label="ویـرایش" />
                                <q-btn outline
                                       color="red-4"
                                       padding="4px 8px"
                                       size="sm"
                                       @click="trash"
                                       label="جذف دیدگاه" />

                            </div>
                            <div class="bulk-actions"
                                 v-if="isMultipleItemSelected">
                                <q-btn outline
                                       class="cm-detail"
                                       color="teal-7"
                                       padding="4px 8px"
                                       size="sm"
                                       @click.prevent="bulkApprove"
                                       label="تأییـــد دیــــدگاهها" />
                                <q-btn outline
                                       color="red-4"
                                       padding="4px 8px"
                                       size="sm"
                                       label="جذف دیدگاهها" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <section class="side-widgets">
                        <user-stats v-model="userStats"></user-stats>
                        <latest-approved :value="approvedCommentsByUser"
                                         title="آخرین تأیید کرده‌های شما"></latest-approved>

                        <latest-approved :value="approvedNotByMe"
                                         title="آخرین تأیید شده‌ها توسط ادمین‌های دیگر"
                                         :owns="false"></latest-approved>

                        <latest-approved :value="allTrashed"
                                         title="دیدگاه‌های موجود در زباله‌دان"
                                         :owns="false"></latest-approved>
                    </section>
                </div>
            </div>
        </div>
    </q-page>
</template>

<script>
import UserStats from '@/components/UserStats'
import LatestApproved from '@/components/LatestApproved'
import { mapActions, mapGetters } from 'vuex'

export default {
    name: 'index',

    components: {
        UserStats,
        LatestApproved,
    },

    data () {
        return {
            selectedComments: [],
            comments: [],
            userStats: {},
            pagination: {
                rowsPerPage: 10,
                page: 1,
                sortBy: 'date',
                descending: false,
                // rowsNumber: xx if getting data from a server
            },
        }
    },

    created () {
        this.fetchAllComments()
    },

    methods: {
        ...mapActions('comment', [
            'fetchAllComments',
            'approveComment',
            'approveMultipleComments',
            'trashComment'
        ]),

        async approve () {
            let comment_id = this.selectedComments[0].id
            let uri = '/api/comments/approve/' + comment_id
            let data = {
                uri,
            }

            await this.approveComment(data)

            this.selectedComments = []
            this.approvedNotify()
        },

        bulkApprove () {
            let comments = this.selectedComments.map(comment => comment.id)

            this.approveMultipleComments(comments)
                .then(() => {
                    this.selectedComments = []

                    this.approvedNotify()
                })
        },

        trash () {
            let comment_id = this.selectedComments[0].id
            let uri = '/api/comments/trash/' + comment_id
            let data = {
                comment_id, uri,
            }
            this.trashComment(data)
                .then(() => {
                    this.selectedComments = []

                    this.trashedNotify()
                })
        },

        approvedNotify () {
            this.$q.notify({
                message: 'دیدگاه مورد نظر تأیید گردید.',
                progress: true,
                timeout: 2500,
                type: 'positive',
            })
        },

        trashedNotify () {
            this.$q.notify({
                message: 'دیدگاه مورد نظر با موفقیت حذف گردید.',
                progress: true,
                timeout: 2500,
                type: 'danger',
            })
        },
    },

    computed: {
        ...mapGetters('comment', [
            'allComments',
            'allTrashed',
            'unapprovedComments',
            'approvedComments',
            'unapprovedCount',
            'approvedCommentsByUser'
        ]),

        ...mapGetters('auth', ['getUserInfo']),

        columns () {
            return [
                // { name: 'id', required: true, label: '', align: 'right', sortable: true, field: 'id' },
                { name: 'username', required: true, label: 'نام ارسال کننده', align: 'center', sortable: false, field: 'name', },
                { name: 'content', required: true, label: 'متن دیدگاه', align: 'center', sortable: false, field: 'body', style: 'width: 50%', },
                { name: 'date', required: true, label: 'تاریخ ارسال', align: 'center', sortable: true, field: 'local_time', }
            ]
        },

        isItemSelected () {
            return !!this.selectedComments.length
        },

        isMultipleItemSelected () {
            return this.selectedComments.length >= 2
        },

        approvedNotByMe () {
            return this.approvedComments.filter(comment => comment.verified_by !== this.getUserInfo.id)
        },

        selectedId () {
            return this.selectedComments[0].id
        },

        answerToLink () {
            return { name: 'comment.answer', params: { commentId: this.selectedId, }, }
        },

        detailPageLink () {
            return { name: 'comment.detail', params: { commentId: this.selectedId, }, }
        },

        editPageLink () {
            return { name: 'comment.edit', params: { commentId: this.selectedId, }, }
        },
    },
}
</script>

<style lang="scss">
.table-header{
    font-size: 1.125rem;
    color: $rp-table-header-color;
    padding-right: .75rem  #{"/* rtl:ignore */"};
    margin: 0;
    line-height: 1;
    font-weight: 800;
    margin-bottom: 1.5rem;

    span{
        margin-right: 1rem  #{"/* rtl:ignore */"};
        font-size: 1rem;
        font-weight: normal;
        color: $rp-gray-text-1;

        &::before{
            content: '( ';
        }
        &::after{
            content: ' مورد )';
        }
    }
}

#main-area{
    .cm-delete{
        color: $red-4;
        border-color: $red-8;
    }

    .single-actions, .bulk-actions{
        display: flex;
        justify-content: flex-end  #{"/* rtl:ignore */"};
        > * {
            margin-right: .25rem  #{"/* rtl:ignore */"};
        }
    }

}
</style>
