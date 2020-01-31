<template>
    <q-page padding >
        <div class="row user-preferences">
            <div class="col-3 q-pa-sm sidebar-buttons active">
                <q-list>
                    <q-item clickable tag="a" to="/user/preferences" exact >
                        <q-item-section>
                            <q-item-label >مشخصات کاربری</q-item-label>
                        </q-item-section>
                    </q-item> <!-- /User States Item -->

                    <q-item clickable tag="a" to="/user/preferences/change-password" exact >
                        <q-item-section>
                            <q-item-label >تغییر رمز عبور</q-item-label>
                        </q-item-section>
                    </q-item> <!-- /Change Password Item -->

                    <q-item clickable tag="a" to="/user/preferences/change-email" exact >
                        <q-item-section>
                            <q-item-label >تغییر ایمیل</q-item-label>
                        </q-item-section>
                    </q-item> <!-- /Change Email Item -->

                    <q-item clickable tag="a" to="/user/preferences/change-userphoto" exact >
                        <q-item-section>
                            <q-item-label >تغییر عکس کاربری</q-item-label>
                        </q-item-section>
                    </q-item> <!-- /Change Thumbnail Item -->

                </q-list>
            </div><!-- /.col-8 -->
            <div class="col q-pa-sm">
                <router-view>

                </router-view>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </q-page>
</template>

<script>
export default {
    name: 'Test',

    data () {
        return {
            bar: null
        }
    },

    mounted () {
    }
}
</script>

<style lang="scss" >
.user-preferences{
    // background-color: red;
    .sidebar-buttons{
        position: relative;
        border-left: 1px solid #eee #{"/* rtl:ignore */"};
        padding-left: 0 #{"/* rtl:ignore */"};
        padding-top: 0 #{"/* rtl:ignore */"};
        .q-list{
            min-height: 400px;
            height: 100%;
        }
        .q-item{
            .q-item__label{
                font-size: 1.05rem;
                font-weight: 600;
                color: #666;
            }
            &.q-router-link--exact-active{
                position: relative;
                .q-item__label {
                    color: #387e77;
                }
                &:hover{
                    // background-color: rgba(#387e77, .05);
                }
                &::after{
                    content: '';
                    display: block;
                    position: absolute;
                    left: 0 #{"/* rtl:ignore */"};
                    width: 4px;
                    height: 100%;
                    background-color: darken( #387e77,4);
                    top: 0;
                }
            }
        }
    }
}
            // &::after{
            //     content: '';
            //     display: block;
            //     width: 4px;
            //     background-color: darken(#eee, 20);
            //     height: 100%;
            //     position: absolute;
            //     left: 0 #{"/* rtl:ignore */"};
            //     top: 0;
            // }
</style>
