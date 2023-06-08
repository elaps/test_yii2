<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class TableController extends Controller {
    public $tableClassName;
    public $searchModelClassName;
    public $viewPath='';

    public $modelClass;

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function afterAction($action, $result) {
        if (!Yii::$app->request->isAjax) {
            Yii::$app->getUser()->setReturnUrl(Yii::$app->request->url);
        }
        return parent::afterAction($action, $result);
    }

    /*служебное*/
    public function init() {
        $this->modelClass = $this->getClass();
        if (class_exists($this->tableClassName . 'Search')) {
            $this->searchModelClassName = $this->tableClassName . 'Search';
        }
        parent::init();
    }

    public function getClass($attributes = []) {
        return new $this->tableClassName($attributes);
    }

    public function actionIndex() {
        $searchModel = $this->getSearchClass();
        $searchModel->load(Yii::$app->request->get());
        if (is_callable($this->searchModelClassName . '::search')) {
            $dataProvider = $searchModel->search($searchModel->attributes);
        } else {
            $q = $this->class->find();
            $dataProvider = new ActiveDataProvider(['query' => $q]);
            $searchModel = null;
        }
        return $this->render($this->viewPath.'index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function getSearchClass() {
        return new $this->searchModelClassName;
    }

    public function actionUpdate($id = 'new') {

        if ($id == 'new') {
            $model = $this->getClass($this->defaults??[]);
        } else {
            $model = $this->getModel($id);
        }

        if ($model->load(Yii::$app->request->post()) and $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Сохранено'));
            return $this->redirect(['index']);
        }

        return $this->render($this->viewPath.'update', ['model' => $model]);
    }

    public function getModel($id) {
        $model = $this->modelClass->findOne($id);
        if (!$model) {
            die;
        }
        return $model;
    }

    public function actionDelete($id) {
        $model = $this->getModel($id);
        if ($model) {
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Удалено'));
            }
        }
        return $this->redirect(['index']);
    }

}
