<template>
    <v-app>
        <div class="b-unisender-app">
            <div class="b-unisender-app__inner">
                <div class="b-unisender-app__block">
                    <div class="b-unisender-app__title">
                        Общие настройки
                    </div>
                    <CommonSettings></CommonSettings>
                </div>
                <div class="b-unisender-app__block">
                    <div class="b-unisender-app__title">
                        Поля
                    </div>
                    <App></App>
                </div>
            </div>
        </div>
    </v-app>
</template>

<script>
import App from '@/views/app'
import CommonSettings from '@/views/common-settings'

export default {
    components: {
        App,
        CommonSettings
    },
    data() {
        return {
            unisenderHiddenField: document.querySelector('[data-unisender-hidden-field]'),
            unisenderHiddenFieldStartValue: null,
            unisenderAdditionalFields: null

        }
    },
    created() {
        // eslint-disable-next-line no-undef
        if (typeof UNISENDER_ADDITIONAL_FIELDS !== 'undefined') {
            // eslint-disable-next-line no-undef
            this.unisenderAdditionalFields = UNISENDER_ADDITIONAL_FIELDS
            this.$store.dispatch('setAdditionalFields', this.unisenderAdditionalFields)
        }
        if (this.unisenderHiddenField) {
            this.unisenderHiddenFieldStartValue = this.unisenderHiddenField.getAttribute('value')

            if (this.unisenderHiddenFieldStartValue) {
                this.$store.dispatch('setStartData', this.unisenderHiddenFieldStartValue)
            } else {
                this.$store.dispatch('initAccordions')
                this.$store.dispatch('setDefaultCommonSettingsStyles')
            }
        }
    },
    methods: {},
    computed: {
        data() {
            return this.$store.getters.data
        }
    },
    watch: {
        data: {
            deep: true,
            handler() {
                if (this.unisenderHiddenField) {
                    this.unisenderHiddenField.setAttribute('value', JSON.stringify(this.data))
                }
            }
        }
    }
}
</script>
