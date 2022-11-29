<template>
    <div class="b-offsets">
        <div class="b-offsets__external">
            <div class="b-offset__part-title">
                Внешний
            </div>
            <div class="b-offsets__line">
                <input type="text" class="b-offsets__input" :value="marginArray[0]" placeholder="-" @input="updateMarginTop">
            </div>
            <div class="b-offsets__line">
                <input type="text" class="b-offsets__input" :value="marginArray[3]" placeholder="-" @input="updateMarginLeft">
                <div class="b-offsets__internal">
                    <div class="b-offset__part-title">
                        Внутренний
                    </div>
                    <div class="b-offsets__line">
                        <input type="text" class="b-offsets__input" :value="paddingArray[0]" placeholder="-" @input="updatePaddingTop">
                    </div>
                    <div class="b-offsets__line">
                        <input type="text" class="b-offsets__input" :value="paddingArray[3]" placeholder="-" @input="updatePaddingLeft">
                        <div class="b-offset__space"></div>
                        <input type="text" class="b-offsets__input" :value="paddingArray[1]" placeholder="-" @input="updatePaddingRight">
                    </div>
                    <div class="b-offsets__line">
                        <input type="text" class="b-offsets__input" :value="paddingArray[2]" placeholder="-" @input="updatePaddingBottom">
                    </div>
                </div>
                <input type="text" class="b-offsets__input" :value="marginArray[1]" placeholder="-" @input="updateMarginRight">
            </div>
            <div class="b-offsets__line">
                <input type="text" class="b-offsets__input" :value="marginArray[2]" placeholder="-" @input="updateMarginBottom">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        paddings: {
            type: String
        },
        margins: {
            type: String
        },
    },
    data() {
        return {
            currentMarginArray: [null, null, null, null],
            currentPaddingArray: [null, null, null, null],
        }
    },
    methods: {
        correctValue(value) {
            if (typeof value === 'string') {
                if (isNaN(parseFloat(value))) {
                    return null
                }
                if (parseFloat(value)) {
                    return parseFloat(value).toString()
                } else {
                    return null
                }
            }
            if (value === null) {
                return null
            }
            if (value === undefined) {
                return null
            }
            if (value === '') {
                return null
            }
        },
        updatePaddingTop(event) {
            const value = event.target.value
            this.$set(this.currentPaddingArray, 0, this.correctValue(value))
            this.emitPaddings()
        },
        updatePaddingRight(event) {
            const value = event.target.value
            this.$set(this.currentPaddingArray, 1, this.correctValue(value))
            this.emitPaddings()
        },
        updatePaddingBottom(event) {
            const value = event.target.value
            this.$set(this.currentPaddingArray, 2, this.correctValue(value))
            this.emitPaddings()
        },
        updatePaddingLeft(event) {
            const value = event.target.value
            this.$set(this.currentPaddingArray, 3, this.correctValue(value))
            this.emitPaddings()
        },
        //
        updateMarginTop(event) {
            const value = event.target.value
            this.$set(this.currentMarginArray, 0, this.correctValue(value))
            this.emitMargins()
        },
        updateMarginRight(event) {
            const value = event.target.value
            this.$set(this.currentMarginArray, 1, this.correctValue(value))
            this.emitMargins()
        },
        updateMarginBottom(event) {
            const value = event.target.value
            this.$set(this.currentMarginArray, 2, this.correctValue(value))
            this.emitMargins()
        },
        updateMarginLeft(event) {
            const value = event.target.value
            this.$set(this.currentMarginArray, 3, this.correctValue(value))
            this.emitMargins()
        },
        //
        emitPaddings() {
            const data = this.arrayToStr(this.currentPaddingArray)
            this.$emit('updatePadding', data)
        },
        emitMargins() {
            const data = this.arrayToStr(this.currentMarginArray)
            this.$emit('updateMargin', data)
        },
        strToArray(str) {
            return str.split(' ').map(item => item === '0' ? null : parseFloat(item))
        },
        arrayToStr(arr) {
            return arr.map(item => {
                if (typeof item === 'string') {
                    return item.includes('px') ? item : `${item}px`
                } else {
                    return '0'
                }
            }).join(' ')
        }
    },
    created() {
        this.currentPaddingArray = this.paddingArray.map(item => typeof item === 'number' ? item.toString() : null)
        this.currentMarginArray = this.marginArray.map(item => typeof item === 'number' ? item.toString() : null)
    },
    computed: {
        paddingArray() {
            return this.paddings ? this.strToArray(this.paddings) : [null, null, null, null]
        },
        marginArray() {
            return this.margins ? this.strToArray(this.margins) : [null, null, null, null]
        },
    }
}
</script>