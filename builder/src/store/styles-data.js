export default {
    state: {
        fontSizes: ['8px', '9px', '10px', '11px', '12px', '14px', '16px', '18px', '24px', '30px', '36px', '48px', '60px', '72px', '96px'],
        fontWeights: [100, 200, 300, 400, 500, 600, 700, 800, 900],
        lineHeights: ['1', '1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '2'],
        textAligns: [
            {
                value: 'left',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14"><path d="M0 0H15V2H0V0Z"/><path d="M0 12H11V14H0V12Z"/><path d="M0 8H15V10H0V8Z"/><path d="M0 4H11V6H0V4Z"/></svg>`
            },
            {
                value: 'center',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14"><path d="M0 0H15V2H0V0Z"/><path d="M2 12H13V14H2V12Z"/><path d="M0 8H15V10H0V8Z"/><path d="M2 4H13V6H2V4Z"/></svg>`
            },
            {
                value: 'right',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14"><path d="M0 0H15V2H0V0Z"/><path d="M4 12H15V14H4V12Z"/><path d="M0 8H15V10H0V8Z"/><path d="M4 4H15V6H4V4Z"/></svg>`
            },
            {
                value: 'justify',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14"><path d="M0 0H15V2H0V0Z"/><path d="M0 12H15V14H0V12Z"/><path d="M0 8H15V10H0V8Z"/><path d="M0 4H15V6H0V4Z"/></svg>`
            },
        ],
        fontStyles: [
            {
                value: 'underline',
                name: 'text-decoration',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" width="11" height="13" viewBox="0 0 11 13"><path d="M5.49238 10.62C4.09238 10.62 3.00238 10.22 2.22238 9.42C1.44238 8.62 1.05238 7.47 1.05238 5.97V0H2.55238V5.91C2.55238 8.16 3.53738 9.285 5.50738 9.285C6.46738 9.285 7.20238 9.01 7.71238 8.46C8.22238 7.9 8.47738 7.05 8.47738 5.91V0H9.93238V5.97C9.93238 7.48 9.54238 8.635 8.76238 9.435C7.98238 10.225 6.89238 10.62 5.49238 10.62Z"/><path d="M0 11.5H11V12.5H0V11.5Z"/></svg>`
            },
            {
                value: 'italic',
                name: 'font-style',
                icon: `<svg xmlns="http://www.w3.org/2000/svg" width="5" height="13" viewBox="0 0 5 13"><path d="M2 0H5L3 13H0L2 0Z"/></svg>`
            },
            {
                value: 'uppercase',
                name: 'text-transform',
                icon: `<svg width="18" height="11" viewBox="0 0 18 11" xmlns="http://www.w3.org/2000/svg"><path d="M0.433594 10.8242L4.41797 0.6875H5.58984L9.57422 10.8242H8.16797L6.9375 7.77734H3.07031L1.83984 10.8242H0.433594ZM5.00391 2.62109L3.48047 6.66406H6.52734L5.00391 2.62109ZM8.42578 10.8242L12.4102 0.6875H13.582L17.5664 10.8242H16.1602L14.9297 7.77734H11.0625L9.83203 10.8242H8.42578ZM12.9961 2.62109L11.4727 6.66406H14.5195L12.9961 2.62109Z"/></svg>`
            }
        ],
        borderWidth: {
            min: 0,
            max: 5,
            step: 1
        },
        borderStyle: ['solid', 'dashed', 'dotted', 'none'],
    },
    mutations: {},
    actions: {},
    getters: {
        fontSizes(state) {
            return state.fontSizes
        },
        fontWeights(state) {
            return state.fontWeights
        },
        lineHeights(state) {
            return state.lineHeights
        },
        textAligns(state) {
            return state.textAligns
        },
        fontStyles(state) {
            return state.fontStyles
        },
        borderWidth(state) {
            return state.borderWidth
        },
        borderStyle(state) {
            return state.borderStyle
        }
    }
}