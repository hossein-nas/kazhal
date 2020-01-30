<template>
    <q-layout view="lHh Lpr lFf">
        <q-header elevated>
            <q-toolbar style="background-color: #387e77">
                <q-btn
                flat
                dense
                round
                @click="leftDrawerOpen = !leftDrawerOpen"
                icon="menu"
                aria-label="Menu"
                />

                <q-toolbar-title>
                Quasar App
                </q-toolbar-title>

                <div class="flex toolbar-dropdown">
                    <div class="username">
                        حسین نصیری
                    </div><!-- /.username -->
                    <div class="role">
                        مدیر
                    </div><!-- /.role -->
                    <div class="logo">
                        <img src="~assets/unknown_male.svg" alt="">
                    </div><!-- /.logo -->
                    <q-menu fit>
                        <q-list >
                            <q-item clickable to="/user/preferences">
                                <q-item-section avatar>
                                    <q-icon name="settings"></q-icon>
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>تنظیمات شخصی</q-item-label>
                                </q-item-section>
                            </q-item>

                            <q-item clickable to="/user/logout">
                                <q-item-section avatar>
                                    <q-icon name="exit_to_app"></q-icon>
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>خروج</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-menu>
                </div>
            </q-toolbar>
        </q-header>

        <q-drawer
        v-model="leftDrawerOpen"
        show-if-above
        bordered
        :width="250"
        content-class="bg-grey-2 ">

            <q-list class="sidebar">

                <q-item clickable tag="a" to="/dashboard" exact class="posts">
                    <q-item-section avatar>
                        <q-icon name="home" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label >پیشخوان</q-item-label>
                    </q-item-section>
                </q-item> <!-- Dashboard Item -->

                <q-item clickable tag="a" to="/posts" exact class="posts">
                    <q-item-section avatar>
                        <q-icon name="post_add" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label >پست‌ها</q-item-label>
                    </q-item-section>
                </q-item> <!-- Posts Item -->

                <q-item clickable tag="a" to="/services" exact class="posts">
                    <q-item-section avatar>
                        <q-icon name="work" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label >سرویس‌ها</q-item-label>
                    </q-item-section>
                </q-item> <!-- Services Item -->

                <q-item clickable tag="a" to="/orders" exact class="posts">
                    <q-item-section avatar>
                        <q-icon name="add_shopping_cart" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label >سفارشات</q-item-label>
                    </q-item-section>
                </q-item> <!-- Orders Item -->

                <q-item clickable tag="a" to="/comments" exact class="posts">
                    <q-item-section avatar>
                        <q-icon name="message" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label >نظرات</q-item-label>
                    </q-item-section>
                </q-item> <!-- Comments Item -->

                <q-item clickable tag="a" to="/users" exact class="posts">
                    <q-item-section avatar>
                        <q-icon name="supervised_user_circle" />
                    </q-item-section>
                    <q-item-section>
                        <q-item-label >کاربران</q-item-label>
                    </q-item-section>
                </q-item> <!-- Users Item -->

            </q-list>
    </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout>
</template>

<script>
export default {
    name: 'MyLayout',

    data () {
        return {
            leftDrawerOpen: false
        }
    }
}
</script>

<style lang="scss">
.q-list.sidebar{
    padding-top: 3rem;
    .q-item{
        .q-icon{
            color: #888;
            margin: 0;
            transition: color .3s ease-out;
        }
        &:hover, &:active, &:focus{
            .q-icon{
                color: #b97373;
            }
        }
    }
}
.q-item__label:not(.text-caption){
  font-weight: 600;
}
.toolbar-dropdown{
    // width: 150px;
    height: 100%;
    position: absolute;
    left: 0 #{"/* rtl:ignore */"};
    justify-content: flex-end;
    align-items: center;
    padding: .5rem 1rem;
    &:hover{
        background-color: rgba(white, .07);
        .username{color:white;}
        cursor: pointer;
    }
    .username{
        font-weight: 800;
        font-size: .85rem;
        color: #deebfb;
    }
    .role{
        color: yellow;
        background-color: rgba(white, .1);
        padding:.25rem .5rem;
        border-radius: .25rem;
        line-height: 1;
        margin: 0 .5rem;
        font-size: .75rem;

    }
    .logo{
        height: 100%;
        display: block;
        background-color: #fff;
        border-radius: 100%;
        overflow: hidden;
        width:30px ;
        height: 30px;
        text-align: center;
        box-shadow: 0 2px 4px -1px #696161;
        img{
            height: 105%;
            width: auto;
        }
    }
}
</style>
