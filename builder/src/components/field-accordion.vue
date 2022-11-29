<template>
    <div class="b-accordion" :class="data.status ? 'active' : ''">
        <div class="b-accordion__header" ref="header" @mouseleave="confirm = false">
            <v-row>
                <v-col cols="2" align-self="center" :name="isDraggable ? 'draggable' : ''">
                    <div class="b-circle-counter">
                        {{ index + 1 }}
                    </div>
                </v-col>
                <v-col cols="4">
                    <div class="b-table-colm-title b-table-colm-title_primary" @click="toggleAccordion">
                        {{ data.title ? data.title : '(нет заголовка)'  }}
                    </div>
                    <div class="b-field-actions">
                        <div class="b-field-actions__item" @click="toggleAccordion">
                            Редактировать
                        </div>
                        <div class="b-field-actions__item" v-if="data.id !== 2" @click="duplicateAccordion">
                            Дублировать
                        </div>
                        <div class="b-field-actions__item" v-if="data.id !== 2">
                            <span @click="confirm = true">Удалить</span>
                            <div class="b-confirm" :class="confirm ? 'active' : ''">
                                <div class="b-confirm__item">Вы уверены?</div>
                                <a class="b-confirm__item b-confirm__item_red" @click="removeAccordion">Убрать</a>
                                <a class="b-confirm__item b-confirm__item_gray" @click="confirm = false">Отмена</a>
                            </div>
                        </div>
                    </div>
                </v-col>
                <v-col cols="4">
                    <div class="b-table-colm-title">
                        {{ data.slug }}
                    </div>
                </v-col>
                <v-col cols="2">
                    <div class="b-table-colm-title">
                        {{ type }}
                    </div>
                </v-col>
            </v-row>
        </div>
        <div class="b-accordion__main">
            <v-row>
                <v-col cols="12" md="6">
                    <Field
                        :title="'Заголовок поля'"
                        :value="data.title"
                        :change="true"
                        @updateValue="changeName"
                    ></Field>
                </v-col>
                <v-col cols="12" md="6">
                    <Field
                        v-if="data.type === 2 || data.type === 3"
                        :title="'Переменная дополнительного поля в Unisender'"
                        :hint="tooltips.slug"
                        :value="data.slug"
                        :disabled="data.id === 1 || data.id === 2 || data.type === 3"
                        @updateValue="changeSlug"
                    ></Field>
                    <Select
                        v-if="data.type !== 2 && data.type !== 3"
                        :title="'Переменная дополнительного поля в Unisender'"
                        :hint="tooltips.slug"
                        :value="data.slug"
                        :isDouble="true"
                        :options="unisenderAdditionalFields"
                        @updateValue="changeSlug"
                    ></Select>
                    <a v-if="data.type !== 2" href="https://cp.selzy.com/ua/v5/contacts/additional-fields" target="_blank" class="b-link" style="display: inline-block; margin-top: 10px;">Перейти в настройки дополнительных полей Sezly</a>
                    <div v-if="data.type === 2" class="b-text b-text_gray" style="margin-top: 10px;">Email является обязательным полем при отправке формы на платформу Selzy</div>
                </v-col>
                <v-col cols="12" md="6">
                    <v-row>
                        <v-col cols="12" v-if="data.type === 6">
                            <Field
                                :title="'Варианты'"
                                :hint="tooltips.options"
                                :type="'textarea'"
                                :value="options"
                                @updateValue="changeSelectVariants"
                            ></Field>
                        </v-col>
                        <v-col cols="12" v-if="data.type === 8">
                            <Select
                                :title="'Формат даты'"
                                :hint="tooltips.dateFormat"
                                :value="dateType"
                                :options="['dd.mm.yyyy', 'dd/mm/yyyy', 'mm.dd.yyyy', 'mm/dd/yyyy']"
                                @updateValue="changeDateType"
                            ></Select>
                        </v-col>
                        <v-col cols="12">
                            <Validation :type-id="data.type" :fieldId="data.id"></Validation>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" md="6">
                    <Styles :fieldId="data.id"></Styles>
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script>
import Field from "@/components/field";
import Select from "@/components/select";
import Styles from "@/components/styles";
import Validation from '@/components/validation'
// import Transliterate from "@/helpers/Transliterate";

export default {
    components: {
        Field,
        Validation,
        Styles,
        Select
    },
    props: {
        index: {
            type: Number,
            required: true
        },
        data: {
            type: Object,
            required: true
        },
        type: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            confirm: false,
            selectVariants: null,
            selectDateType: null
        }
    },
    methods: {
        toggleAccordion() {
            this.confirm = false
            this.status = !this.status
            this.$store.dispatch('editAccordion', {
                id: this.data.id,
                data: {
                    status: !this.data.status
                }
            })
        },
        duplicateAccordion() {
            this.confirm = false
            this.$store.dispatch('duplicateAccordion', this.index)
        },
        removeAccordion() {
            this.confirm = false
            this.$store.dispatch('removeAccordion', this.index)
        },
        //handlers
        changeName(value) {
            const data = {
                id: this.data.id,
                data: {
                    title: value
                }
            }

            // if (this.data.slug === null) {
            //     data.data.slug = Transliterate.get(value, false).toLowerCase()
            // }

            this.$store.dispatch('editAccordion', data)
        },
        changeSlug(value) {
            this.$store.dispatch('editAccordion', {
                id: this.data.id,
                data: {
                    slug: value
                }
            })
        },
        changeSelectVariants(value) {
            this.selectVariants = value
            const options = value.split('\n')
            this.$store.dispatch('editAccordion', {
                id: this.data.id,
                data: {
                    options
                }
            })
        },
        changeDateType(value) {
            this.$store.dispatch('editAccordion', {
                id: this.data.id,
                data: {
                    dateType: value
                }
            })
        }
    },
    computed: {
        isDraggable() {
            return /*(!(this.data.type === 1 || this.data.type === 2))*/ true
        },
        options() {
            return this.data.options ? this.data.options.join('\n') : null
        },
        dateType() {
            return this.data.dateType ? this.data.dateType : null
        },
        unisenderAdditionalFields() {
            return this.$store.getters.additionalFields
        },
        tooltips() {
            return this.$store.getters.tooltips
        }
    }
}
</script>