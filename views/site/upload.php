<?php
use yii\widgets\ActiveForm;
if ($success == true){
echo "<div class='alert alert-success' role='alert'>Файлы загружены успешно</div>";
}
?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'uploadedFiles[]')->fileInput(['multiple' => true]) ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>