export default {
    state: {
        commonSettings: {
            form: {
                title: {
                    value: null,
                    styles: {}
                },
                description: {
                    value: null,
                    styles: {}
                },
                button: {
                    value: 'Подписаться',
                    styles: {}
                },
                styles: {}
            },
            messages: {
                successText: 'Спасибо за подписку.',
                validationErrorText: 'Одно или несколько полей содержат ошибку. Пожалуйста проверьте и попробуйте снова.',
                serverErrorText: 'При отправке запроса произошла ошибка. Пожалуйста, попробуйте позже.',
                minLengthErrorText: 'Поле слишком короткое.',
                maxLengthErrorText: 'Поле слишком длинное.',
                minNumberErrorText: 'Число меньше допустимого минимума.',
                maxNumberErrorText: 'Число превышает максимально допустимое.',
                regExpErrorText: '',
                requiredErrorText: 'Поле обязательно для заполнения.',
                emailErrorText: 'Введенный адрес электронной почты недействителен.'
            }
        }
    },
    mutations: {
        editCommonSettingsMessages(state, {successText, validationErrorText, serverErrorText, minLengthErrorText, maxLengthErrorText, minNumberErrorText, maxNumberErrorText, regExpErrorText, requiredErrorText}) {
            if (successText) {
                state.commonSettings.messages.successText = successText
            }
            if (validationErrorText) {
                state.commonSettings.messages.validationErrorText = validationErrorText
            }
            if (serverErrorText) {
                state.commonSettings.messages.serverErrorText = serverErrorText
            }
            if (minLengthErrorText) {
                state.commonSettings.messages.minLengthErrorText = minLengthErrorText
            }
            if (maxLengthErrorText) {
                state.commonSettings.messages.maxLengthErrorText = maxLengthErrorText
            }
            if (minNumberErrorText) {
                state.commonSettings.messages.minNumberErrorText = minNumberErrorText
            }
            if (maxNumberErrorText) {
                state.commonSettings.messages.maxNumberErrorText = maxNumberErrorText
            }
            if (regExpErrorText) {
                state.commonSettings.messages.regExpErrorText = regExpErrorText
            }
            if (requiredErrorText) {
                state.commonSettings.messages.requiredErrorText = requiredErrorText
            }
        },
        editCommonSettingsTitle(state, value) {
            state.commonSettings.form.title.value = value
        },
        editCommonSettingsDescription(state, value) {
            state.commonSettings.form.description.value = value
        },
        editCommonSettingsButton(state, value) {
            state.commonSettings.form.button.value = value
        },
        editCommonSettingsStyleByType(state, {type, styles}) {
            switch (type) {
                case 'title':
                    state.commonSettings.form.title.styles = {
                        ...state.commonSettings.form.title.styles,
                        ...styles
                    }
                    for (let key in state.commonSettings.form.title.styles) {
                        if (state.commonSettings.form.title.styles[key] === '') delete state.commonSettings.form.title.styles[key]
                    }
                    break
                case 'description':
                    state.commonSettings.form.description.styles = {
                        ...state.commonSettings.form.description.styles,
                        ...styles
                    }
                    for (let key in state.commonSettings.form.description.styles) {
                        if (state.commonSettings.form.description.styles[key] === '') delete state.commonSettings.form.description.styles[key]
                    }
                    break
                case 'form':
                    state.commonSettings.form.styles = {
                        ...state.commonSettings.form.styles,
                        ...styles
                    }
                    for (let key in state.commonSettings.form.styles) {
                        if (state.commonSettings.form.styles[key] === '') delete state.commonSettings.form.styles[key]
                    }
                    break
                case 'button':
                    state.commonSettings.form.button.styles = {
                        ...state.commonSettings.form.button.styles,
                        ...styles
                    }
                    for (let key in state.commonSettings.form.button.styles) {
                        if (state.commonSettings.form.button.styles[key] === '') delete state.commonSettings.form.button.styles[key]
                    }
                    break
            }
        },
        setCommonSettings(state, commonSettings) {
            state.commonSettings = commonSettings
        },
        setDefaultCommonSettingsStyles(state) {
            //form
            state.commonSettings.form.styles.backgroundColor = '#ffffff'
            state.commonSettings.form.styles.borderWidth = '1px'
            state.commonSettings.form.styles.borderStyle = 'solid'
            state.commonSettings.form.styles.borderColor = '#e3e3e3'
            state.commonSettings.form.styles.padding = '20px 20px 20px 20px'
            state.commonSettings.form.styles.fontSize = '14px'
            state.commonSettings.form.styles.color = '#191919'

            //title
            state.commonSettings.form.title.styles.fontSize = '18px'
            state.commonSettings.form.title.styles.lineHeight = '1.5'
            state.commonSettings.form.title.styles.fontWeight = '700'
            state.commonSettings.form.title.styles.margin = '0 0 20px 0'
            state.commonSettings.form.title.styles.textAlign = 'left'
            state.commonSettings.form.title.styles.color = '#191919'
            state.commonSettings.form.title.styles.backgroundColor = '#ffffff'

            //description
            state.commonSettings.form.description.styles.fontSize = '16px'
            state.commonSettings.form.description.styles.lineHeight = '1.5'
            state.commonSettings.form.description.styles.fontWeight = '400'
            state.commonSettings.form.description.styles.margin = '0 0 20px 0'
            state.commonSettings.form.description.styles.textAlign = 'left'
            state.commonSettings.form.description.styles.color = '#191919'
            state.commonSettings.form.description.styles.backgroundColor = '#ffffff'

            //button
            state.commonSettings.form.button.styles.fontSize = '14px'
            state.commonSettings.form.button.styles.lineHeight = '1.5'
            state.commonSettings.form.button.styles.fontWeight = '400'
            state.commonSettings.form.button.styles.padding = '8px 16px 8px 16px'
            state.commonSettings.form.button.styles.borderStyle = 'none'
            state.commonSettings.form.button.styles.color = '#ffffff'
            state.commonSettings.form.button.styles.backgroundColor = '#3434e3'
        }
    },
    actions: {
        editCommonSettingsMessages({commit}, {successText, validationErrorText, serverErrorText, minLengthErrorText, maxLengthErrorText, minNumberErrorText, maxNumberErrorText, regExpErrorText, requiredErrorText}) {
            commit('editCommonSettingsMessages', {successText, validationErrorText, serverErrorText, minLengthErrorText, maxLengthErrorText, minNumberErrorText, maxNumberErrorText, regExpErrorText, requiredErrorText})
            commit('setCommonSettingsData')
        },
        editCommonSettingsTitleValue({commit}, value) {
            commit('editCommonSettingsTitle', value)
            commit('setCommonSettingsData')
        },
        editCommonSettingsDescriptionValue({commit}, value) {
            commit('editCommonSettingsDescription', value)
            commit('setCommonSettingsData')
        },
        editCommonSettingsButtonValue({commit}, value) {
            commit('editCommonSettingsButton', value)
            commit('setCommonSettingsData')
        },
        editCommonSettingsStyleByType({commit}, {type, styles}) {
            commit('editCommonSettingsStyleByType', {type, styles})
            commit('setCommonSettingsData')
        },
        setCommonSettings({commit}, commonSettings) {
            commit('setCommonSettings', commonSettings)
            commit('setCommonSettingsData')
        },
        setDefaultCommonSettingsStyles({commit}) {
            commit('setDefaultCommonSettingsStyles')
            commit('setCommonSettingsData')
        }
    },
    getters: {
        commonSettings(state) {
            return state.commonSettings
        },
        commonSettingsMessages(state) {
            return state.commonSettings.messages
        },
        commonSettingsForm(state) {
            return state.commonSettings.form
        },
        commonSettingsFormTitle(state) {
            return state.commonSettings.form.title
        },
        commonSettingsFormDescription(state) {
            return state.commonSettings.form.description
        },
        commonSettingsFormButton(state) {
            return state.commonSettings.form.button
        }
    }
}