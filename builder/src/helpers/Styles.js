export default class Styles {
    constructor({
                    fontSize,
                    fontWeight,
                    color,
                    lineHeight,
                    backgroundColor,
                    textAlign,
                    textDecorationUnderline,
                    fontStyleItalic,
                    textTransformUppercase,
                    borderWidth,
                    borderStyle,
                    borderColor,
                    padding,
                    margin
                }) {
        this.fontSize = fontSize ? fontSize : '14px'
        this.fontWeight = fontWeight ? fontWeight : '400'
        this.color = color ? color : '#191919'
        this.lineHeight = lineHeight ? lineHeight : '1.4'
        this.backgroundColor = backgroundColor ? backgroundColor : '#ffffff'
        this.textAlign = textAlign ? textAlign : 'left'
        this.textDecorationUnderline = textDecorationUnderline ? textDecorationUnderline : null
        this.fontStyleItalic = fontStyleItalic ? fontStyleItalic : null
        this.textTransformUppercase = textTransformUppercase ? textTransformUppercase : null
        this.borderWidth = borderWidth ? borderWidth : '1px'
        this.borderStyle = borderStyle ? borderStyle : 'solid'
        this.borderColor = borderColor ? borderColor : '#adadad'
        this.padding = padding ? padding : '8px 16px 8px 16px'
        this.margin = margin ? margin : '0 0 20px 0'

        return this
    }

    isEmptyString(str) {
        return typeof str === 'string' && str.length === 0
    }

    setNew({
               fontSize,
               fontWeight,
               color,
               lineHeight,
               backgroundColor,
               textAlign,
               textDecorationUnderline,
               fontStyleItalic,
               textTransformUppercase,
               borderWidth,
               borderStyle,
               borderColor,
               padding,
               margin
           }) {
        if (fontSize) {
            this.fontSize = fontSize
        }
        if (this.isEmptyString(fontSize)) {
            this.fontSize = null
        }
        //
        if (fontWeight) {
            this.fontWeight = fontWeight
        }
        if (this.isEmptyString(fontWeight)) {
            this.fontWeight = null
        }
        //
        if (color) {
            this.color = color
        }
        if (this.isEmptyString(color)) {
            this.color = null
        }
        //
        if (lineHeight) {
            this.lineHeight = lineHeight
        }
        if (this.isEmptyString(lineHeight)) {
            this.lineHeight = null
        }
        //
        if (backgroundColor) {
            this.backgroundColor = backgroundColor
        }
        if (this.isEmptyString(backgroundColor)) {
            this.backgroundColor = null
        }
        //
        if (textAlign) {
            this.textAlign = textAlign
        }
        if (this.isEmptyString(textAlign)) {
            this.textAlign = null
        }
        //
        if (textDecorationUnderline) {
            this.textDecorationUnderline = textDecorationUnderline
        }
        if (this.isEmptyString(textDecorationUnderline)) {
            this.textDecorationUnderline = null
        }
        //
        if (fontStyleItalic) {
            this.fontStyleItalic = fontStyleItalic
        }
        if (this.isEmptyString(fontStyleItalic)) {
            this.fontStyleItalic = null
        }
        //
        if (textTransformUppercase) {
            this.textTransformUppercase = textTransformUppercase
        }
        if (this.isEmptyString(textTransformUppercase)) {
            this.textTransformUppercase = null
        }
        //
        if (borderWidth) {
            this.borderWidth = borderWidth
        }
        if (this.isEmptyString(borderWidth)) {
            this.borderWidth = null
        }
        //
        if (borderStyle) {
            this.borderStyle = borderStyle
        }
        if (this.isEmptyString(borderStyle)) {
            this.borderStyle = null
        }
        //
        if (borderColor) {
            this.borderColor = borderColor
        }
        if (this.isEmptyString(borderColor)) {
            this.borderColor = null
        }
        //
        if (padding) {
            this.padding = padding
        }
        if (this.isEmptyString(padding)) {
            this.padding = null
        }
        //
        if (margin) {
            this.margin = margin
        }
        if (this.isEmptyString(margin)) {
            this.margin = null
        }
        //

        return this
    }
}