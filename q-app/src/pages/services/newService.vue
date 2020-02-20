<template>
    <q-page padding
            v-if="allSet">
        <div class="row">
            <div class="col-12 col-md-8">
                <div id="main-area">
                    <div class="head-section">
                        <div class="label">
                            <template v-if="!editing">
                                افزودن سرویس جدید
                            </template>
                            <template v-else>
                                ویرایش سرویس
                            </template>
                        </div>
                    </div>
                    <div class="body">
                        <div class="form">
                            <form >
                                <div class="row">
                                    <div class="col">
                                        <div class="form-control">
                                            <div class="label">
                                                عنوان سرویس :
                                            </div>
                                            <q-input outlined
                                                     @input="validateInputs"
                                                     ref="postTitle"
                                                     v-model="serviceModel.title"
                                                     hint="اسم سرویسی که می‌خواهید بسازید را به فارسی بنویسید."
                                            />
                                        </div>  <!-- ./form-control serviceModel Title -->
                                    </div>

                                    <div class="col q-pl-md"
                                         dir="ltr">
                                        <div class="form-control">
                                            <div class="label">
                                                Service Slug :
                                            </div>
                                            <q-input outlined
                                                     @input="validateInputs"
                                                     @blur="escapeWhitespace($event)"
                                                     ref="postSlug"
                                                     v-model="serviceModel.slug"
                                                     hint="اسم سرویسی که می‌خواهید بسازید را به انگلیسی بنویسید"
                                            />
                                        </div>  <!-- ./form-control serviceModel Title -->
                                    </div>
                                </div>

                                <div class="form-control">
                                    <div class="label">
                                        توضیح مختصر :
                                    </div>
                                    <q-input type="textarea"
                                             ref="postExcerpt"
                                             @input="validateInputs"
                                             counter
                                             maxlength="400"
                                             outlined
                                             :rows="5"
                                             v-model="serviceModel.excerpt"
                                    />
                                </div> <!-- ./form-control serviceModel Excerpt -->

                                <div class="form-control">
                                    <div class="label">
                                        توضیح جامع‌ :
                                    </div>
                                    <q-editor v-model="serviceModel.content"
                                              ref="postContent"
                                              @input="validateInputs"
                                              min-height="20rem"/>
                                </div> <!-- ./form-control serviceModel Excerpt -->

                                <div class="form-control price"
                                     v-if="serviceModel.type === 'main'">
                                    <div class="label">هزینه سرویس</div>
                                    <q-input v-model="serviceModel.price"
                                             hint="اگر هزینه قابل عنوان کردن برای سرویس هست اینجا وارد کنید."
                                             outlined />
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="side-widgets sidebar">
                    <ServiceType v-model="serviceModel.type"
                                 @input="typeChange"
                                 v-if="!editing" />
                    <ServiceParentSelect v-model="serviceModel.parent_id"
                                         v-if="!editing" />
                    <ServiceColor v-model="color" />
                    <Thumbnail v-model="thumbnail"
                               square
                               @input="validateInputs"/>
                    <ServiceAddFeature v-model="serviceModel.features"
                                       @input="validateInputs"
                                       v-if="serviceModel.type === 'main'"/>
                    <div class="errors"
                         v-if="anyError">
                        <ul>
                            <template v-for="error in errors">
                                <li :key="error">
                                    <q-icon name="warning"
                                            size="1rem"/>
                                    {{ error }}
                                </li>
                            </template>
                        </ul>
                    </div>
                    <div class="submit">
                        <div class="submit-button">
                            <q-btn label="ثبت سرویس"
                                   unelevated
                                   v-if="!editing"
                                   :disable="anyError"
                                   @click="submitService"
                                   color="blue-9" />

                            <q-btn label="ثبت تغییرات"
                                   v-if="editing"
                                   unelevated
                                   :disable="anyError"
                                   color="blue-9" />
                        </div>
                    </div>
                    <div class="submit-success flex text-green-7 flex-center q-pa-md"
                         v-if="submitSuccess">
                        پست با موفقیت افزوده شد.
                    </div>
                </div>
            </div>
        </div>
    </q-page>
</template>

<script>

import Thumbnail from '@/components/widgets/Thumbnail'
import ServiceType from '@/components/services/serviceType'
import ServiceColor from '@/components/services/serviceColor'
import ServiceAddFeature from '@/components/services/addFeature'
import ServiceParentSelect from '@/components/services/serviceParentSelect'

export default {
    name: 'newService',
    components: {
        ServiceType, ServiceColor, Thumbnail, ServiceAddFeature, ServiceParentSelect
    },
    data () {
        return {
            allSet: false,
            serviceModel: {
                title: '',
                excerpt: '',
                parent_id: null,
                slug: '',
                price: null,
                content: '',
                featured: false,
                type: 'main',
                features: [],
                hardware: []
            },
            color: null,
            thumbnail: null,
            anyError: false,
            editing: false,
            submitSuccess: false,
            errors: [],
            extras: []
        }
    },
    beforeMount () {
        if (Object.keys(this.$route.params).length) {
            let id = this.$route.params.id
            this.$axios.post('/api/services/get-service/' + id)
                .then(res => {
                    this.editing = true
                    this.initUpdating(res.data)
                    this.allSet = true
                })
        } else {
            this.allSet = true
        }
    },
    methods: {
        submitService () {
            if (this.validateInputs()) {
                let data = {
                    title: this.serviceModel.title,
                    excerpt: this.serviceModel.excerpt,
                    slug: this.serviceModel.slug,
                    price: this.serviceModel.price,
                    content: this.serviceModel.content,
                    service_type: this.serviceModel.type,
                    parent_id: this.serviceModel.parent_id,
                    features: this.serviceModel.features,
                    hardware: this.serviceModel.hardware,
                    extra: this.extras,
                    thumbnail_id: this.thumbnail,
                    color_id: this.color
                }
                this.$axios.post('/api/services/add-new/service', data)
                    .then((res) => {
                        if (res.data.status === 'ok') { this.SubmitSuccess(res) } else {
                            this.SubmitFail(res)
                        }
                    })
            }
        },
        validateInputs () {
            this.anyError = false
            this.errors = []
            if (this.serviceModel.title.length < 10) {
                this.anyError = true
                this.errors.push('تعداد کاراکترها برای عنوان سرویس ناکافی است.')
            }
            if (this.serviceModel.slug.length < 10) {
                this.anyError = true
                this.errors.push('تعداد کاراکرها برای عنوان انگلیسی سرویس ناکافی است.')
            }
            if (this.serviceModel.excerpt.length < 25) {
                this.anyError = true
                this.errors.push('برای فیلد توضیح مختصر حداقل باید ۲۵ کاراکتر وارد کنید.')
            }
            if (this.serviceModel.content.length < 50) {
                this.anyError = true
                this.errors.push('برای فیلد توضسح جامع حداقل باید ۵۰ کاراکتر وارد کنید.')
            }
            if (this.thumbnail === null) {
                this.anyError = true
                this.errors.push('تصویر شاخص انتخاب نشده است.')
            }
            if (this.serviceModel.type === 'main' && this.serviceModel.features.length < 3) {
                this.anyError = true
                this.errors.push('حداقل سه مورد ویژگی باید وارد کنید.')
            }
            return !this.anyError
        },
        SubmitSuccess (response) {
            console.log(response)
            let service_id = response.data.data.id
            this.submitSuccess = true
            setTimeout(() => {
                this.$router.push(`/services/edit/${service_id}/`)
            }, 2000)
        },
        SubmitFail (response) {
            this.anyError = true
            this.errors.push(response.data.message)
        },
        typeChange () {
            this.serviceModel.features = []
            this.serviceModel.hardware = []
            this.serviceModel.extras = []
        },
        initUpdating (data) {
            this.serviceModel = {
                title: data.title,
                slug: data.slug,
                price: data.price,
                excerpt: data.excerpt,
                content: data.content,
                type: data.service_type,
                id: data.id,
                parent_id: data.parent_id,
                features: data.features,
                hardware: data.hardware
            }

            this.color = data.color_id
            this.thumbnail = {
                thumbnailId: data.thumbnail.id,
                previewImage: data.thumbnail.specs[0].relativepath
            }
            this.extras = data.extra
        },
        escapeWhitespace (event) {
            let value = event.target.value
            value = value.trim()
            value = value.replace(/\s/gi, '-')
            this.serviceModel.slug = value
        }
    },
    computed: {
    }
}
</script>

<style lang="scss">
</style>
