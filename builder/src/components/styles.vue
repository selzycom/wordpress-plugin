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
                                :value="values.fontSize"
                                @updateValue="updateFontSize"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <BoxField
                                :options="fontWeights"
                                :title="'Толщина:'"
                                :value="values.fontWeight"
                                @updateValue="updateFontWeight"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <BoxField
                                :title="'Цвет:'"
                                :type="'color'"
                                :value="values.color"
                                @updateValue="updateColor"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <BoxField
                                :options="lineHeights"
                                :title="'Интервал:'"
                                :value="values.lineHeight"
                                @updateValue="updateLineHeight"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <BoxField
                                :title="'Фон:'"
                                :type="'color'"
                                :value="values.backgroundColor"
                                @updateValue="updateBackgroundColor"
                            ></BoxField>
                        </v-col>
                        <v-col cols="12">
                            <v-row>
                                <v-col cols="12" sm="6">
                                    <IconRadioList
                                        :name="`text-align-${fieldId}`"
                                        :list="textAligns"
                                        :value="values.textAlign"
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
                                :paddings="values.padding"
                                :margins="values.margin"
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
        fieldId: {
            type: Number
        }
    },
    data() {
        return {}
    },
    methods: {
        updateFontSize(value) {
            this.$set(this.values, 'fontSize', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    fontSize: this.values.fontSize
                }
            })
        },
        updateFontWeight(value) {
            this.$set(this.values, 'fontWeight', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    fontWeight: this.values.fontWeight
                }
            })
        },
        updateColor(value) {
            this.$set(this.values, 'color', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    color: this.values.color
                }
            })
        },
        updateLineHeight(value) {
            this.$set(this.values, 'lineHeight', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    lineHeight: this.values.lineHeight
                }
            })
        },
        updateBackgroundColor(value) {
            this.$set(this.values, 'backgroundColor', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    backgroundColor: this.values.backgroundColor
                }
            })
        },
        updateTextAlign(value) {
            this.$set(this.values, 'textAlign', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    textAlign: this.values.textAlign
                }
            })
        },
        updatePadding(value) {
            this.$set(this.values, 'padding', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    padding: this.values.padding
                }
            })
        },
        updateMargin(value) {
            this.$set(this.values, 'margin', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    margin: this.values.margin
                }
            })
        },
        updateFontStyles(data) {
            const value = data.checked ? data.value : ''
            switch (data.name) {
                case 'text-transform':
                    this.$set(this.values, 'textTransformUppercase', value)
                    this.$store.dispatch('setStyleById', {
                        fieldId: this.fieldId,
                        styles: {
                            textTransformUppercase: this.values.textTransformUppercase
                        }
                    })
                    break
                case 'font-style':
                    this.$set(this.values, 'fontStyleItalic', value)
                    this.$store.dispatch('setStyleById', {
                        fieldId: this.fieldId,
                        styles: {
                            fontStyleItalic: this.values.fontStyleItalic
                        }
                    })
                    break
                case 'text-decoration':
                    this.$set(this.values, 'textDecorationUnderline', value)
                    this.$store.dispatch('setStyleById', {
                        fieldId: this.fieldId,
                        styles: {
                            textDecorationUnderline: this.values.textDecorationUnderline
                        }
                    })
                    break
            }
        },
        updateBorderWidth(value) {
            this.$set(this.values, 'borderWidth', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    borderWidth: this.values.borderWidth
                }
            })
        },
        updateBorderStyle(value) {
            this.$set(this.values, 'borderStyle', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    borderStyle: this.values.borderStyle
                }
            })
        },
        updateBorderColor(value) {
            this.$set(this.values, 'borderColor', value)
            this.$store.dispatch('setStyleById', {
                fieldId: this.fieldId,
                styles: {
                    borderColor: this.values.borderColor
                }
            })
        },
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
        values() {
            const stylesByFieldId = this.$store.getters.styles.filter(item => item.fieldId === this.fieldId)[0]
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
            return stylesByFieldId ? stylesByFieldId.styles : defaultStyles
        },
        borderValues() {
            return {
                borderWidth: this.values.borderWidth,
                borderStyle: this.values.borderStyle,
                borderColor: this.values.borderColor
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