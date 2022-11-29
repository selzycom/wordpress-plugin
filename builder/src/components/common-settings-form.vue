<template>
    <v-row>
        <v-col cols="12">
            <v-row :align="showTitleStyle ? 'start' : 'end'">
                <v-col cols="12" md="6">
                    <Field
                        :title="'Заголовок формы'"
                        :value="title.value"
                        @updateValue="updateTitle"
                    ></Field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-row>
                        <v-col cols="12">
                            <span class="b-link"
                                  @click="showTitleStyle = !showTitleStyle"
                            >
                                Настройка оформления
                            </span>
                        </v-col>
                        <v-col cols="12"
                               v-if="showTitleStyle"
                               :class="'unisenderFadeIn'"
                        >
                            <CommonSettingsStyles
                                :type="'title'"
                            ></CommonSettingsStyles>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
        <v-col cols="12">
            <v-row :align="showDescriptionStyle ? 'start' : 'end'">
                <v-col cols="12" md="6">
                    <Field
                        :title="'Описание формы'"
                        :value="description.value"
                        :type="'textarea'"
                        @updateValue="updateDescription"
                    ></Field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-row>
                        <v-col cols="12">
                            <span class="b-link"
                                  @click="showDescriptionStyle = !showDescriptionStyle"
                            >
                                Настройка оформления
                            </span>
                        </v-col>
                        <v-col cols="12"
                               v-if="showDescriptionStyle"
                               :class="'unisenderFadeIn'"
                        >
                            <CommonSettingsStyles
                                :type="'description'"
                            ></CommonSettingsStyles>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
        <v-col cols="12">
            <div class="b-label-title">
                Оформление формы
            </div>
            <v-row>
                <v-col cols="12">
                    <v-row>
                        <v-col cols="6">
                            <span class="b-link"
                                  @click="showFormStyle = !showFormStyle"
                            >
                                Настройка оформления
                            </span>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12"
                       v-if="showFormStyle"
                       :class="'unisenderFadeIn'"
                >
                    <v-row>
                        <v-col cols="6">
                            <CommonSettingsStyles
                                :type="'form'"
                            ></CommonSettingsStyles>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
        <v-col cols="12">
            <v-row :align="showButtonStyle ? 'start' : 'end'">
                <v-col cols="12" md="6">
                    <Field
                        :title="'Текст кнопки'"
                        :value="button.value"
                        @updateValue="updateButton"
                    ></Field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-row>
                        <v-col cols="12">
                            <span class="b-link"
                                  @click="showButtonStyle = !showButtonStyle"
                            >
                                Настройка оформления
                            </span>
                        </v-col>
                        <v-col cols="12"
                               v-if="showButtonStyle"
                               :class="'unisenderFadeIn'"
                        >
                            <CommonSettingsStyles
                                :type="'button'"
                            ></CommonSettingsStyles>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
import Field from '@/components/field'
import CommonSettingsStyles from '@/components/common-settings-styles'
export default {
    components: {
        Field,
        CommonSettingsStyles
    },
    data() {
        return {
            showTitleStyle: false,
            showDescriptionStyle: false,
            showFormStyle: false,
            showButtonStyle: false
        }
    },
    methods: {
        updateTitle(value) {
            this.$store.dispatch('editCommonSettingsTitleValue', value)
        },
        updateDescription(value) {
            this.$store.dispatch('editCommonSettingsDescriptionValue', value)
        },
        updateButton(value) {
            this.$store.dispatch('editCommonSettingsButtonValue', value)
        }
    },
    computed: {
        title() {
            return this.$store.getters.commonSettingsFormTitle
        },
        description() {
            return this.$store.getters.commonSettingsFormDescription
        },
        button() {
            return this.$store.getters.commonSettingsFormButton
        },
    }
}
</script>