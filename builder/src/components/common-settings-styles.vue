<template>
    <v-row>
        <v-col cols="12">
            <div class="b-label-title">
                Оформление
            </div>
            <v-row>
                <v-col cols="12" lg="6">
                    <v-row>
                        <v-col cols="12" sm="6">
                            <BoxField
                                :options="fontSizes"
                                :title="'Размер:'"
                                :value="values().fontSize"
                                @updateValue="updateFontSize"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <BoxField
                                :options="fontWeights"
                                :title="'Толщина:'"
                                :value="values().fontWeight"
                                @updateValue="updateFontWeight"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <BoxField
                                :title="'Цвет:'"
                                :type="'color'"
                                :value="values().color"
                                @updateValue="updateColor"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <BoxField
                                :options="lineHeights"
                                :title="'Интервал:'"
                                :value="values().lineHeight"
                                @updateValue="updateLineHeight"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <BoxField
                                :title="'Фон:'"
                                :type="'color'"
                                :value="values().backgroundColor"
                                @updateValue="updateBackgroundColor"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12">
                            <v-row>
                                <v-col cols="12" sm="6">
                                    <IconRadioList
                                        :name="`text-align-${type}`"
                                        :list="textAligns"
                                        :value="values().textAlign"
                                        @updateValue="updateTextAlign"
                                    ></IconRadioList>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <IconCheckboxList
                                        :list="fontStyles"
                                        :value="fontStylesValue"
                                        @updateValue="updateFontStyles"
                                    ></IconCheckboxList>
                                </v-col>
                                <v-col cols="12">
                                    <BorderField
                                        :title="'Рамка:'"
                                        :value="borderValues"
                                        @updateWidthValue="updateBorderWidth"
                                        @updateStyleValue="updateBorderStyle"
                                        @updateColorValue="updateBorderColor"
                                    ></BorderField>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" lg="6">
                    <v-row>
                        <v-col>
                            <div class="b-label-title">
                                Отступы
                            </div>
                            <Offsets
                                :paddings="values().padding"
                                :margins="values().margin"
                                @updatePadding="updatePadding"
                                @updateMargin="updateMargin"
                            ></Offsets>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
import BoxField from '@/components/box-field'
import IconRadioList from '@/components/icon-radio-list'
import IconCheckboxList from '@/components/icon-checkbox-list'
import Offsets from '@/components/offsets'
import BorderField from '@/components/border-field'

export default {
    components: {
        BoxField,
        IconRadioList,
        IconCheckboxList,
        Offsets,
        BorderField
    },
    props: {
        type: {
            type: String
        }
    },
    data() {
        return {}
    },
    methods: {
        updateFontSize(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    fontSize: value
                }
            })
        },
        updateFontWeight(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    fontWeight: value
                }
            })
        },
        updateColor(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    color: value
                }
            })
        },
        updateLineHeight(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    lineHeight: value
                }
            })
        },
        updateBackgroundColor(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    backgroundColor: value
                }
            })
        },
        updateTextAlign(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    textAlign: value
                }
            })
        },
        updatePadding(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    padding: value
                }
            })
        },
        updateMargin(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    margin: value
                }
            })
        },
        updateFontStyles(data) {
            const value = data.checked ? data.value : ''
            switch (data.name) {
                case 'text-transform':
                    this.$store.dispatch('editCommonSettingsStyleByType', {
                        type: this.type,
                        styles: {
                            textTransformUppercase: value
                        }
                    })
                    break
                case 'font-style':
                    this.$store.dispatch('editCommonSettingsStyleByType', {
                        type: this.type,
                        styles: {
                            fontStyleItalic: value
                        }
                    })
                    break
                case 'text-decoration':
                    this.$store.dispatch('editCommonSettingsStyleByType', {
                        type: this.type,
                        styles: {
                            textDecorationUnderline: value
                        }
                    })
                    break
            }
        },
        updateBorderWidth(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    borderWidth: value
                }
            })
        },
        updateBorderStyle(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    borderStyle: value
                }
            })
        },
        updateBorderColor(value) {
            this.$store.dispatch('editCommonSettingsStyleByType', {
                type: this.type,
                styles: {
                    borderColor: value
                }
            })
        },
        //
        values() {
            const commonSettings = this.$store.getters.commonSettings
            const defaultStyles = {
                fontSize: null,
                fontWeight: null,
                color: null,
                lineHeight: null,
                backgroundColor: null,
                textAlign: null,
                textDecorationUnderline: false,
                fontStyleItalic: false,
                textTransformUppercase: false,
                borderWidth: null,
                borderStyle: null,
                borderColor: null,
                padding: null,
                margin: null,
            }
            let currentStyles = null
            switch (this.type) {
                case 'title':
                    currentStyles = commonSettings.form.title.styles
                    break
                case 'description':
                    currentStyles = commonSettings.form.description.styles
                    break
                case 'form':
                    currentStyles = commonSettings.form.styles
                    break
                case 'button':
                    currentStyles = commonSettings.form.button.styles
                    break
            }
            return currentStyles ? currentStyles : defaultStyles
        }
    },
    computed: {
        fontSizes() {
            return this.$store.getters.fontSizes
        },
        fontWeights() {
            return this.$store.getters.fontWeights
        },
        lineHeights() {
            return this.$store.getters.lineHeights
        },
        textAligns() {
            return this.$store.getters.textAligns
        },
        fontStyles() {
            return this.$store.getters.fontStyles
        },
        borderValues() {
            return {
                borderWidth: this.values().borderWidth,
                borderStyle: this.values().borderStyle,
                borderColor: this.values().borderColor
            }
        },
        fontStylesValue() {
            return {
                textDecorationUnderline: this.values.textDecorationUnderline,
                fontStyleItalic: this.values.fontStyleItalic,
                textTransformUppercase: this.values.textTransformUppercase,
            }
        }
    }
}
</script>