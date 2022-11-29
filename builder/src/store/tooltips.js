export default {
    state: {
        tooltips: {
            fields: [
                {
                    typeId: 1,
                    value: ''
                },
                {
                    typeId: 2,
                    value: ''
                },
                {
                    typeId: 3,
                    value: ''
                },
                {
                    typeId: 4,
                    value: ''
                },
                {
                    typeId: 5,
                    value: ''
                },
                {
                    typeId: 6,
                    value: ''
                },
                {
                    typeId: 7,
                    value: ''
                },
                {
                    typeId: 8,
                    value: ''
                }
            ],
            validations: {
                minLength: '',
                maxLength: '',
                minNumber: '',
                maxNumber: '',
                required: '',
                regExp: '',
            },
            slug: '<p>Прежде чем использовать дополнительные поля, необходимо создать их на платформе Unisender. Чтобы это сделать, перейдите по ссылке под этим полем.</p> <p>После вы сможете привязать дополнительное поле Unisender к полю на Вашем сайте.</p>',
            title: '',
            dateFormat: '<p>Выберите нужный формат даты.</p> <p><strong>dd</strong> - день.</p> <p><strong>mm</strong> - месяц.</p> <p><strong>yyyy</strong> - год.</p>',
            options: '<p>Укажите варианты для выбора с новой строки каждый.</p>'
        }
    },
    getters: {
        tooltips(state) {
            return state.tooltips
        }
    }
}