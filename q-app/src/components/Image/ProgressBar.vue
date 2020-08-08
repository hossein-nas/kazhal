<template>
    <div class="progressbar non-selectable"
         v-show="this.visibility">
        <div class="flex flex-center">
            <span class="progressbar__text"
                  v-if="!done">
                <span class="text">
                    در حال آپلود
                </span>
                <span class="percentage">
                    {{this.progressText}}
                </span>
            </span>

            <span class="progressbar__text"
                  v-else>
                <q-icon name="verified"
                        class="text-teal-6 q-mr-sm"
                        size="1rem" />
                <span class="text text-teal-6"
                      v-text="doneText">
                </span>
            </span>

            <div class="flex full-width">

                <q-linear-progress size=".3rem"
                                   :value="progress"
                                   color="teal-3">
                </q-linear-progress>
            </div><!-- /.flex full-width -->
        </div><!-- /.flex flex-center -->

    </div><!-- /.progressbar -->
</template>

<script>

export default {
    name: 'ProgreeBar',

    props: {
        value: {
            required: true,
            type: Number
        },
        start: {
            type: Boolean,
            default: false
        },
        visibility: {
            type: Boolean,
            default: true
        }
    },

    data () {
        return {
            progress: this.value / 100
        }
    },

    computed: {
        progressText () {
            return ['%', this.value].join(' ')
        },

        done () {
            return this.value == 100
        },

        doneText () {
            return 'آپلود انجام شد.'
        }
    }
}
</script>

<style lang="scss">
.progressbar__text{
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 3rem;
    margin-bottom: .25rem;

    span.text{
        font-size: .95rem;
        color: $grey-8;
    }

    span.percentage{
        background-color: $grey-3;
        display: inline-block;
        padding: .125rem .5rem;
        border-radius: .25rem;
        font-size: 1rem;
        color: $brown-4;
        font-weight: bold;
        margin-right: .75rem #{"/* rtl:ignore */"};
    }
}
</style>
