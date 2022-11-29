<?php
/**
 * @var $data array
 * @var $index int
 */

$isRequired = $data['validations']['required'];
$title = $data['field']['title'];
$name = $data['field']['slug'] ? $data['field']['slug'] : 'unisender-field-' . $index;
?>
<div class="b-unisender-field <?= $isRequired ? 'b-unisender-field_required' : '' ?> b-unisender-form__field" data-unisender-field-name="<?= $name ?>">
    <label for="<?= $data['field']['slug'] ?>" class="b-unisender-field__label">
        <?= $title ?>
    </label>
    <input name="<?= $data['field']['slug'] ?>" type="email" id="<?= $data['field']['slug'] ?>" class="b-unisender-field__input" data-unisender-field data-validation-rules="<?= htmlspecialchars(json_encode($data['validations'])) ?>">
    <div class="b-unisender-field__error-text" data-unisender-field-error>
        Какой-то текст ошибки
    </div>
</div>
