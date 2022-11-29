<template>
    <label class="b-box-field" :class="isFocuses ? 'focus' : ''">
        <div class="b-box-field__label">
            {{ title }}
        </div>
        <select class="b-box-field__input"
                v-if="options"
                @focus="focusHandle"
                @blur="blurHandle"
                @input="inputHandle"
                :value="value"
                ref="select"
        >
            <option v-for="option in options"
                    :key="`option-${option}`"
                    :value="option"
            >{{option}}</option>
        </select>
        <input class="b-box-field__input b-box-field__input_w-100"
               :type="type"
               v-if="!options"
               :value="value"
               @focus="focusHandle"
               @blur="blurHandle"
               @input="inputHandle"
        >
        <div class="b-box-field__actions" v-if="!options && type !== 'color'">
            <div class="b-box-field__color" :style="{backgroundColor: value}" v-if="!options && type !== 'color'"></div>
        </div>
    </label>
</template>

<script>
export default {
    props: {
        options: {
            type: Array
        },
        value: {
            type: String
        },
        title: {
            type: String
        },
        type: {
            type: String,
            default: () => 'text'
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
        inputHandle(event) {
            const value = event.target.value
            this.$emit('updateValue', value)
        }
    }
}
</script>