import Styles from '@/helpers/Styles'
export default {
    state: {
        styles: []
    },
    mutations: {
        setStyleById(state, {fieldId, styles}) {
            let searchedItem = state.styles.filter(item => item.fieldId === fieldId)[0]
            if (searchedItem) {
                searchedItem = {
                    fieldId,
                    styles: searchedItem.styles.setNew(styles)
                }
            } else {
                state.styles.push({
                    fieldId,
                    styles: new Styles(styles)
                })
            }
        },
        setStyles(state, styles) {
            state.styles = styles
        },
        removeStyleByFieldId(state, fieldId) {
            state.styles.forEach((item, index) => {
                if (item.fieldId === fieldId) {
                    state.styles.splice(index, 1)
                }
            })
        }
    },
    actions: {
        setStyleById({commit}, {fieldId, styles}) {
            commit('setStyleById', {fieldId, styles})
            commit('setFieldsData')
        },
        setStyles({commit}, styles) {
            commit('setStyles', styles)
        },
        removeStyleByFieldId({commit}, fieldId) {
            commit('removeStyleByFieldId', fieldId)
        }
    },
    getters: {
        styles(state) {
            return state.styles
        }
    }
}