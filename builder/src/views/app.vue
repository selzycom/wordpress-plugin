<template>
    <div class="b-unisender-app__wrap">
        <div class="b-unisender-app__header">
            <v-row>
                <v-col cols="2">
                    <div class="b-table-colm-title">
                        <strong>
                            Позиция
                        </strong>
                    </div>
                </v-col>
                <v-col cols="4">
                    <div class="b-table-colm-title">
                        <strong>
                            Заголовок
                        </strong>
                    </div>
                </v-col>
                <v-col cols="4">
                    <div class="b-table-colm-title">
                        <strong>
                            Переменная дополнительного поля в Unisender
                        </strong>
                    </div>
                </v-col>
                <v-col cols="2">
                    <div class="b-table-colm-title">
                        <strong>
                            Тип
                        </strong>
                    </div>
                </v-col>
            </v-row>
        </div>
        <div class="b-unisender-app__main">
            <div class="b-unisender-app__accordions">
                <draggable
                    v-model="items"
                    handle="[name=draggable]"
                >
                    <FieldAccordion class="b-unisender-app__accordion"
                                    v-for="(item, index) in items"
                                    :key="`accordion-${index}`"
                                    :index="index"
                                    :data="item"
                                    :type="getTypeNameById(item.type)"
                    >
                    </FieldAccordion>
                </draggable>
            </div>
        </div>
        <div class="b-unisender-app__footer">
            <v-row justify="end">
                <v-col cols="12" align="right">
                    <div class="b-unisender-app__button-container">
                        <div class="b-types-list b-unisender-app__types"
                             :class="typesContainerShow ? 'active' : ''"
                        >
                            <div class="b-types-list__item"
                                 :class="item.id === 3 && isPhoneSet ? 'disabled' : ''"
                                 v-for="item in typesWithoutNameAndEmail"
                                 :key="`type-${item.id}`"
                                 :id="item.id"
                                 @click="addAccordion(item.id)"
                            >
                                <Tooltip v-if="item.id === 3 && isPhoneSet">
                                    <div slot="content" class="b-content" v-html="`<p style='white-space: nowrap'>Поле типа 'Номер телефона' уже существует.</p> <p>Вы можете добавить только одно поле данного типа в эту форму.</p>`"></div>
                                </Tooltip>
                                {{ item.name }}
                            </div>
                        </div>
                        <v-btn depressed color="primary" @click="toggleTypesContainer">
                            + Добавить поле
                        </v-btn>
                    </div>
                </v-col>
            </v-row>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import FieldAccordion from '@/components/field-accordion.vue'
import Tooltip from '@/components/tooltip'

export default {
    components: {
        FieldAccordion,
        draggable,
        Tooltip
    },
    data() {
        return {
            typesContainerShow: false
        }
    },

    methods: {
        toggleTypesContainer() {
            this.typesContainerShow = !this.typesContainerShow
        },
        addAccordion(id) {
            if (id === 3 && this.isPhoneSet) return false
            this.typesContainerShow = false
            this.$store.dispatch('addAccordion', id)
        },
        getTypeNameById(id) {
            return this.types.filter(type => type.id === id)[0]?.name
        }
    },
    computed: {
        items: {
            get: function () {
                return this.$store.getters.accordions
            },
            set: function (newList) {
                this.$store.dispatch('updateAccordions', newList)
            }
        },
        types() {
            return this.$store.getters.types
        },
        typesWithoutNameAndEmail() {
            return this.types.filter(item => item.id !== 1 && item.id !== 2)
        },
        isPhoneSet() {
            return this.items.some(item => item.type === 3)
        }
    }
}
</script>