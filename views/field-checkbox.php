<?php
/**
 * @var $data array
 * @var $index int
 */

$title = $data['field']['title'];
$name = $data['field']['slug'] ? $data['field']['slug'] : 'unisender-field-' . $index;
?>
<div class="b-unisender-checkbox b-unisender-form__field" data-unisender-field-name="<?= $name ?>">
    <input name="<?= $data['field']['slug'] ?>" type="checkbox" id="<?= $data['field']['slug'] ?>" class="b-unisender-checkbox__input" data-unisender-field data-validation-rules="<?= htmlspecialchars(json_encode($data['validations'])) ?>">
    <label for="<?= $data['field']['slug'] ?>" class="b-unisender-checkbox__label">
        <?= $title ?>
    </label>
    <div class="b-unisender-checkbox__error-text" data-unisender-field-error>
        Какой-то текст ошибки
    </div>
</div>
