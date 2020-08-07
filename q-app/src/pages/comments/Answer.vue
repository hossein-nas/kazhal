<template>
    <q-page padding>
        <div class="row">
            <div class="col-8 offset-2 q-pa-md"
                 id="main-area">
                <div class="head-section user-select">
                    <span class="label flex flex-center">ارسال دیدگاه جدید</span>
                </div>

                <div class="q-mb-xl"
                     v-if="!loaded">
                    <div class="row q-mb-md">
                        <div class="col q-mr-md">
                            <q-skeleton type="rect"
                                        height="60px"></q-skeleton>
                        </div>
                        <div class="col">
                            <q-skeleton type="rect"
                                        height="60px"></q-skeleton>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <q-skeleton type="rect"
                                        height="200px"></q-skeleton>
                        </div>
                    </div>
                </div><!--  /.row -->

                <form  class="form"
                       @submit.prevent="submit"
                       v-else>
                    <div class="row">
                        <div class="form-control col">
                            <label for="body"
                                   class="label">
                                محتوای دیدگاه
                            </label>

                            <q-input type="textarea"
                                     class="q-mt-sm"
                                     autofocus
                                     autogrow
                                     counter
                                     hideBottomSpace
                                     :maxlength="500"
                                     standout
                                     inputStyle="min-height: 15rem"
                                     outlined
                                     v-model="form.body"></q-input>
                        </div>
                    </div><!--  /.row -->

                    <div class="row">
                        <div class="form-control col-12 col-md-6 q-pr-md">
                            <label for="username"
                                   class="label">نام :</label>
                            <q-input type="text"
                                     outlined
                                     :value="username"
                                     readonly></q-input>
                        </div><!--  /.form-control col-12 col-md-6 -->

                        <div class="form-control col-12 col-md-6">
                            <label for="email"
                                   class="label text-right "
                                   dir="ltr">Email :</label>
                            <q-input type="text"
                                     id="email"
                                     outlined
                                     dir="ltr"
                                     :value="email"
                                     readonly></q-input>
                        </div><!--  /.form-control col-12 col-md-6 -->
                    </div><!--  /.row -->

                    <div class="row reply-to"
                         v-if="reply_to">
                        <div class="col">
                            <q-field outlined
                                     class="user-select"
                                     disabled
                                     readonly
                            >
                                <template v-slot:control >
                                    <div class="reply-to-section">
                                        <p class="header q-mb-md">
                                            در پاسخ به ::
                                            <span v-text="comment.name"></span>
                                        </p>
                                        <p class="body no-margin"
                                           v-text="comment.body">

                                        </p>
                                    </div><!--  /.reply-to-section -->
                                </template>
                            </q-field>

                        </div><!--  /.col -->
                    </div><!--  /.row reply-to -->

                    <div class="row"
                         v-else>
                        <div class="col">
                            <q-select outlined
                                      use-input
                                      v-model="selectedPost"
                                      :options="postsToSelect"
                                      clearable
                                      @filter="filterFn"
                                      class="full-width"></q-select>
                        </div>
                    </div>

                    <div class="row submit q-mt-lg q-mb-xl">
                        <div class="col flex justify-end">

                            <q-btn unelevated
                                   type="submit"
                                   color="teal"
                                   padding=".875rem 2.5rem"
                                   :loading="submiting"
                                   label="ثبت دیدگاه"></q-btn>
                        </div>
                    </div><!--  /.row submit -->
                </form>

            </div>
        </div>
    </q-page>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'Answer',

    data () {
        return {
            form: {
                body: '',
                parent_id: null,
                post_id: null
            },
            submiting: false,
            posts: [],
            filteredPosts: [],
            selectedPost: null,
            comment: [],
            loaded: false,
            reply_to: false,
            new_reply: true
        }
    },

    created () {
        if (this.$route.params.commentId) {
            this.reply_to = true
            this.new_reply = false

            this.fetchComment()
        } else {
            this.fetchPosts()
        }
    },

    watch: {
        selectedPost (val) {
            if (val) {
                this.form.post_id = val.value
            }
        }
    },

    computed: {
        ...mapGetters('auth', ['getUserInfo']),

        email () {
            return this.getUserInfo.email
        },

        username () {
            return [this.getUserInfo.firstname, this.getUserInfo.lastname].join(' ')
        },

        postsToSelect () {
            return this.filteredPosts.map((post) => { return { label: post.title, value: post.id } })
        },

        postId () {
            if (this.selectedPost === null) {
                return null
            }

            return this.selectedPost.value
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
                    this.form.parent_id = data.id
                    this.form.post_id = data.post_id

                    this.approveBeforeAnswer(data)
                })
        },

        approveBeforeAnswer (comment) {
            let uri = `/api/comments/approve/${comment.id}`

            this.$axios.post(uri)
                .catch(() => {
                    alert('Error in approving')
                })
        },

        fetchPosts () {
            this.loaded = true

            let uri = `/posts/index`
            this.$axios.get(uri)
                .then(({ data }) => {
                    this.posts = data
                    this.filteredPosts = data
                })
        },

        filterFn (val, update, abort) {
            update(() => {
                const needle = val.toLowerCase()
                this.filteredPosts = this.posts.filter(v => v.title.toLowerCase().indexOf(needle) > -1)
            })
        },

        submit () {
            this.submiting = true

            let data = {
                ...this.form,
                name: this.username,
                email: this.email
            }
            let uri = '/api/comments/create'

            this.$axios.post(uri, data)
                .then(({ data }) => {
                    this.submiting = false

                    let dismiss = this.$q.notify({
                        type: 'positive',
                        message: 'دیدگاه با موفقیت ثبت شد',
                        timeout: 0
                    })

                    setTimeout(() => {
                        dismiss()
                        this.$router.push({ path: '/comments/index' })
                    }, 1500)
                })
        }
    }

}
</script>

<style>
#main-area{
    padding: .75rem;
}
</style>
