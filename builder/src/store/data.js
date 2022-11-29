import DataItem from "@/helpers/DataItem";
import Validation from "@/helpers/Validation";
import Styles from "@/helpers/Styles";
export default {
    state: {
        data: {
            fields: [],
            commonSettings: {}
        }
    },
    mutations: {
        setFieldsData(state) {
            state.data.fields = []

            this.getters.accordions.forEach(accordion => {
                const item = new DataItem()
                item.setField(accordion)
                state.data.fields.push(item)
            })

            this.getters.styles.forEach(style => {
                const searchedItem = state.data.fields.filter(item => item.field.id === style.fieldId)[0]
                if (searchedItem) {
                    searchedItem.setStyles(style.styles)
                }
            })

            this.getters.validations.forEach(validation => {
                const searchedItem = state.data.fields.filter(item => item.field.id === validation.fieldId)[0]
                if (searchedItem) {
                    searchedItem.setValidations(validation.rules)
                }
            })
        },
        setStartData(state, data) {
            state.data = data
        },
        setCommonSettingsData(state) {
            state.data.commonSettings = this.getters.commonSettings
        }
    },
    actions: {
        setFieldsData({commit}) {
            commit('setFieldsData')
        },
        // eslint-disable-next-line no-unused-vars
        setStartData({commit}, data) {
            const uploadedData = JSON.parse(data)

            // clear accordions
            for (let i = this.getters.accordions.length - 1; i >= 0; i--) {
                commit('removeAccordion', i)
            }

            // set accordions
            const allFields = uploadedData.fields.map(item => item.field)
            commit('setAccordions', allFields)

            // set styles
            const allStyles = uploadedData.fields.map(item => ({
                fieldId: item.field.id,
                styles: new Styles(item.styles)
            }))
            commit('setStyles', allStyles)

            // set validations
            const allValidations = uploadedData.fields.map(item => ({
                fieldId: item.field.id,
                rules: new Validation(item.validations)
            }))
            commit('setValidations', allValidations)

            // set common settings
            commit('setCommonSettings', uploadedData.commonSettings)

            // set data
            commit('setStartData', uploadedData)
        },
        setCommonSettingsData({commit}) {
            commit('setCommonSettingsData')
        }
    },
    getters: {
        data(state) {
            return state.data
        }
    }
}