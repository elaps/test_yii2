<?php

namespace app\controllers;
use app\models\Product;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ProductsController extends TableController{
    public $tableClassName = Product::class;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }
    public function actionDeleteSelected() {
        $cnt = 0;
        if (Yii::$app->request->post('selection')) {
            foreach (Yii::$app->request->post('selection') as $id) {
                $model = $this->getModel($id);
                if ($model) {
                    $model->delete();
                    $cnt++;
                }
            }
        }
        if ($cnt > 0) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app','Выбранные записи удалены.'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('app','Ничего не удалено.'));
        }
        return $this->redirect(['index']);
    }
    public function actionHideSelected() {
        yii::$app->session->remove('hidden');
        if (Yii::$app->request->post('hide')) {
            yii::$app->session->set('hidden',array_keys(Yii::$app->request->post('hide')));
        }
        return $this->redirect(['index']);
    }
}
