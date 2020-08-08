<template>
    <q-page padding
            :key="this.$route.name">
        <div class="row"
             v-if="loaded">
            <div class="col-8 offset-2"
                 id="main-area">
                <div class="head-section user-select">
                    <span class="label ">مشاهده‌ی جزئیات دیدگاه</span>

                    <router-link :to="'/comments/answer/to/' + comment.id + '/' "
                                 class="action primary"
                                 tabindex="0">
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
                                 v-if="!editing"
                        >
                            <template v-slot:control >
                                <div
                                    v-text="comment.body"
                                    style="min-height: 6rem"></div>
                            </template>
                        </q-field>
                        <q-input type="textarea"
                                 v-model="body"
                                 outlined
                                 standout
                                 autogrow
                                 inputStyle="min-height: 7rem"
                                 v-else
                                 autofocus
                        />
                    </div>
                </div><!--  /.row detail-body -->

                <div class="row post-url q-mb-lg">
                    <div class="col-12 col-md-3 text-right text-grey-6">
                        ارسال شده زیر پست :
                    </div>
                    <div class="col-12 col-md-9 q-px-lg">
                        <a :href="comment.post.path"
                           tabindex="-1"
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

                <div class="action-buttons flex q-my-lg q-px-md"
                     v-if="!editing">
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
                            @click.prevent="verificationMethod"
                            :color="comment.verified? 'orange-5': 'light-green-7'"
                            :label="verifyUnverifyBtnText"
                        ></q-btn>

                        <q-btn
                            size=".8rem"
                            unelevated
                            padding=".3rem 1.5rem"
                            @click.prevent="trashMethod"
                            :color="comment.trashed? 'brown-5' : 'red-4'"
                            :label="trashUntrashBtnText"
                        ></q-btn>
                    </div>
                </div> <!-- !.action-buttons -->

                <div class="action-buttons flex justify-end q-ma-md q-mt-lg"
                     v-else>
                    <q-btn unelevated
                           color="secondary"
                           label="ثبت تغییرات"
                           tabindex="0"
                           @click.prevent="submitChange"
                           size=".95rem"
                           padding=".95rem 2.5rem"></q-btn>

                </div><!--  /.action-buttons -->

            </div>

        </div>
    </q-page>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name: 'Edit',

    data () {
        return {
            loaded: false,
            comment: [],
            editing: false,
            body: ''
        }
    },

    created () {
        this.fetchComment()
    },

    watch: {
        editing (val, old) {
            if (val === true && old === false) {
                this.changeToEditing()
            } else {
                this.revertEditing()
            }
        }

    },

    updated () {
        if (this.$route.name === 'comment.edit') {
            this.editing = true
        } else if (this.$route.name === 'comment.detail') {
            this.editing = false
        }
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
        ...mapActions('comment', [
            'approveComment',
            'trashComment'
        ]),

        fetchComment () {
            this.loaded = false

            let comment_id = this.$route.params.commentId
            let uri = `/api/comments/${comment_id}/show`
            this.$axios.get(uri)
                .then(({ data }) => {
                    this.comment = data

                    this.$nextTick(() => { this.loaded = true })
                })
        },

        changeToEditing () {
            this.body = this.comment.body
        },

        revertEditing () {
            this.fetchComment()

            this.body = null
        },

        submitChange () {
            if (this.editing) {
                let uri = `/api/comments/update/${this.comment.id}/`

                this.$axios.patch(uri, { body: this.body })
                    .then(() => {
                        this.notify()

                        setTimeout(() => {
                            this.$router.push({ name: 'comment.detail', params: { commentId: this.comment.id } })
                        }, 1000)
                    })
            }
        },

        notify () {
            this.$q.notify({
                type: 'positive',
                color: 'secondary',
                message: 'دیدگاه با موفقیت ویرایش شد',
                timeout: 950
            })
        },

        verificationMethod () {
            let uri = `/api/comments/approve/${this.comment.id}/`,
                message = '',
                type = 'post'

            if (this.comment.verified === 1) {
                message = 'دیدگاه مرود نظر با موفقیت از حالت تأیید بازگردانی شد.'
                type = 'delete'
            } else {
                message = 'دیدگاه مورد نظر با موفقیت تأیید گردید.'
            }

            let data = {
                uri, type
            }

            this.approveComment(data)
                .then(() => {
                    this.comment.verified = !this.comment.verified
                })
        },

        trashMethod () {
            let uri = `/api/comments/trash/${this.comment.id}/`,
                type = 'post'

            if (this.comment.trashed === 1) type = 'delete'

            let data = {
                type, uri
            }

            this.trashComment(data)
                .then(() => {
                    this.comment.trashed = !this.comment.trashed
                })
        }
    }
}
</script>

<style></style>
