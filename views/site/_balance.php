<?php

use app\models\BalanceHistory;
use yii\helpers\Html;
/** @var BalanceHistory $model */
?>
<ul>
	<li>id <?= Html::encode($model->id) ?>
	<li>сумма <?= Html::encode($model->value) ?></li>
	<li>баланс <?= Html::encode($model->balance) ?></li>
	<li>дата операции <?= Html::encode($model->created_at) ?></li>
	<li>user_id <?= Html::encode($model->user_id) ?></li>
</ul>