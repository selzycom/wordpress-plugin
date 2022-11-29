export default class DataItem {
    constructor() {
        this.field = {}
        this.styles = {}
        this.validations = {}
    }

    setField(data) {
        this.field = data
    }

    setStyles(data) {
        this.styles = data
    }

    setValidations(data) {
        this.validations = data
    }
}