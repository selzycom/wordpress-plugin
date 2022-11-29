<template>
    <div class="b-icon-checkbox-list">
        <label class="b-icon-checkbox b-icon-checkbox-list__item"
               v-for="(item, index) in list"
               :key="`radio-${item.name}-${index}`"
        >
            <input type="checkbox" class="b-icon-checkbox__input"
                   :name="item.name"
                   :value="item.value"
                   :checked="isChecked(item.value)"
                   @input="updateValue"
            >
            <span class="b-icon-checkbox__icon"
                  v-html="item.icon"
            ></span>
        </label>
    </div>
</template>

<script>
export default {
    props: {
        list: {
            type: Array,
            required: true
        },
        value: {
            type: Object,
        }
    },
    data() {
        return {}
    },
    methods: {
        updateValue(event) {
            const target = event.target
            const data = {
                name: target.name,
                value: target.value,
                checked: target.checked
            }
            this.$emit('updateValue', data)
        },
        isChecked(value) {
            let answer = false
            for (let key in this.value) {
                answer = this.value[key] === value
            }
            return answer
        }
    }
}
</script>