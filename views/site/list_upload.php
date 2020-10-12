<?php
use yii\grid\GridView;
use dosamigos\datetimepicker\DateTimePicker;
?>

<?= GridView::widget([
    'dataProvider' => $provider,
]);
?>
