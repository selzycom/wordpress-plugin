<?php
/**
 * @var $data array
 * @var $index int
 */

$isRequired = $data['validations']['required'];
$title = $data['field']['title'];
$options = $data['field']['options'];
$name = $data['field']['slug'] ? $data['field']['slug'] : 'unisender-field-' . $index;
?>
<div class="b-unisender-field <?= $isRequired ? 'b-unisender-field_required' : '' ?> b-unisender-form__field" data-unisender-field-name="<?= $name ?>">
    <label for="<?= $data['field']['slug'] ?>" class="b-unisender-field__label">
        <?= $title ?>
    </label>
    <select name="<?= $data['field']['slug'] ?>" id="<?= $data['field']['slug'] ?>" class="b-unisender-field__input" data-unisender-field data-validation-rules="<?= htmlspecialchars(json_encode($data['validations'])) ?>">
        <?php foreach ($options as $option):?>
            <option value="<?=$option?>">
                <?=$option?>
            </option>
        <?php endforeach;?>
    </select>
    <div class="b-unisender-field__error-text" data-unisender-field-error>
        Какой-то текст ошибки
    </div>
</div>
