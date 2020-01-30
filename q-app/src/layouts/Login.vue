<template>
    <div class="wrapper user-select full-width row wrap justify-center items-center content-center">
        <div class="login-panel ">
            <div class="header row justify-center q-pa-sm">
                پنل مدیریت
                <strong class="q-px-sm">
                    رایان پردازش کژال
                </strong>
            </div><!-- /.header -->
            <div class="body">
                <div class="row q-px-lg q-pt-lg">
                    <div class="col">
                        <q-input dir="ltr" filled  stack-label v-model="username" label="ایمیل" v-autofocus />
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row q-px-lg q-pt-lg ">
                    <div class="col">
                        <q-input filled  type="password" stack-label v-model="password" label="پسورد" dir="ltr" />
                    </div><!-- /.col -->
                </div><!-- /.row  password -->
                <div class="row q-py-sm q-px-lg">
                    <div class="col">
                        <q-toggle
                        v-model="rememberMe"
                        label="مرا به خاطر بسپار"
                        left-label
                        />
                    </div><!-- /.col -->
                </div><!-- /.row checkbox -->

                <div class="row q-px-lg q-pb-lg justify-center">
                        <q-btn @click="login" outline class="q-pa-sm" style="color: #6a97c7; flex: 1 100%" label="ورود به پنل" >
                            <q-inner-loading :showing="loading" >
                                <q-spinner-dots
                                color="primary"
                                size="1em"
                                />
                            </q-inner-loading>
                        </q-btn>
                </div><!-- /.row -->

            </div><!-- /.body -->
        </div>
    </div><!-- /.wrapper -->
</template>

<script>
import { mapActions } from 'vuex'

export default {
    name: 'Login',

    data () {
        return {
            loading: false,
            rememberMe: false,
            username: 'hossein@example.com',
            password: '123'
        }
    },
    directives: {
        autofocus: {
            inserted (el) {
                el.focus()
            }
        }
    },
    methods: {
        ...mapActions({
            initSignIn: 'auth/init'
        }),
        login () {
            this.loading = true
            this.initSignIn({
                data: {
                    username: this.username,
                    password: this.password
                }
            }).then(res => {
                this.$router.push({ path: '/test' })
                    .catch(() => {
                        this.loading = false
                    })
            })
        },
        validateInputs () {
            //
        }
    }
}
</script>

<style lang="scss" >
body{
    background-color: #fbfbfb;
}
.wrapper{
 height: 100vh;
}
.login-panel{
    width: 350px;
    border: 1px solid #dadada;
    background-color: #fff;
    border-radius: .5rem;
    box-shadow:0 7px 11px -3px #d8d8d8;
    .header{
        font-size: .85rem;
        color: #888;
        margin-top: .25rem;
        border-bottom: 1px solid #dadada;
        strong{
            flex:1 100%;
            text-align: center;
            padding-top: .25rem;
            font-size: 1.125rem;
            color: #718677;
        }
    }
    .body{
        .row{
            .col{
                input{
                    font-size: 1.2rem;
                }
                .q-field--focused{
                    background-color: white;
                }
            }
        }
    }
}
</style>
