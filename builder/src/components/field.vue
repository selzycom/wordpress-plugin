<template>
    <label class="b-field">
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
        <input :disabled="disabled" v-if="type !== 'textarea' && !change" :type="type" :min="min" class="b-field__input" :value="value" @input="updateValue">
        <textarea :disabled="disabled" v-if="type === 'textarea' && !change" class="b-field__input" :value="value" @input="updateValue" style="height: 100px"></textarea>
        <input :disabled="disabled" v-if="type !== 'textarea' && change" :type="type" :min="min" class="b-field__input" :value="value" @change="updateValue">
        <textarea :disabled="disabled" v-if="type === 'textarea' && change" class="b-field__input" :value="value" @change="updateValue" style="height: 100px"></textarea>
        <div class="b-field__errors">
            <p>
                Поле обязательно для заполнения
            </p>
        </div>
    </label>
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
        type: {
            type: String,
            default: () => 'text'
        },
        min: {
            type: Number
        },
        change: {
            type: Boolean,
            default: () => false
        },
        disabled: {
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
            if (this.disabled) return false
            const value = event.target.value
            this.$emit('updateValue', value)
        }
    }
}
</script>