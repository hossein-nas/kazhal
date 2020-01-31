<template>
    <div class="user-state">
        <div class="header">
            مشخصات کاربری
        </div><!-- /.header -->
        <div class="body">
            <div class="user-photo user-select">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="thumbnail">
                            <div class="frame">
                                <img src="~assets/unknown_male.svg" alt="">
                            </div><!-- /.frame -->
                        </div><!-- /.thumbnail -->
                        <div class="caption">
                            {{ this.email}}
                            <span class="role">
                                ادمین
                            </span><!-- /.role -->
                        </div><!-- /.caption -->
                    </div><!-- /.col-4 -->

                    <div class="col form">

                        <div class="form-control">
                            <div class="label">
                                نــــام :
                            </div><!-- /.label -->
                            <q-input outlined v-model="firstname"  />
                        </div><!-- /.form-control -->

                        <div class="form-control">
                            <div class="label">
                                نــــام خانوادگی :
                            </div><!-- /.label -->
                            <q-input outlined v-model="lastname"  />
                        </div><!-- /.form-control -->

                        <div class="form-control">
                            <div class="label">
                                بیوگرافی :
                            </div><!-- /.label -->
                            <q-input outlined v-model="bio" type="textarea"   />
                        </div><!-- /.form-control -->

                        <div class="form-control  submit ">
                            <q-btn  flat style="color: #1c4440"  type="submit" label="ثبت تغییرات"  />
                        </div><!-- /.form-control -->

                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.user-photo -->
        </div><!-- /.body -->
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
    name: 'userState',
    data () {
        return {
            firstname: '',
            lastname: '',
            email: '',
            bio: '',
            anyChange: false
        }
    },
    methods: {
        setUser () {
            this.firstname = this.user.firstname
            this.lastname = this.user.lastname
            this.email = this.user.email
            this.bio = this.user.bio
        }
    },
    computed: {
        ...mapGetters({ user: 'auth/getUserInfo' })
    },
    mounted () {
        if (this.user) {
            this.setUser()
        }
    },
    watch: {
        user () {
            this.setUser()
        }
    }
}
</script>

<style lang="scss" scoped>
    .user-state{
        margin-top: -.5rem;
        border: 1px dashed #eee;
        padding: 1rem ;
        min-height: 500px;
        position: relative;
        .header{
            min-height: 3rem;
            text-align: center;
            font-weight: 800;
            color: #797979;
            font-size: 1rem;
            // margin:0 .5rem;
            background-color: #eee;
            border: 1px solid darken( #eee, 2);
            border-radius: .25rem;
            line-height: 3;
            margin-bottom: 2.5rem;
        } // .header

        .body{
            .user-photo{
                .col-4{
                    padding-right: .5rem ;
                    border-left: 1px solid #eee #{"/* rtl:ignore */"};
                    justify-items: center;
                    min-height: 400px;
                }
                .thumbnail{
                    display: block;
                    height: 150px;
                    width: 150px;
                    margin: 1rem auto;
                    border-radius: 100%;
                    border: 1px solid #eee;
                    box-shadow: 0 4px 6px -1px #ddd;
                    position: relative;
                    overflow: hidden;
                    opacity: .9;
                    .frame{
                        position: absolute;
                        right: 50%;
                        transform: translate(50% , -5%);
                        width: 200%;
                        height: 110%;
                        text-align: center;
                        img{
                            height: 100%;
                            width: auto;
                        }

                    }

                } // .thumbnail
                .caption{
                    text-align: center;
                    font-weight: 600;
                    font-size: .85rem;
                    color: #454545;

                    .role{
                        display: block;
                        width: 150px;
                        background-color: #eee;
                        border-radius: .25rem;
                        color: #797979;
                        margin: 0 auto;
                        margin-top: 1rem;
                        padding:.25rem .5rem ;
                    }
                } // .caption

            } // .user-photo
        }// .body
    } // .user-state

    .form{
        padding: 0 2rem;
        .form-control{
            margin-bottom: 1.5rem;
            .label{
                font-size: .85rem;
                font-weight: 600;
                color: #777;
                margin-bottom: .5rem;
            }
            .q-input{
                font-size: 1.2rem;
                input{
                }
            }
            &.submit{
                button[type="submit"]{
                    font-weight: 600;
                    float: left #{"/* rtl:ignore */"};
                }
            }

            &::after{
                content:'';
                display: block;
                clear: both;
            }
        } // .form-control

    } // .form
</style>
