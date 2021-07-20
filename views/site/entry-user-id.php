<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin (); ?>

<?= $form->field ( $model, 'userId')->textInput()->hint("в демо данных есть 1, 2 и 3")->label('ID пользователя') ?>

<div class="form-group">
    <?= Html::submitButton('Запросить баланс' , ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>