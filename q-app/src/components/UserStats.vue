<template>
    <div class="panel">
        <div class="header">
            مشخصات شما
        </div><!--  /.header -->

        <div class="body">
            <q-markup-table v-if="commentsLoaded"
                            flat
            >
                <tbody>
                    <tr v-for="(row, index) in table"
                        :key="index">
                        <td v-text="row.label"
                            class="slim-text"></td>
                        <td v-html="createDomElem(row)"
                            style="text-align: left; white-space: normal"></td>
                    </tr>
                </tbody>
            </q-markup-table>

            <q-inner-loading :showing="!commentsLoaded">
                <q-spinner size="2rem"
                           color="blue"
                           :thickness="3"/>
            </q-inner-loading>
        </div><!--  /.body -->
    </div><!--  /.panel -->
</template>

<script>

import { mapGetters } from 'vuex'

export default {
    name: 'UserStats',

    props: ['value'],

    data () {
        return {
            //
        }
    },

    methods: {
        createDomElem (item) {
            if (typeof item.data === 'string' || typeof item.data === 'number') {
                let str = `<span> ${item.data} </span>`
                str += (item.suffix) ?? ''

                return str
            }

            if (item.data === null) return '<span> داده‌ای ثبت نشده </span>'

            if (typeof item.data === 'object') {
                if (item.data.type === 'link') {
                    return `<a href="${item.data.path}" target="_blank"> ${item.data.text} </a>`
                }
            }
        },
    },

    computed: {
        ...mapGetters('comment', [
            'userSentCommentsCount',
            'userSentComments',
            'approvedByUserCount',
            'commentsLoaded'
        ]),
        ...mapGetters('auth', [
            'getUserInfo'
        ]),

        table () {
            return [
                {
                    label: 'اخرین پاسخ ارسالی',
                    data: this.lastUserComment,
                },
                {
                    label: 'تعداد دیدگاه‌های شما',
                    data: this.userSentCommentsCount,
                    suffix: 'پاسخ',
                },
                {
                    label: 'تعداد تأیید کرده‌ها',
                    data: this.approvedByUserCount,
                    suffix: 'دیدگاه',
                },
                {
                    label: 'آی پی آدرس شما',
                    data: this.getUserInfo.ip,
                }
            ]
        },
        lastUserComment () {
            if (!this.userSentCommentsCount) return null
            let lastComment = this.userSentComments.slice(0)[0]

            return {
                type: 'link',
                path: lastComment.path,
                text: lastComment.post.title,
            }
        },
    },
}
</script>

<style>
</style>
