<template>
    <div class="panel">
        <div class="header">
            {{ title }}
        </div><!--  /.header -->
        <div class="body">
            <template v-if="hasContent">
                <div
                    v-for="(item, index) in value"
                    :key="index"
                    class="item-box">
                    <p class="reply-to">
                        پاسخ
                        <span class="replier"
                              v-text="replier(item)">
                        </span>
                        به ::
                        <span> <router-link :to="'/comments/show/' + item.id + '/detail'">{{ item.name }}</router-link></span>
                    </p>
                    <p class="reply-post">
                        در پست ::
                        <a :href="item.path"
                           v-text="item.post.title"></a>
                    </p>
                </div>
            </template>

            <p v-else
               class="no-data">
                هنوز داده‌ای ثبت نشده !
            </p>
        </div>
    </div><!--  /.panel -->
</template>

<script>

export default {
    name: 'LatestApproved',

    props: ['value', 'title', 'owns'],

    data () {
        return {
            defaultReplier: 'شما'
        }
    },

    computed: {
        hasContent () {
            return this.value.length
        }
    },

    methods: {

        replier (item) {
            if (this.owns === false && item.verified) {
                return [item.verifier.firstname, item.verifier.lastname].join(' ')
            }
            return this.defaultReplier
        }
    }
}
</script>

<style lang="scss">
.item-box{
    padding:.5rem .75rem;
    border: 1px dashed $rp-input-border;
    margin-bottom: .5rem;

    &:hover{
        border-color: darken($rp-input-border, 4);
        background-color: $rp-bg-gray;
    }

    p{
        color: $rp-gray-text-3;
        font-size: .75rem;
        line-height: 14px;
        margin: 0;

        &.reply-to{
            margin-bottom: .5rem;

            span,a{
                text-decoration: none;
                font-size: .875rem;
                font-weight: 600;
                color: $rp-gray-text-4;
                padding: 0 .125rem;

                &.replier{
                color: $rp-gray-text-2;
                }
            }
        }

        &.reply-post{

            a{
                font-weight: 600;
                font-size: .875rem;
                padding-right: .25rem;
                text-decoration: none;
                color: #437D96;
            }
        }
    }
}// !.item-box

.no-data{
    margin: 0;
    text-align: center;
    padding:1.5rem;
    color: $rp-error;
    font-size: .875rem;
    line-height: 1.5;
}
</style>
