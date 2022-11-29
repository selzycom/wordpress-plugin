<template>
    <div class="b-field">
        <div class="b-field__label">
            <div class="b-field__name">
                {{ title }}
            </div>
            <div class="b-field__hint" v-if="hint">
                <Tooltip>
                    <div slot="content" class="b-content" v-html="hint">
                    </div>
                </Tooltip>
            </div>
        </div>
        <select v-if="isDouble" class="b-field__input" :value="value" @input="updateValue">
            <option v-for="option in options" :key="`option-${option.value}`" :value="option.value">{{option.key}}</option>
        </select>
        <select v-if="!isDouble" class="b-field__input" :value="value" @input="updateValue">
            <option v-for="option in options" :key="`option-${option}`" :value="option">{{option}}</option>
        </select>
        <div class="b-field__errors">
            <p>
                Поле обязательно для заполнения
            </p>
        </div>
    </div>
</template>

<script>
import Tooltip from "./tooltip";

export default {
    props: {
        title: {
            type: String,
            default: () => 'Заголовок'
        },
        value: {
            type: String
        },
        hint: {
            type: String
        },
        options: {
            type: Array
        },
        isDouble: {
            type: Boolean
        }
    },
    components: {
        Tooltip
    },
    data() {
        return {}
    },
    methods: {
        updateValue(event) {
            const value = event.target.value
            this.$emit('updateValue', value)
        }
    }
}
</script>