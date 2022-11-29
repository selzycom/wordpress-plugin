class FormatDate {
    static getValueByFormat(value, format) {
        const date = new Date(value)
        const char = format.includes('/') ? '/' : (format.includes('.') ? '.' : false)
        const parsing = format.includes('/') ? format.split('/') : (format.includes('.') ? format.split('.') : false)
        const conformities = {
            dd: 'getDate',
            mm: 'getMonth',
            yyyy: 'getFullYear'
        }
        return parsing.map((item, index) => {
            const v = date[conformities[item]]().toString()
            return v.length < 2 ? `0${v}` : v
        }).join(char)
    }
}

class UnisenderForm {
    constructor(form) {
        if (!form) return false
        if (!unisenderValidationErrorTexts) return false
        if (!UNISENDER_AJAX) throw new Error(`"UNISENDER_AJAX" not found`)
        this.form = form
        this.contactList = this.form.getAttribute('data-contact-list')
        this.fields = this.form.querySelectorAll('[data-unisender-field]')
        this.submitButton = this.form.querySelector('.b-unisender-form__submit-button')
        this.fieldWraps = this.form.querySelectorAll('[data-unisender-field-name]')
        this.errorPlaces = this.form.querySelectorAll('[data-unisender-field-error]')
        this.errorTexts = unisenderValidationErrorTexts
        this.errors = []
        this.ajaxUrl = UNISENDER_AJAX.url

        this.test = {
            required: v => {
                return !v
            },
            minLength: (v, r) => {
                return v ? !(v.length >= parseFloat(r)) : false
            },
            maxLength: (v, r) => {
                return v ? !(v.length <= parseFloat(r)) : false
            },
            minNumber: (v, r) => {
                return v ? !(parseFloat(v) >= parseFloat(r)) : false
            },
            maxNumber: (v, r) => {
                return v ? !(parseFloat(v) <= parseFloat(r)) : false
            },
            regExp: (v, r) => {
                return v ? !v : false
            },
            email: (v, r) => {
                const regExp = /\S+@\S+\.\S+/
                return !regExp.test(v)
            }
        }

        this.init()
    }
    init() {
        this.listeners()
    }

    listeners() {
        this.submitButton.addEventListener('click', e => {
            this.submitButtonHandleClick()
        })
    }

    submitButtonHandleClick() {
        this.errors = []
        this.form.classList.remove('_show-message')
        this.form.classList.remove('_success-text')
        this.form.classList.remove('_validation-error-text')
        this.form.classList.remove('_server-error-text')

        for (let i = 0; i < this.fields.length; i++) {
            const value = this.fields[i].getAttribute('type') === 'checkbox' ? this.fields[i].checked : this.fields[i].value
            const rulesJson = this.fields[i].getAttribute('data-validation-rules')
            const rules = rulesJson ? JSON.parse(rulesJson) : null
            const activeRules = []
            if (this.fields[i].type === 'email') {
                activeRules.push({
                    name: 'email',
                    value: true
                })
            }
            Object.keys(rules).forEach(key => {
                if (rules[key]) {
                    activeRules.push({
                        name: key,
                        value: rules[key]
                    })
                }
            })

            if (activeRules.length > 0) {
                this.validationField(this.fields[i], activeRules, value)
            }
        }

        if (this.errors.length === 0) {
            this.request()
        }
    }

    validationField(field, rules, value) {
        const index = Array.prototype.indexOf.call(this.fields, field)
        this.fieldWraps[index].classList.remove('_has-error')
        this.errorPlaces[index].innerHTML = ''

        const errors = []
        rules.forEach(rule => {
            if (this.test[rule.name](value, rule.value)) {
                errors.push(rule.name)
            }
        })

        if (errors.length > 0) {
            this.fieldWraps[index].classList.add('_has-error')
            this.form.classList.add('_show-message')
            this.form.classList.add('_validation-error-text')

            errors.forEach(error => {
                const errorKey = `${error}ErrorText`
                console.log(errorKey)
                this.errorPlaces[index].innerHTML = this.errorTexts[errorKey]
            })

            this.errors.push(errors)
        }
    }

    request() {
        this.submitButton.parentElement.classList.add('request')
        const formData = new FormData()
        const data = {}

        formData.set('action', 'wpselzy_subscribe')
        formData.set('contact_list', this.contactList)

        for (let i = 0; i < this.fields.length; i++) {
            const field = this.fields[i]
            const name = field.getAttribute('name')
            const type = field.type
            const value = type === 'date' ? FormatDate.getValueByFormat(field.value, field.getAttribute('data-date-type')) : field.value
            if (name) {
                data[name] = value
            }
        }

        formData.set('data', JSON.stringify(data))
        fetch(
            this.ajaxUrl,
            {
                method: 'POST',
                body: formData
            }
        )
            .then(response => response.json())
            .then(response => {
                this.submitButton.parentElement.classList.remove('request')
                if (response.status === 'success') {
                    this.form.classList.add('_show-message')
                    this.form.classList.add('_success-text')
                    this.dropFieldsValue()
                } else {
                    this.form.classList.add('_show-message')
                    this.form.classList.add('_server-error-text')
                }
            })
    }
    dropFieldsValue() {
        for (let i = 0; i < this.fields.length; i++) {
            const field = this.fields[i]
            if (field.type !== 'checkbox') {
                field.value = null
            } else {
                field.checked = false
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const unisenderForms = document.querySelectorAll('[data-contact-list]')
    for (let i = 0; i < unisenderForms.length; i++) {
        new UnisenderForm(unisenderForms[i])
    }
})