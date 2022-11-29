export default class Validation {
    constructor({minLength, maxLength, minNumber, maxNumber, regExp, required}) {
        this.minLength = minLength ? minLength : null
        this.maxLength = maxLength ? maxLength : null
        this.minNumber = minNumber ? minNumber : null
        this.maxNumber = maxNumber ? maxNumber : null
        this.regExp = regExp ? regExp : null
        this.required = required ? required : null

        return this
    }

    isEmptyString(str) {
        return typeof str === 'string' && str.length === 0
    }

    setNew({minLength, maxLength, minNumber, maxNumber, regExp, required}) {
        if (minLength) {
            this.minLength = minLength
        }
        if (this.isEmptyString(minLength)) {
            this.minLength = null
        }
        //
        if (maxLength) {
            this.maxLength = maxLength
        }
        if (this.isEmptyString(maxLength)) {
            this.maxLength = null
        }
        //
        if (minNumber) {
            this.minNumber = minNumber
        }
        if (this.isEmptyString(minNumber)) {
            this.minNumber = null
        }
        //
        if (maxNumber) {
            this.maxNumber = maxNumber
        }
        if (this.isEmptyString(maxNumber)) {
            this.maxNumber = null
        }
        //
        if (regExp) {
            this.regExp = regExp
        }
        if (this.isEmptyString(regExp)) {
            this.regExp = null
        }
        //
        if (required) {
            this.required = required
        }

        return this
    }
}