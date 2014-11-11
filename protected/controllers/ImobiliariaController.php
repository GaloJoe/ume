<?php

class ImobiliariaController extends GxController {
    
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

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Imobiliaria'),
        ));
    }

    public function actionCreate() {
        $model = new Imobiliaria;


        if (isset($_POST['Imobiliaria'])) {
            $model->setAttributes($_POST['Imobiliaria']);
            $model->ativo = true;

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
        $model = $this->loadModel($id, 'Imobiliaria');


        if (isset($_POST['Imobiliaria'])) {
            $model->setAttributes($_POST['Imobiliaria']);

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
//            $this->loadModel($id, 'Imobiliaria')->delete();
            $model = $this->loadModel($id, 'Imobiliaria');
            $model->ativo = 0;
//            $this->loadModel($id, 'Usuario')->delete();
            if ($model->save()) {
//                $this->deleteUsuarios($id);
                $this->redirect(array('view', 'id' => $model->id));
            }

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    private function deleteUsuarios($id) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'imobiliaria=:imobiliaria AND ativo=:ativo';
        $criteria->params = array(':imobiliaria' => $id, ':ativo' => 1);

        $usuarios = Usuario::model()->findAll($criteria); // $params não é necessario

        print_r($usuarios);
        exit;

        foreach ($usuarios as $usuario) {
            $uc = Yii::app()->createController('usuario'); //returns array containing controller instance and action index.
            $uc = $uc[0]; //get the controller instance.
            $uc->actionDelete($usuario->id); //use a public method.
        }
    }

    public function actionIndex() {
        $criteria = new CDbCriteria();
        
        $criteria = new CDbCriteria;
        $criteria->condition = 'ativo=:ativo';
        $criteria->params = array(':ativo' => 1);

        $dataProvider = new CActiveDataProvider('Imobiliaria', array('criteria' => $criteria, 'sort'=>array('defaultOrder'=>'t.nome')));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Imobiliaria('search');
        $model->unsetAttributes();
        
        if (isset($_GET['Imobiliaria']))
            $model->setAttributes($_GET['Imobiliaria']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
