<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\models\Product */

$this->title = 'Редактировать товар: ' . $model->title;
?>


    <div class="town-form box box-primary">
        <?php $form = \yii\widgets\ActiveForm::begin(); ?>


            <?= $form->field($model, 'title')->textInput() ?>
            <?= $form->field($model, 'sku')->textInput() ?>
            <?= $form->field($model, 'picture')->textInput() ?>
            <?= $form->field($model, 'count')->textInput() ?>
            <?= $form->field($model, 'type')->dropDownList(\app\models\Product::types()) ?>


        <div class="box-footer">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-flat']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

