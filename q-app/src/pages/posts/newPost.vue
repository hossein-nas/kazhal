<template>
    <q-page padding>
        <div class="row">
            <div class="col-12 col-md-8 ">
                <div class="newpost">
                    <div class="head-section">
                        <span class="label">
                            ایجاد پست جــدید
                        </span><!-- /.label -->

                        <div class="action-buttons">
                            <div class="label">
                                انتخاب نوع پست :
                            </div><!-- /.label -->
                            <div class="button-group">
                                <div class="button select-news selected">
                                    خبـــر
                                </div><!-- /.button select-news -->
                                <div class="button select-tuts">
                                    آمـــوزش
                                </div><!-- /.button select-tuts -->
                            </div><!-- /.button-group -->
                        </div><!-- /.action-buttons -->

                    </div><!-- /.head-section -->
                    <div class="form">
                        <form >
                            <div class="form-control post-title">
                                <div class="label">عنوان پست :</div><!-- /.label -->
                                <q-input outlined type="text" name="post-title" size="3rem" v-model="postModel.title" hint="برای پست مورد نظر یک عنوان مناسب وارد کنید." />
                            </div><!-- /.form-control post-title -->

                            <div class="form-control post-content">
                                <div class="label">محتوای پست :</div><!-- /.label -->
                                <div class="textarea-wrapper">
                                    <ckeditor v-model="ckData" :config="ckConfig" />
                                </div><!-- /.textarea-wrapper -->
                            </div><!-- /.form-control post-title -->
                        </form>
                    </div><!-- /.form -->
                </div><!-- /.new-post -->
            </div><!-- /.col-12 col-md-9 -->

            <div class="col-12 col-md-4 side-widgets">
                <div class="sidebar">
                    <category />
                </div><!-- /.sidebar -->
            </div><!-- /.col-12 col-md-3 -->

        </div><!-- /.row -->

    </q-page>
</template>

<script>
import CKEditor from 'ckeditor4-vue'
import Category from '@/components/Category/Category'

export default {
    name: 'newPost',
    components: {
        ckeditor: CKEditor.component,
        category: Category
    },
    mounted () {
        this.$emit('newPostMounted')
    },
    data () {
        return {
            ckData: '',
            ckConfig: {
                language: 'fa'
            },
            newPost: true,
            postModel: {
                posttype: 'news'
            }
        }
    },
    async beforeCreate () {
        if (Object.keys(this.$route.params).length) {
            this.newPost = false
            let id = this.$route.params.id
            try {
                let post = await this.$axios.get(`api/posts/${id}/`)
                this.postModel = post.data.post
                this.ckData = post.data.post.content
            } catch (e) {}
        }
    }
}
</script>

<style lang="scss">
.newpost{
    margin-left: 1rem #{"/* rtl:ignore */"};
    border : 1px dashed $rp-gray-2;
    padding: .75rem;
    .head-section{
        background-color: $rp-gray-1;;
        border: 1px solid $rp-gray-2;
        border-radius: .5rem;
        padding: .5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        user-select : none;
        >.label{
            padding-right: .5rem #{"/* rtl:ignore */"};
            display: block;
            font-weight: 600;
            font-size: 1.05rem;
            color: $rp-gray-text-2;
        }
        .action-buttons{
            display:flex;
            align-items: center;
            background-color: white;
            padding: .3rem .75rem;
            border-radius: .3rem;
            border: 1px solid $rp-gray-2;
            >.label{
                font-size: .75rem;
                color: $rp-gray-text-1;
            }
            .button-group{
                display: flex;
                .button{
                    cursor: pointer;
                    font-size: .85rem;
                    position: relative;
                    padding: .125rem 2rem .125rem 0 #{'/* rtl:ignore */'};
                    font-weight: 600;
                    color: $rp-gray-text-1;
                    &::before{
                        content: '';
                        position: absolute;
                        right: .8rem #{"/* rtl:ignore */"};
                        width: .8rem;
                        height: .8rem;
                        opacity: 0;
                        border-radius: 100%;
                        top: .4rem;
                    }
                    &.selected{
                        color : $rp-green;
                        &::before{
                            opacity: .75;
                            background-color: $rp-green;
                        }
                    }
                    &:not(.selected):hover{
                        color: $rp-gray-text-3;
                        &::before{
                            opacity: .8;
                            background-color: $rp-gray-2;
                        }
                    }
                }
            }

        }
    }
} // .newpost

.side-widgets{
    .sidebar{
        min-width: 10rem;
        border-radius: .5rem;
        border: 1px solid $rp-gray-2;
    } // .sidebar
} // .side-widgets
</style>
