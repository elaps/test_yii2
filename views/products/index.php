<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Товары');
$this->params['breadcrumbs'][] = $this->title;
function isVisible($field){
    $hidden = yii::$app->session->get('hidden')??[];
    return !in_array($field, $hidden);
}

?>


<?= Html::a('Добавить', ['update', 'id' => 'new'], ['class' => 'btn btn-success btn-flat']) ?>
<hr>
<div>

    <?php
    $form = \yii\widgets\ActiveForm::begin(['method' => 'get']);
    echo $form->field($searchModel,'search')->label(false);
    echo Html::submitButton('Найти', ['class' => 'btn btn-success']);
    \yii\widgets\ActiveForm::end();
    ?>
    <hr>
    <?php
    $form = \yii\widgets\ActiveForm::begin([
        'action' => ['delete-selected'],
        'method' => 'post'
    ]);
    ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{summary}\n{pager}",
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            'id',
            [
                'attribute' => 'sku',
                'visible' => isVisible('sku')
            ],
            [
                'attribute' => 'title',
                'visible' => isVisible('title')
            ],
            [
                'attribute' => 'picture',
                'visible' => isVisible('picture')
            ],
            [
                'attribute' => 'count',
                'visible' => isVisible('count')
            ],
            [
                'attribute' => 'type',
                'visible' => isVisible('type'),
                'value' => function ($model){
                    return $model->getType();
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
    <?php
    echo Html::submitButton('Удалить выбранные', ['class' => 'btn btn-danger', 'data-confirm' => 'Точно удалить?']);
    \yii\widgets\ActiveForm::end();
    ?>
    <hr>
    Видимость полей

    <?php
    $product = new \app\models\Product();
    $form = \yii\widgets\ActiveForm::begin([
        'action' => ['hide-selected'],
        'method' => 'post']);
    foreach ($product->attributes() as $field){
        echo Html::checkbox("hide[$field]", !isVisible($field)).' '.$field."<br>";
    }
        echo Html::submitButton('Скрыть выбранные', ['class' => 'btn btn-danger']);
    \yii\widgets\ActiveForm::end();
    ?>
</div>

