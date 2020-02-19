<template>
    <q-page padding>
        <div class="row"
             v-if="loaded">
            <div class="col-12 col-md-8">
                <div id="main-area">
                    <div class="head-section">
                        لیست سرویس‌ها
                    </div>
                    <div class="add-new-service-btn">
                        <q-btn unelevated
                               size=".8rem"
                               to="/services/new/service"
                               class="q-px-md q-py-xs"
                               color="light-blue-14"
                               label="افزودن سرویس جدید" />
                    </div>

                    <div id="services-list">
                        <template v-for="(item, index) in allServices" >
                            <div class="service "
                                 :class="`depth-${item.depth}`"
                                 :key="index" >

                                <div class="color"
                                     :style="{backgroundColor: item.color.primary_color}"></div>
                                <div class="checkbox">
                                    <q-radio v-model="selectedService"
                                             size="2rem"
                                             :val="index" />
                                </div>
                                <div class="info">
                                    <div class="title">
                                        <router-link :to="`/services/edit/${item.id}/`" > {{ item.title }} </router-link>
                                        <div class="slug">
                                            {{ item.slug }}
                                        </div>
                                        <div class="category-name"
                                             :class="item.service_type">
                                            {{ categoryFarsiName(item.service_type) }}
                                        </div>
                                    </div>
                                    <div class="excerpt">
                                        {{ item.excerpt }}
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>

                    <div class="services-list__actions"
                         v-if="selectedService !== null ">
                        <div>
                            <q-btn outline
                                   size=".6rem"
                                   class="q-mr-sm"
                                   @click="editItem"
                                   label="ویرایش"
                                   color="grey-7" />

                            <q-btn outline
                                   class="q-mr-sm"
                                   size=".6rem"
                                   @click="gotoService"
                                   label="مشاهده"
                                   color="grey-7" />

                            <q-btn outline
                                   class="q-mr-sm"
                                   size=".6rem"
                                   @click="deleteItem"
                                   label="حذف"
                                   color="red-7" />
                        </div>
                        <div>
                            <q-btn outline
                                   @click="uncheckItem"
                                   class="q-mr-sm"
                                   size=".6rem"
                                   label="عدم انتخاب"
                                   color="grey-7" />
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="side-widgets sidebar">

                </div>
            </div>
        </div>

        <q-dialog v-model="deleteServiceDialog"
                  content-class="deletingDialog">
            <q-card>
                <q-card-section>
                    <p class="text-subtitle1 text-center">
                        آیا مظمئن هستید که پست مورد نظر حذف شود؟
                    </p>
                    <p>
                        در حال حذف سرویس ::
                        <span> {{ selectedServiceInfo.title }} </span>
                        ::
                    </p>
                    <div class="action-status"
                         v-if="deleting.done">
                        <div class="success"
                             v-if="deleting.success">
                            {{ deleting.message }}
                        </div>
                        <div class="error"
                             v-else>
                            {{ deleting.message }}
                        </div>
                    </div>
                </q-card-section>
                <q-card-actions class="justify-end">
                    <q-btn unelevated
                           size=".7rem"
                           color="grey-6"
                           v-close-popup
                           label="انصراف" />
                    <q-btn unelevated
                           size=".7rem"
                           color="red-4"
                           :loading="deleting.loading"
                           @click="removeSelectedService"
                           label="حذف شود" />
                </q-card-actions>
            </q-card>
        </q-dialog >
    </q-page>
</template>

<script>
export default {
    name: 'servicesIndex',
    data () {
        return {
            deleteServiceDialog: false,
            loaded: false,
            selectedService: null,
            deleting: {
                loading: false,
                done: false,
                success: false,
                message: ''
            },
            allServices: []
        }
    },
    beforeCreate () {
        this.$axios.get('/api/services/get-all/recursive/services')
            .then(res => {
                this.loaded = true
                this.allServices = res.data
            })
    },
    methods: {
        categoryFarsiName (enName) {
            if (enName === 'main') {
                return 'اصلی'
            }
            if (enName === 'category') {
                return 'دسته'
            }
        },
        uncheckItem () {
            this.selectedService = null
        },
        editItem () {
            let index = this.selectedService
            let id = this.allServices[index].id
            this.$router.push({ path: `/services/edit/${id}/` })
        },
        deleteItem () {
            this.deleteServiceDialog = true
        },
        gotoService () {
            let index = this.selectedService
            let slug = this.allServices[index].slug
            let path = `http://kazhal.test/services/${slug}/show/`
            window.open(path, '_blank')
        },
        removeSelectedService () {
            this.deleting.loading = true
            let index = this.selectedService
            let service = this.allServices[index]

            // making requets to service in order to delete service
            let data = {
                service_id: service.id
            }
            this.$axios.post('/api/services/delete/service', data)
                .then(res => {
                    this.deleting.done = true
                    this.deleting.loading = false
                    if (res.data.status == 'ok') {
                        this.deleting.success = true
                        this.deleting.message = 'سرویس با موفقیت حذف گردید'
                        this.allServices.splice(this.selectedService, 1)
                    } else {
                        this.deleting.success = false
                        this.deleting.message = res.data.message
                    }
                })
                .then(() => {
                    setTimeout(this.resetDeleting, 1000)
                })
        },
        resetDeleting () {
            this.deleteServiceDialog = false
            this.selectedService = null
            this.deleting = {
                done: false,
                success: false,
                message: ''
            }
        }

    },
    computed: {
        selectedServiceInfo () {
            if (this.selectedService === null) { return {} }
            let index = this.selectedService
            return this.allServices[index]
        }
    }

}
</script>

<style lang="scss">
#main-area{
    box-sizing: border-box;
    .head-section{
    } // /.head-section

    .add-new-service-btn{
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1.5rem;
        margin-left: 1rem #{"/* rtl:ignore */"};
    } // /.add-new-service-btn

    #services-list{
        padding: .5rem;
        margin: 0 1rem #{"/* rtl:ignore */"};
        max-height:25rem;
        overflow-y:scroll;
        border: 1px solid $rp-gray-2;
        .service{
            display: flex;
            height: 5rem;
            user-select:none;
            &:not(:last-child){
                border-bottom: 1px dashed  $rp-gray-2;
            }
            &:hover{
                background-color: $rp-gray-1;
                .info .title .category-name{
                    visibility: visible;
                }
            }
            @for $i from 1 through 10 {
                &.depth-#{$i}{
                    margin-right: (($i - 1)*2) + rem #{"/* rtl:ignore */"};
                }
            }
            .color{
                width: 6px;
                opacity:.4;
            } // .color
            .checkbox{
                min-width: 2.5rem;
                text-align: center;
                display: flex;
                align-items: center;
            } // .checkbox

            .info{
                flex: 1;
                .title{
                    padding: .25rem 0 ;
                    >a{
                        text-decoration: none;
                        color: $rp-gray-text-3;
                        font-weight: 600;
                        padding: .5rem .5rem .25rem 0 #{"/* rtl:ignore */"};
                        &:hover{
                            color: $blue-8;
                        }
                    }

                     .slug{
                        display: inline-block;
                        font-size: .75rem;
                        color: $rp-gray-text-3;
                        margin-right: 1rem #{"/* rtl:ignore */"};
                        background-color: $rp-gray-2;
                        border-radius: .2rem;
                        line-height: 1;
                        padding: .2rem .75rem;
                     }
                     .category-name{
                        float: left #{"/* rtl:ignore */"};
                        margin-left: .5rem #{"/* rtl:ignore */"};
                        color:white;
                        font-size: .7rem;
                        background-color: $rp-gray-2;
                        line-height: 1.2;
                        border-radius: .1rem;
                        padding: .1rem .75rem;
                        margin-top: .1rem;
                        opacity: .7;
                        visibility: hidden;
                        &.main{
                            background-color: $secondary;
                        }
                        &.category{
                            background-color: $warning;
                        }
                     }
                } // .title
                .excerpt{
                    // border: 1px solid $rp-gray-2;
                    height:3rem;
                    line-height: 1.4;
                    overflow:hidden;
                    word-break: break-all;
                    font-size: .7rem;
                    color: $rp-gray-text-2;
                    padding: .25rem .5rem;
                } // .excerpt
            } // .info
        } // .service
    }// #services-list

    .services-list__actions{
        padding: 1rem .5rem;
        display: flex;
        justify-content: space-between;
    }

}// /#main-area

.deletingDialog{
    .action-status{
        >div{
            margin: .75rem 1rem .25rem;
            padding: .25rem .5rem;
            text-align: center;
            font-size: .8rem;
            border-radius: .2rem;
        }
        .success{
            border: 1px solid $green-6;
            color: $green-6;
        }
        .error{
            border: 1px solid $red-4;
            color: $red-6;
        }
    }
}
</style>
