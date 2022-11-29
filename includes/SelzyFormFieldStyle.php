<?php

class SelzyFormFieldStyle
{
    const FONT_SIZE = 'fontSize';
    const FONT_WEIGHT = 'fontWeight';
    const COLOR = 'color';
    const LINE_HEIGHT = 'lineHeight';
    const BACKGROUND_COLOR = 'backgroundColor';
    const TEXT_ALIGN = 'textAlign';
    const TEXT_DECORATION_UNDERLINE = 'textDecorationUnderline';
    const FONT_STYLE_ITALIC = 'fontStyleItalic';
    const TEXT_TRANSFORM_UPPERCASE = 'textTransformUppercase';
    const BORDER_WIDTH = 'borderWidth';
    const BORDER_STYLE = 'borderStyle';
    const BORDER_COLOR = 'borderColor';
    const PADDING = 'padding';
    const MARGIN = 'margin';

    public static function getStyleNames()
    {
        return [
            self::FONT_SIZE => 'font-size',
            self::FONT_WEIGHT => 'font-weight',
            self::COLOR => 'color',
            self::LINE_HEIGHT => 'line-height',
            self::BACKGROUND_COLOR => 'background-color',
            self::TEXT_ALIGN => 'text-align',
            self::TEXT_DECORATION_UNDERLINE => 'text-decoration',
            self::FONT_STYLE_ITALIC => 'font-style',
            self::TEXT_TRANSFORM_UPPERCASE => 'text-transform',
            self::BORDER_WIDTH => 'border-width',
            self::BORDER_STYLE => 'border-style',
            self::BORDER_COLOR => 'border-color',
            self::PADDING => 'padding',
            self::MARGIN => 'margin',
        ];
    }

    public static function getStyleName($name)
    {
        return self::getStyleNames()[$name] ?: null;
    }
}