<?php

class SelzyFormFieldTypes
{
    const TYPE_NAME = 1;
    const TYPE_EMAIL = 2;
    const TYPE_PHONE = 3;
    const TYPE_TEXT = 4;
    const TYPE_NUMBER = 5;
    const TYPE_SELECT = 6;
    const TYPE_CHECKBOX = 7;
    const TYPE_DATE = 8;

    public static function getViews()
    {
        return [
            self::TYPE_NAME => 'field-name',
            self::TYPE_EMAIL => 'field-email',
            self::TYPE_PHONE => 'field-phone',
            self::TYPE_TEXT => 'field-text',
            self::TYPE_NUMBER => 'field-number',
            self::TYPE_SELECT => 'field-select',
            self::TYPE_CHECKBOX => 'field-checkbox',
            self::TYPE_DATE => 'field-date'
        ];
    }

    public static function getView($typeId)
    {
        return self::getViews()[$typeId] ?: null;
    }
}