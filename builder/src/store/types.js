export default {
    state: {
        types: [
            {
                id: 1,
                name: 'Имя'
            },
            {
                id: 2,
                name: 'Email'
            },
            {
                id: 3,
                name: 'Номер телефона'
            },
            {
                id: 4,
                name: 'Текст'
            },
            {
                id: 5,
                name: 'Число'
            },
            {
                id: 6,
                name: 'Выбор'
            },
            {
                id: 7,
                name: 'Да / Нет'
            },
            {
                id: 8,
                name: 'Дата'
            },
        ]
    },
    mutations: {},
    actions: {},
    getters: {
        types(state) {
            return state.types
        }
    }
}