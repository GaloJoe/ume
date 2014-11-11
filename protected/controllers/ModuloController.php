<?php

class ModuloController extends GxController {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Modulo'),
        ));
    }

    public function actionCreate($empreendimento) {
        $model = new Modulo;

        $model->empreendimento = $empreendimento;
        $model->ativo = 1;

        if (isset($_POST['Modulo'])) {
            $model->setAttributes($_POST['Modulo']);

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
        $model = $this->loadModel($id, 'Modulo');


        if (isset($_POST['Modulo'])) {
            $model->setAttributes($_POST['Modulo']);

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
            $this->loadModel($id, 'Modulo')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Modulo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Modulo('search');
        $model->unsetAttributes();

        if (isset($_GET['Modulo']))
            $model->setAttributes($_GET['Modulo']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
