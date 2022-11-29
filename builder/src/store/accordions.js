export default {
    state: {
        accordions: [
            // {
            //     id: 1,
            //     title: 'Твое имя',
            //     slug: 'first_name',
            //     type: 1,
            //     status: false
            // },
            // {
            //     id: 2,
            //     title: 'Email',
            //     slug: 'email',
            //     type: 2,
            //     status: false,
            // },
        ]
    },
    mutations: {
        removeAccordion(state, index) {
            state.accordions.splice(index, 1)
        },
        duplicateAccordion(state, index) {
            const allIds = state.accordions.map(item => item.id)
            const maxId = Math.max(...allIds)
            const newId = maxId + 1

            const copyElement = {
                id: newId,
                title: `${state.accordions[index].title} (copy)`,
                slug: `${state.accordions[index].slug}_copy`,
                type: state.accordions[index].type,
                status: true
            }
            state.accordions.splice(index + 1, 0, copyElement)
        },
        editAccordion(state, {id, data}) {
            let searchedItem = state.accordions.filter(item => item.id === id)?.[0]
            if (searchedItem) {
                for (let key in data) {
                    searchedItem[key] = data[key]
                }
            }
        },
        addAccordion(state, {typeId, id}) {
            const data = {
                title: null,
                slug: null,
                type: typeId,
                status: true,
                id: id
            }
            if (typeId === 3) {
                data.slug = 'phone'
            }
            if (typeId === 8) {
                data.dateType = 'dd.mm.yyyy'
            }
            if (state.accordions.some(item => item.type === 3) && typeId === 3 ) return false
            state.accordions.push(data)
        },
        setAccordions(state, accordions) {
          state.accordions = accordions
        },
        updateAccordions(state, list) {
            state.accordions = list
        },
        initAccordions(state) {
            state.accordions.push({
                id: 1,
                title: 'Твое имя',
                slug: 'Name',
                type: 1,
                status: false
            })
            state.accordions.push({
                id: 2,
                title: 'Email',
                slug: 'email',
                type: 2,
                status: false,
            })
        }
    },
    actions: {
        removeAccordion({commit}, index) {
            const id = this.getters.accordions[index].id
            commit('removeValidationByFieldId', id)
            commit('removeStyleByFieldId', id)
            commit('removeAccordion', index)
            commit('setFieldsData')
        },
        duplicateAccordion({commit}, index) {
            commit('duplicateAccordion', index)
            commit('setFieldsData')
        },
        editAccordion({commit}, {id, data}) {
            commit('editAccordion', {id, data})
            commit('setFieldsData')
        },
        addAccordion({commit, state}, typeId) {
            const allIds = state.accordions.map(item => item.id)
            const maxId = Math.max(...allIds)
            const newId = maxId + 1
            commit('addAccordion', {typeId, id: newId})
            commit('setStyleById', {
                fieldId: newId,
                styles: {}
            })
            commit('setFieldsData')
        },
        setAccordions({commit}, accordions) {
            commit('setAccordions', accordions)
        },
        updateAccordions({commit}, list) {
            commit('updateAccordions', list)
            commit('setFieldsData')
        },
        initAccordions({commit}) {
            commit('initAccordions')
            commit('setStyleById', {
                fieldId: 1,
                styles: {}
            })
            commit('setStyleById', {
                fieldId: 2,
                styles: {}
            })
            commit('setFieldsData')
        }
    },
    getters: {
        accordions(state) {
            return state.accordions
        }
    }
}