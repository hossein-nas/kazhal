<template>
    <q-page padding>
        <div class="row"
             v-if="loaded">
            <div class="col-8 offset-2"
                 id="main-area">
                <div class="head-section user-select">
                    <span class="label ">مشاهده‌ی جزئیات دیدگاه</span>

                    <router-link :to="'/comments/answer/to/' + comment.id + '/' "
                                 class="action primary">
                        پاسخ به این دیدگاه
                        <q-icon size="sm"
                                name="reply"></q-icon>
                    </router-link>
                </div>

                <div class="row detail-section q-mb-lg">
                    <div class="col-12 col-md-3 text-right text-grey-6">
                        نام ارسال کننده :
                    </div>
                    <div class="col-12 col-md-9 q-px-lg">
                        {{ comment.name }}
                    </div>
                </div><!--  /.row detail-section -->

                <div class="row detail-section q-mb-lg"
                     v-if="comment.email">
                    <div class="col-12 col-md-3 text-right text-grey-6">
                        آدرس ایمیل :
                    </div>
                    <div class="col-12 col-md-9 q-px-lg">
                        {{ comment.email}}
                    </div>
                </div><!--  /.row detail-section -->

                <div class="row detail-body q-mb-lg">
                    <div class="col-12 col-md-3 text-right text-grey-6">
                        متن دیدگاه :
                    </div>
                    <div class="col-12 col-md-9 q-px-lg">
                        <q-field outlined
                                 class="user-select"
                                 disabled
                                 readonly

                        >
                            <template v-slot:control >
                                <div v-text="comment.body"
                                     style="min-height: 6rem"></div>
                            </template>
                        </q-field>
                    </div>
                </div><!--  /.row detail-body -->

                <div class="row post-url q-mb-lg">
                    <div class="col-12 col-md-3 text-right text-grey-6">
                        ارسال شده زیر پست :
                    </div>
                    <div class="col-12 col-md-9 q-px-lg">
                        <a :href="comment.post.path"
                           target="_blank"
                           v-text="comment.post.title"></a>
                    </div>
                </div><!--  /.row post-url-->

                <div class="row details q-mb-lg">
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-4 text-right text-grey-6">
                                آی پی آدرس :
                            </div>
                            <div class="col-8 q-pl-lg">
                                {{  comment.ip }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row">
                            <div class="col-4 text-right text-grey-6">
                                تاریخ ارسال :
                            </div>
                            <div class="col-8 q-pl-lg">
                                {{  comment.local_time}}
                            </div>
                        </div>
                    </div>
                </div><!--  /.row details -->

                <q-separator spaced
                ></q-separator>

                <div class="action-buttons flex q-my-lg q-px-md" >
                    <div class="right-buttons"
                         style="flex : 1">
                        <q-btn outline
                               size=".8rem"
                               padding=".3rem 1.5rem"
                               color="grey-7"
                               label="مشاهده دیدگاه"
                               :to="'/goto?path=' + comment.path"
                        ></q-btn>

                        <q-btn
                            size=".8rem"
                            unelevated
                            class="q-ml-sm"
                            padding=".3rem 1.5rem"
                            color="teal-6"
                            label="ویرایــش دیدگاه"
                            :to="{ name: 'comment.edit', params : {commentId : comment.id}}"
                        ></q-btn>

                    </div>

                    <div class="left-buttons justify-end"
                    >
                        <q-btn
                            size=".8rem"
                            unelevated
                            class="q-mr-sm"
                            padding=".3rem 1.5rem"
                            :color="comment.verified? 'orange-5': 'light-green-7'"
                            :label="verifyUnverifyBtnText"
                        ></q-btn>

                        <q-btn
                            size=".8rem"
                            unelevated
                            padding=".3rem 1.5rem"
                            :color="comment.trashed? 'brown-5' : 'red-4'"
                            :label="trashUntrashBtnText"
                        ></q-btn>
                    </div>
                </div>

            </div>

        </div>
    </q-page>
</template>

<script>
export default {
    name: 'Edit',

    data () {
        return {
            loaded: false,
            comment: []
        }
    },

    created () {
        this.fetchComment()
    },

    computed: {
        verifyUnverifyBtnText () {
            return this.comment.verified ? 'عدم تأیید' : 'تأیید دیدگاه'
        },

        trashUntrashBtnText () {
            return this.comment.trashed ? 'بازگردانی حذف' : 'حذف دیدگاه'
        }
    },

    methods: {
        fetchComment () {
            let comment_id = this.$route.params.commentId
            let uri = `/api/comments/${comment_id}/show`
            this.$axios.get(uri)
                .then(({ data }) => {
                    this.loaded = true
                    this.comment = data
                })
        }

    }
}
</script>

<style></style>
