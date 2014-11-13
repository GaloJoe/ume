<?php

class CategoriaController extends GxController {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Categoria'),
        ));
    }

    public function actionCreate() {
        $model = new Categoria;


        if (isset($_POST['Categoria'])) {
            $model->setAttributes($_POST['Categoria']);

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
        $model = $this->loadModel($id, 'Categoria');


        if (isset($_POST['Categoria'])) {
            $model->setAttributes($_POST['Categoria']);

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
            $this->loadModel($id, 'Categoria')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Categoria');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionIndexEmpreendimento() {
        $dataProvider = new CActiveDataProvider('Empreendimento');
        $this->render('indexEmpreendimento', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $idEmpreendimento = Yii::app()->session['empreendimento'];
        
        $model = new Categoria('search');
        $model->unsetAttributes();

        if (isset($_GET['Categoria']))
            $model->setAttributes($_GET['Categoria']);

        $model->empreendimento = $idEmpreendimento;
        
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
