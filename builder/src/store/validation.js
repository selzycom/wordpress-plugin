import Validation from "@/helpers/Validation";
export default {
    state: {
        validations: []
    },
    mutations: {
        setValidationByFieldId(state, {fieldId, validationRules}) {
            let searchedItem = state.validations.filter(item => item.fieldId === fieldId)[0]
            if (searchedItem) {
                searchedItem = {
                    fieldId,
                    rules: searchedItem.rules.setNew(validationRules)
                }
            } else {
                state.validations.push({
                    fieldId,
                    rules: new Validation(validationRules)
                })
            }
        },
        setValidations(state, validations) {
            state.validations = validations
        },
        removeValidationByFieldId(state, fieldId) {
            state.validations.forEach((item, index) => {
                if (item.fieldId === fieldId) {
                    state.styles.splice(index, 1)
                }
            })
        }
    },
    actions: {
        setValidationByFieldId({commit}, {fieldId, validationRules}) {
            commit('setValidationByFieldId', {fieldId, validationRules})
            commit('setFieldsData')
        },
        setValidations({commit}, validations) {
            commit('setValidations', validations)
        },
        removeValidationByFieldId({commit}, fieldId) {
            commit('removeValidationByFieldId', fieldId)
        }
    },
    getters: {
        validations(state) {
            return state.validations
        }
    }
}