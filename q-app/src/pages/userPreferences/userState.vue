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
                            {{ this.email }}
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
                            <q-input outlined v-model="firstname" :rules="[nameRule]" ref="firstname" />
                        </div><!-- /.form-control -->

                        <div class="form-control">
                            <div class="label">
                                نــــام خانوادگی :
                            </div><!-- /.label -->
                            <q-input outlined v-model="lastname"  :rules="[nameRule]" ref="lastname" />
                        </div><!-- /.form-control -->

                        <div class="form-control">
                            <div class="label">
                                بیوگرافی :
                            </div><!-- /.label -->
                            <q-input outlined v-model="bio" type="textarea" :rules="[bioRule]" ref="bio" />
                        </div><!-- /.form-control -->
                        <div class="form-control error" v-if="anyError">
                            <ul>
                                <li  v-text="error" >
                                </li>
                            </ul>
                        </div><!-- /.form-control error -->

                        <div class="form-control message" v-if="message">
                            <ul>
                                <li  v-text="message" >
                                </li>
                            </ul>
                        </div><!-- /.form-control error -->

                        <div class="form-control  submit ">

                            <q-btn  @click.prevent="submitChanges" flat style="color: #1c4440"
                            type="submit" label="ثبت تغییرات"
                            :disable="anyError" @mouseenter="anyErrors()" />

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
            error: '',
            message: '',
            anyError: false,
            anyChange: false
        }
    },
    methods: {
        setUser () {
            this.firstname = this.user.firstname
            this.lastname = this.user.lastname
            this.email = this.user.email
            this.bio = this.user.bio
        },
        submitChanges () {
            if (this.anyErrors()) {
                return false
            }
            this.$axios.post('api/user/update', {
                firstname: this.firstname,
                lastname: this.lastname,
                bio: this.bio
            })
                .then(res => {
                    if (res.data.status === 'ok') {
                        this.message = res.data.text
                        setTimeout(() => { this.message = '' }, 3000)
                    }
                    if (res.data.status === 'error') {
                        this.anyError = true
                        this.error = res.data.text
                    }
                })
                .catch(() => {
                    console.log('user submit error')
                })
        },
        nameRule (val) {
            if (val.length < 3) {
                return false || 'طول نام باید بیشتر از ۳ کاراکتر باشد.'
            }
        },
        bioRule (val) {
            if (val === null || val.length === 0) {
                return true
            }
            if (val.length < 10) {
                return false || 'طول کاراکترهای بیوگرافی باید بیشتر از ۱۰ کاراکتر باشد.'
            }
        },
        anyErrors () {
            let errors = this.$refs
            for (let err in errors) {
                if (!errors[err].validate()) {
                    this.anyError = true
                    return true
                }
            }
            this.anyError = false
            return false
        }
    },
    computed: {
        ...mapGetters({ user: 'auth/getUserInfo' })
    },
    mounted () {
        if (this.user) {
            this.setUser()
        }
    }
    // watch: {
    // }
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
            background-color: $rp-bg-gray;
            border: 1px solid $rp-gray-2;
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
            margin-bottom: 1rem;
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
            &.error, &.message{
                ul{
                    display: block;
                    margin: 0;
                    padding: 0;
                    &::after{
                        content:'';
                        display: block;
                        clear:both;
                    }
                    li{
                        padding-right: .75rem #{"/* rtl:ignore */"};
                        display: block;
                        font-size: .85rem;
                        color:$rp-error;
                        font-weight: 600;
                        margin-bottom: .25rem #{"/* rtl:ignore */"};
                    }
                }
                &:not(.error){
                    li{
                        color : $rp-success;
                    }
                }
            } // .error , .message
        } // .form-control

        .form-control + .error, .form-control + .message{
            margin-top: -1.5rem;
        }

    } // .form
</style>
