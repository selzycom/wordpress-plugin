<template>
    <div>
        <v-row>
            <v-col cols="12">
                <div class="b-label-title">
                    Валидация
                </div>
                <Checkbox
                    :label="'Обязательное поле'"
                    :value="rules.required"
                    @updateValue="changeRequired"
                    :disabled="typeId === 1 || typeId === 2"
                ></Checkbox>
            </v-col>
            <v-col cols="12" v-if="showMinNumber">
                <Field
                    :title="'Минимум'"
                    :value="rules.minNumber"
                    :min="0"
                    :type="'number'"
                    @updateValue="changeMinNumber"
                ></Field>
            </v-col>
            <v-col cols="12" v-if="showMaxNumber">
                <Field
                    :title="'Максимум'"
                    :value="rules.maxNumber"
                    :type="'number'"
                    @updateValue="changeMaxNumber"
                ></Field>
            </v-col>
            <v-col cols="12" v-if="showMinLength">
                <Field
                    :title="'Минимальная длина'"
                    :value="rules.minLength"
                    :min="0"
                    :type="'number'"
                    @updateValue="changeMinLength"
                ></Field>
            </v-col>
            <v-col cols="12" v-if="showMaxLength">
                <Field
                    :title="'Максимальная длина'"
                    :value="rules.maxLength"
                    :type="'number'"
                    @updateValue="changeMaxLength"
                ></Field>
            </v-col>
            <v-col cols="12" v-if="showRegEXp">
                <Field
                    :title="'Регулярное выражение'"
                    :value="rules.regExp"
                    @updateValue="changeRegExp"
                ></Field>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import Field from "@/components/field";
import Checkbox from "@/components/checkbox";

export default {
    components: {
        Field,
        Checkbox
    },
    props: {
        typeId: {
            type: Number,
            required: true
        },
        fieldId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            // rules: {
            //     minLength: null,
            //     maxLength: null,
            //     minNumber: null,
            //     maxNumber: null,
            //     regExp: null,
            //     required: null
            // }
        }
    },
    created() {
        if (this.typeId === 1 || this.typeId === 2) {
            this.changeRequired(true)
        }
    },
    methods: {
        changeMinLength(value) {
            this.$set(this.rules, 'minLength', value)
            this.$store.dispatch('setValidationByFieldId', {
                fieldId: this.fieldId,
                validationRules: {
                    minLength: this.rules.minLength
                }
            })
        },
        changeMaxLength(value) {
            this.$set(this.rules, 'maxLength', value)
            this.$store.dispatch('setValidationByFieldId', {
                fieldId: this.fieldId,
                validationRules: {
                    maxLength: this.rules.maxLength
                }
            })
        },
        changeMinNumber(value) {
            this.$set(this.rules, 'minNumber', value)
            this.$store.dispatch('setValidationByFieldId', {
                fieldId: this.fieldId,
                validationRules: {
                    minNumber: this.rules.minNumber
                }
            })
        },
        changeMaxNumber(value) {
            this.$set(this.rules, 'maxNumber', value)
            this.$store.dispatch('setValidationByFieldId', {
                fieldId: this.fieldId,
                validationRules: {
                    maxNumber: this.rules.maxNumber
                }
            })
        },
        changeRegExp(value) {
            this.$set(this.rules, 'regExp', value)
            this.$store.dispatch('setValidationByFieldId', {
                fieldId: this.fieldId,
                validationRules: {
                    regExp: this.rules.regExp
                }
            })
        },
        changeRequired(value) {
            this.$set(this.rules, 'required', value)
            this.$store.dispatch('setValidationByFieldId', {
                fieldId: this.fieldId,
                validationRules: {
                    required: this.rules.required
                }
            })
        }
    },
    computed: {
        types() {
            return this.$store.getters.types
        },
        rules() {
            const fieldValidationById = this.$store.getters.validations.filter(item => item.fieldId === this.fieldId)[0]
            const defaultFiledValidation = {
                minLength: null,
                maxLength: null,
                minNumber: null,
                maxNumber: null,
                regExp: null,
                required: null
            }
            return fieldValidationById ? fieldValidationById.rules : defaultFiledValidation
        },
        showMinNumber() {
            return this.typeId === 5
        },
        showMaxNumber() {
            return this.typeId === 5
        },
        showMinLength() {
            return this.typeId === 1 || this.typeId === 4
        },
        showMaxLength() {
            return this.typeId === 1 || this.typeId === 4
        },
        showRegEXp() {
            return /*this.typeId === 1 || this.typeId === 4 || this.typeId === 5*/ false
        },
    }
}
</script>