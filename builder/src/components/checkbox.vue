<template>
    <label class="b-checkbox">
        <input type="checkbox" class="b-checkbox__input" @change="updateValue" :checked="value" :disabled="disabled">
        <span class="b-checkbox__label">{{label}}</span>
    </label>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            required: true
        },
        value: {
            type: Boolean,
            default: () => false
        },
        disabled: {
            type: Boolean
        }
    },
    methods: {
        updateValue(event) {
            this.$emit('updateValue', event.target.checked)
        }
    }
}
</script>