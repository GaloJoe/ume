<?php

class UnidadeMedidaController extends GxController {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'UnidadeMedida'),
        ));
    }

    public function actionCreate() {
        $model = new UnidadeMedida;
        if (isset($_POST['UnidadeMedida'])) {
            $model->setAttributes($_POST['UnidadeMedida']);
            
            $model->ativo = 1;

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'UnidadeMedida');


        if (isset($_POST['UnidadeMedida'])) {
            $model->setAttributes($_POST['UnidadeMedida']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id, 'UnidadeMedida')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('UnidadeMedida');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new UnidadeMedida('search');
        $model->unsetAttributes();

        if (isset($_GET['UnidadeMedida']))
            $model->setAttributes($_GET['UnidadeMedida']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function filters() {
        return array(
            'accessControl',
        );
    }
    
    public function accessRules() {
        return array(
            array('deny',
                'actions' => array('index', 'create', 'edit', 'delete', 'update', 'view', 'admin'),
                'users' => array('?'),
            ),
            array('allow',
                'actions' => array('index', 'create', 'edit', 'delete', 'update', 'view', 'admin'),
                'roles' => array('admin', 'master'),
            ),
        );
    }
}
