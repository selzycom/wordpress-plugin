export default {
    state: {
        additionalFields: [
            {
                key: 'Не задано (не будет отправленно в Unisender)',
                value: null
            }
        ]
    },
    mutations: {
        setAdditionalFields(state, payload) {
            const data = JSON.parse(payload)
            data.forEach(item => {
                state.additionalFields.push({
                    key: item.name,
                    value: item.name
                })
            })
        }
    },
    actions: {
        setAdditionalFields({commit}, payload) {
            commit('setAdditionalFields', payload)
        }
    },
    getters: {
        additionalFields(state) {
            return state.additionalFields
        }
    },
}