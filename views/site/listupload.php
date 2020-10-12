<?php
use yii\grid\GridView;
use yii\helpers\Html;
use dosamigos\datetimepicker\DateTimePicker;
?>


<?= GridView::widget([
    'dataProvider' => $provider,
]);
?>

<?= Html::beginForm(['site/list_upload', 'date_upload' => $date_upload], 'post', ['enctype' => 'multipart/form-data']) ?>
<div class="form-group">
    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
        <?= Html::input('text', 'date_upload', $date_upload, ['class' => 'form-control', 'size' => '16', 'value' => '','readonly' => true]) ?>

        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
    </div>

    <input type="hidden" id="dtp_input2" value="" /><br/>
    <?= Html::submitButton('Фильтровать', ['class' => 'btn btn-default']) ?>
</div>



<?= Html::endForm() ?>

<?= DateTimePicker::widget([
    'model' => $model,
    'attribute' => 'created_at',
    'language' => 'es',
    'size' => 'ms',
    'clientOptions' => [
        'autoclose' => true,
        'format' => 'dd MM yyyy - HH:ii P',
        'todayBtn' => true
    ]
]);?>


<script type="text/javascript" src="/jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/locales/bootstrap-datetimepicker.ru.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
</script>