<template>
    <q-page padding>
        <div id="posts">
            <div class="row">

                <div class="col-md-9 col-12">
                    <div class="main-area">
                        <div class="head-section user-select">
                            <span>
                                بخش مدیریت پست‌ها
                            </span>
                            <router-link to="/posts/new/post">
                                <div class="action button newpost">
                                    ایجاد پست جدید
                                    <q-icon name="add_box"
                                            size="xs">
                                    </q-icon>
                                </div><!-- /.action button newpost -->
                            </router-link>
                        </div><!-- /.head-section -->

                        <div class="body">

                            <div class="all-news ">
                                <div class="head-section">
                                    <span>
                                        همه‌ی اخبار
                                    </span>
                                    <div class="searchbox">
                                        <input type="text"
                                               id="searchbox-input"
                                               placeholder="">
                                        <q-icon name="search"></q-icon>
                                    </div><!-- /.searchbox -->
                                </div><!-- /.head-section -->
                                <div class="body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="title">عنوان</th>
                                                <th class="author">نویسنده</th>
                                                <th class="date_at">ارسال شده در</th>
                                                <th class="action"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="post in posts"
                                                :key="post.id" >
                                                <td class="title">
                                                    <div class="thumb">
                                                        <q-img :src="getThumb(post.thumb.specs[0].fullpath)"></q-img>
                                                    </div><!-- /.thumb -->
                                                    <router-link to="/">
                                                        <span>
                                                            {{ post.title }}
                                                        </span>
                                                    </router-link>
                                                </td>
                                                <td class="author">
                                                    <router-link to="/hossein">
                                                        <span>
                                                            {{ post.author.firstname }}
                                                        </span>
                                                    </router-link>
                                                </td>
                                                <td class="date_at">
                                                    <span class="date">
                                                        پنجشنبه ۵ دی
                                                    </span><!-- /.date -->
                                                    <span class="time"> ۲۳:۴۸</span><!-- /.time -->
                                                </td>
                                                <td class="action">
                                                    <div class="post-status not">
                                                        غیر قابل مشاهده
                                                    </div><!-- /.post-status -->
                                                    <div class="buttons">
                                                        <div class="edit">
                                                            <router-link :to="`/posts/edit/post/${post.id}/`">
                                                                <q-icon name="text_format"></q-icon>
                                                            </router-link>
                                                        </div><!-- /.edit -->
                                                        <div class="goto-post">
                                                            <a :href="`http://kazhal.test/posts/${post.slug}/show`"
                                                               target="blank">
                                                                <q-icon name="link"></q-icon>
                                                            </a>
                                                        </div><!-- /.edit -->
                                                        <div class="delete"
                                                             @click="deletePost(post.id)">
                                                            <q-icon name="delete_outline"></q-icon>
                                                        </div><!-- /.edit -->
                                                    </div><!-- /.buttons -->
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div><!-- /.body -->
                            </div><!-- /.all-news -->
                        </div><!-- /.body -->

                    </div><!-- /.main-area -->
                </div><!-- /.col -->
                <div class="col-12 col-md-3">
                    <div class="sidebar">
                        <category />
                    </div><!-- /.sidebar -->
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /#posts -->

    </q-page>

</template>

<script>
import Category from '@/components/Category/Category'
export default {
    name: 'Posts',
    components: {
        Category
    },
    data () {
        return {
            posts: []
        }
    },
    beforeMount () {
        this.$axios.get('api/posts/all-posts')
            .then((res) => {
                this.posts = res.data
            })
    },
    methods: {
        deletePost (post) {
            alert(post)
        },
        getThumb ($thumb) {
            return window.baseURL + $thumb
        }
    }
}
</script>

<style lang="scss">
#posts{
    .main-area{
        margin-left: .5rem #{"/* rtl:ignore */"};
        border: 1px dashed $rp-gray-2;
        padding: .75rem;
        >.head-section{
            margin-bottom: 1.5rem;
            border-radius: .75rem;
            background-color: $rp-gray-1;
            border: 1px solid $rp-gray-2;
            padding: 0 .5rem;
            min-height: 3rem;
            line-height: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            span{
                padding-right: .5rem #{"/* rtl:ignore */"};
                display: block;
                font-weight: 900;
                color: $rp-gray-text-2;
                font-size: 1.05rem;
            }
            .action{
                font-size: .85rem;
                color: $rp-gray-text-1;
                float: left #{"/* rtl:ignore */"};
                background-color: white;
                border: 1px solid $rp-gray-2;
                padding: .4rem 1.25rem;
                text-align: center;
                border-radius: .5rem;
                line-height: 1.25;
                &:hover{
                    border-color: lighten($rp-blue, 15);
                    color: darken($rp-blue,8);
                    cursor: pointer;
                }
                i{
                    transform: translateX(-.125rem) #{"/* rtl:ignore */"};
                }
            } // .action.button.
        } // .head-section
        .body{
            .all-news{
                >.head-section{
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    border-bottom: 1px solid $rp-gray-2;
                    padding: .5rem 1rem .5rem .5rem #{"/* rtl:ignore */"};
                    span{
                        font-size: 1.1rem;
                        color: $rp-gray-text-1;
                    }
                    .searchbox{
                        display: flex;
                        justify-content: flex-end;
                        align-items: center;
                        border: 1px solid $rp-gray-2;
                        border-radius: .25rem;
                        padding: .25rem;
                        min-width: 250px;
                        input{
                            flex: 1;
                            border: 0;
                            outline: none;
                            color: $rp-gray-text-3;
                            font-size: .85rem;
                            line-height: 1;
                            padding: .125rem .5rem;
                        }
                        i{
                            font-size: 1.1rem;
                            line-height: 1.25;
                            margin-left: .25rem #{"/* rtl:ignore */"};
                            color: $rp-gray-text-1;
                        }
                    }
                }
                >.body{
                    table{
                        width: 100%;
                        border-collapse: collapse;
                        border-spacing: 0;
                        thead{
                            border-bottom: 1px solid $rp-gray-2;
                            tr{
                                th{
                                    font-weight: 600;
                                    color: $rp-gray-text-1;
                                    text-align: right #{"/* rtl:ignore */"};
                                    font-size: .85rem;
                                    height: 2.5rem;
                                    line-height: 1.5rem;
                                    padding-right: .5rem #{"/* rtl:ignore */"}
                                }
                                th.title{
                                    width:45%;
                                }
                                th.author{
                                    width:20%;
                                }
                                th.date_at{
                                    text-align: center;
                                    width:15%;
                                }
                                th.action{
                                    width:20%;
                                }
                            }
                        }
                        tbody{
                            tr{
                                transition: background-color .2s ease-out;
                                td{
                                    vertical-align: top;
                                    padding: .5rem .5rem;
                                    height:4.5rem;
                                    overflow: hidden;
                                    &::after{
                                        content: '';
                                        display: block;
                                        clear: both;
                                    }
                                    a{
                                        text-decoration: none;
                                        color: $rp-blue;
                                        font-weight: 600;
                                        span{
                                        }
                                    }
                                    &.title{
                                        .thumb{
                                            width: 72px;
                                            height: 45px;
                                            float: right #{"/* rtl:ignore */"};
                                            margin-left: .75rem #{"/* rtl:ignore */"};
                                            overflow: hidden;
                                            border-radius: .25rem;
                                        }

                                    }
                                    &.date_at{
                                        vertical-align: baseline;
                                        span{
                                            display: block;
                                            width: 100%;
                                            overflow: hidden;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;
                                            font-size: .85rem;
                                            color: $rp-gray-text-1;
                                            text-align: center;
                                            padding: .25rem 0;
                                            &.date{

                                            }
                                            &.time{

                                            }
                                        }
                                    } // /td.date_at
                                    &.action{
                                        .post-status{
                                            width: 80%;
                                            margin: 0 auto;
                                            text-align: center;
                                            padding: .25rem;
                                            border: 1px solid lighten($rp-green,10);
                                            color: darken($rp-green,10);
                                            opacity: .7;
                                            border-radius: .25rem;
                                            line-height: 1.1;
                                            margin-bottom: .25rem;
                                            font-size: .75rem;
                                            &.not{
                                                border: 1px solid lighten($rp-red,10);
                                                color: darken($rp-red,10);
                                            }
                                        }
                                        .buttons{
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            visibility: hidden;
                                            >div{
                                                position: relative;
                                                padding: .25rem;
                                                cursor: pointer;
                                                border-radius: 100%;
                                                transition: all .25s ease-out;
                                                i{
                                                    font-size: 1.3rem;
                                                    opacity: .5;
                                                    color: $rp-gray-text-1;
                                                }
                                                &:hover{
                                                    background-color: $rp-gray-1;
                                                    i{
                                                        opacity: 1;
                                                        color: darken($rp-blue, 10);
                                                    }
                                                }
                                            }
                                        }
                                    }

                                }
                                &:nth-child(2n){
                                    background-color: $rp-gray-1;
                                }
                                &:hover{
                                    background-color: lighten($rp-green,45);
                                }
                                &:hover td.action .buttons{
                                    visibility: visible;
                                }

                            } // tr

                        }
                    }

                }
            }

        } // main-area > .body
    } // .main-area

    .sidebar{
        // background-color: $rp-gray-1;
        min-height: 10rem;
        border-radius: .5rem;
        border: 1px solid $rp-gray-2;
    } // .sidebar

} // #posts

</style>
