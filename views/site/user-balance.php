<?php

use app\models\BalanceDataProvider;
use yii\widgets\ListView;


?>
<div class="row">
    <h2>Баланс</h2>
    <?php
    /** @var BalanceDataProvider $dataProvider */
    echo ListView::widget([
	    'dataProvider' => $dataProvider,
	    'itemView' => '_balance',
    ]);
    ?>

</div>
<div class="row">
    <h2>История</h2>
	<?php
	/** @var BalanceDataProvider $dataProvider2 */
	echo ListView::widget([
		'dataProvider' => $dataProvider2,
		'itemView' => '_balance',
	]);
	?>
</div>