<template>
    <div class="b-icon-radio-list">
        <label class="b-icon-radio b-icon-radio-list__item"
               v-for="(item, index) in list"
               :key="`radio-${name}-${index}`"
        >
            <input type="radio" class="b-icon-radio__input"
                   :name="name"
                   :value="item.value"
                   :checked="item.value === value"
                   @input="updateValue"
            >
            <span class="b-icon-radio__icon"
                  v-html="item.icon"
            ></span>
        </label>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true
        },
        list: {
            type: Array,
            required: true
        },
        value: {
            type: String
        }
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