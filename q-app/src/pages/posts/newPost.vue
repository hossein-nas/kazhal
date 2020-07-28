<template>
    <q-page padding
    >
        <div class="row"
             v-if="loaded">
            <div class="col-12 col-md-8 ">
                <div class="newpost">
                    <div class="head-section">
                        <span class="label"
                              v-if="newPost">
                            ایجاد پست جــدید
                        </span><!-- /.label -->

                        <span class="label"
                              v-else>
                            ویرایش پست :: {{ postModel.title }}
                        </span><!-- /.label -->

                        <div class="action-buttons"
                             v-if="newPost">
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
                                <q-input outlined
                                         type="text"
                                         name="post-title"
                                         ref="postTitle"
                                         size="3rem"
                                         :rules="[postTitleValidate]"
                                         v-model="postModel.title"
                                         @input="postTitleUpdate"
                                         hint="برای پست مورد نظر یک عنوان مناسب وارد کنید." />
                                <div class="post-slug"
                                     id="post-slug"
                                     v-if="titleEntered"
                                     dir="ltr"
                                     @dblclick="selectURL">
                                    <span>URL Adress : </span>
                                    <span class="uri">{{ slugURL }}</span>
                                </div>
                            </div><!-- /.form-control post-title -->

                            <div class="form-control post-content">
                                <div class="label">محتوای پست :</div><!-- /.label -->
                                <div class="textarea-wrapper">
                                    <ckeditor v-model="ckData"
                                              :config="ckConfig" />
                                </div><!-- /.textarea-wrapper -->
                            </div><!-- /.form-control post-title -->
                        </form>
                    </div><!-- /.form -->
                </div><!-- /.new-post -->
            </div><!-- /.col-12 col-md-9 -->

            <div class="col-12 col-md-4 side-widgets">
                <div class="sidebar">
                    <category v-model="categories" />
                    <thumbnail v-model="thumbnail" />
                    <div class="submit">
                        <div class="publishedToggle">
                            <span>قابلیت نمایش پست</span>
                            <q-toggle v-model="postModel.published" />
                        </div>
                        <div class="submit-button">
                            <q-btn label="ذخیره‌ی پست"
                                   unelevated
                                   v-if="newPost"
                                   @click="submitPost"
                                   color="blue-9" />
                            <q-btn label="ثبت تغییرات"
                                   v-else
                                   unelevated
                                   @click="submitPost"
                                   color="blue-9" />

                        </div>
                    </div>
                </div><!-- /.sidebar -->
            </div><!-- /.col-12 col-md-3 -->

        </div><!-- /.row -->

    </q-page>
</template>

<script>
import CKEditor from 'ckeditor4-vue'
import Category from '@/components/Category/Category'
import Thumbnail from '@/components/widgets/Thumbnail'

export default {
    name: 'newPost',
    components: {
        ckeditor: CKEditor.component,
        category: Category,
        thumbnail: Thumbnail
    },
    mounted () {
        this.$emit('newPostMounted')
    },
    data () {
        return {
            loaded: false,
            ckData: '',
            ckConfig: {
                language: 'fa'
            },
            thumbnail: null,
            categories: {
                init: [1]
            },
            newPost: true,
            errors: [],
            anyError: false,
            postModel: {
                post_type: 1,
                title: '',
                slug: '',
                published: true
            }
        }
    },
    async beforeMount () {
        if (Object.keys(this.$route.params).length) {
            this.newPost = false
            let slug = this.$route.params.slug
            try {
                let { data } = await this.$axios.get(`/posts/${slug}/show`)
                this.postModel = data
                this.postModel.published = !!this.postModel.published
                this.ckData = this.postModel.content
                this.categories.init = this.pluckIds(this.postModel.categories)
                this.thumbnail = {
                    thumbnailId: this.postModel.thumb.id,
                    previewImage: this.postModel.thumb.specs[0].relativepath
                }
            } catch (e) {}
        }
        this.loaded = true
    },
    methods: {
        postTitleValidate (val) {
            if (!val) {
                return false || 'این فیلد باید پرشود.'
            }
            if (val.length < 10) {
                return false || 'تعداد کاراکتر حداقل باید ۱۰ تا باشد.'
            }
            return true
        },
        validateAllInputs () {
            this.errors = []
            this.anyError = false
            if (this.postModel.title !== undefined && this.postModel.title.length < 10) {
                this.anyError = true
                this.errors.push('تعداد کاراکتر های عنوان پست ناکافی است.')
            }
            if (this.ckData !== undefined && this.ckData.length < 15) {
                this.anyError = true
                this.errors.push('متن پست حداقل باید ۱۵ کاراکتر باشد.')
            }
            if (this.categories && this.categories.selected.length == 0) {
                this.anyError = true
                this.errors.push('دسته‌ای برای پست انتخاب نشده است')
            }
            if (this.thumbnail === null) {
                this.anyError = true
                this.errors.push('تصویر شاخص انتخاب نشده است')
            }
        },
        submitPost () {
            let data = {
                title: this.postModel.title,
                content: this.ckData,
                published: this.postModel.published,
                slug: this.postModel.slug,
                post_type: this.postModel.post_type,
                categories: this.allCategories,
                thumbnail_id: this.thumbnail
            }
            this.validateAllInputs()
            if (this.anyError) {
                alert('در داده‌های ورودی خطایی مشاهده می‌شود.')
                return
            }

            // this is because of check for new post or Post Update functionality
            if (this.newPost === true) {
                this.$axios.post('/api/posts/add-new/post', data)
                    .then((res) => {
                        console.log(res.data)
                    })
            } else {
                this.$axios.post(`/api/posts/update/${this.postModel.id}/post`, data)
                    .then((res) => {
                        console.log(res.data)
                    })
            }
        },
        postTitleUpdate (value) {
            let slug = value.trim()
            slug = slug.replace(/\s/gi, '-')
            slug = slug.replace(/[._?؟()[\]{}‌]/gi, '')
            this.postModel.slug = slug
        },
        selectURL () {
            event.preventDefault()
            let el = document.getElementById('post-slug')
            var sel = window.getSelection()
            var range = document.createRange()
            range.selectNodeContents(el.childNodes[1])
            sel.removeAllRanges()
            sel.addRange(range)
        },

        pluckIds (obj) {
            return Object.keys(obj).map(f => obj[f].id)
        }

    },
    computed: {
        slugURL () {
            let slug = this.postModel.slug
            return `http://rp-kazhal.ir/posts/${slug}/show`
        },
        titleEntered () {
            if (this.postModel.title && this.postModel.title.length) {
                return true
            }
            return false
        },
        allCategories () {
            let result = []
            for (let cat in this.categories.selected) {
                let c = this.categories.selected[cat]
                result.push(c.id)
            }
            return result
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

.form{
    .form-control{
        &.post-title{
            position: relative;
            .post-slug{
                position: absolute;
                top: .25rem;
                left: 0rem #{"/* rtl:ignore */"};
                direction: ltr #{"/* rtl:ignore */"};
                span{
                    font-size: .75rem;
                    color: $rp-gray-text-1;
                    &.uri{
                        font-size: .85rem;
                        color: $rp-gray-text-2;
                        font-weight: 600;
                        transition: color .2s ease-out;
                        &:hover{
                            cursor: default;
                            color: $rp-blue;
                        }
                    }
                }
            }
        }
    }
}

.side-widgets{
    .sidebar{
        min-width: 10rem;
        border-radius: .5rem;
        border: 1px solid $rp-gray-2;

        .submit{
            user-select : none;
            padding-bottom: 1rem;
            .publishedToggle{
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0 1rem 0;
                margin-bottom: 1rem;
                margin-top: .5rem;
                span{
                   color: $rp-gray-text-2;
                   font-size: .85rem;
                }
                >div{
                    transform: translateX(-.5rem) #{"/* rtl:ignore */"};
                }
            } // /.publishedToggle

            .submit-button{
                display: flex;
                justify-content: flex-end;
                padding-left: 1rem #{"/* rtl:ignore */"};
            } // /.submit-button

        } // /.submit
    } // .sidebar
} // .side-widgets
</style>
