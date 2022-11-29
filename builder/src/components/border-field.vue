<template>
    <label class="b-box-field" :class="isFocuses ? 'focus' : ''">
        <div class="b-box-field__label">
            {{ title }}
        </div>
        <input type="number" class="b-box-field__input"
               :min="borderWidthRules.min"
               :max="borderWidthRules.max"
               :step="borderWidthRules.step"
               @focus="focusHandle"
               @blur="blurHandle"
               @change="widthChangeHandle"
               :value="borderWidthValue"
        >
        <select class="b-box-field__input"
                @focus="focusHandle"
                @blur="blurHandle"
                @change="styleChangeHandle"
                :value="borderStyleValue"
                required
        >
            <option value="" disabled selected hidden>Стиль</option>
            <option
                v-for="style in borderStyleList"
                :key="style"
                :value="style"
            >
                {{ style }}
            </option>
        </select>
        <input type="color" class="b-box-field__input"
               :value="borderColorValue"
               @focus="focusHandle"
               @blur="blurHandle"
               @input="colorChangeHandle"
               placeholder="Цвет"
        >
<!--        <div class="b-box-field__actions">-->
<!--            <div class="b-box-field__color" :style="{backgroundColor: borderColorValue}"></div>-->
<!--        </div>-->
    </label>
</template>

<script>
export default {
    props: {
        value: {
            type: Object
        },
        title: {
            type: String
        }
    },
    data() {
        return {
            isFocuses: false
        }
    },
    methods: {
        focusHandle() {
            this.isFocuses = true
        },
        blurHandle() {
            this.isFocuses = false
        },
        widthChangeHandle(event) {
            const value = event.target.value
            this.$emit('updateWidthValue', `${value}px`)
        },
        styleChangeHandle(event) {
            const value = event.target.value
            this.$emit('updateStyleValue', value)
        },
        colorChangeHandle(event) {
            const value = event.target.value
            this.$emit('updateColorValue', value)
        }
    },
    computed: {
        borderWidthRules() {
            return this.$store.getters.borderWidth
        },
        borderStyleList() {
            return this.$store.getters.borderStyle
        },
        borderWidthValue() {
            return parseFloat(this.value.borderWidth)
        },
        borderStyleValue() {
            return this.value.borderStyle
        },
        borderColorValue() {
            return this.value.borderColor
        }
    }
}
</script>