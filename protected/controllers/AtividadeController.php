<?php

class AtividadeController extends GxController {

    public function actionView($id, $empreendimento=null) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Atividade'),
            'empreendimento' => $empreendimento,
        ));
    }

    public function actionCreate($emp) {
        $model = new Atividade;

        if (isset($_POST['Atividade'])) {
            $model->setAttributes($_POST['Atividade']);
            
            $model->ativo = 1;
            $model->valor_unitario = str_replace('R$', '', $model->valor_unitario);
            $model->valor_unitario = str_replace('.', '', $model->valor_unitario);
            $model->valor_unitario = str_replace(',', '.', $model->valor_unitario);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('view', 'id' => $model->id, 'empreendimento' => $emp));
            }
        }

        $this->render('create', array('model' => $model, 'empreendimento' => $emp));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Atividade');


        if (isset($_POST['Atividade'])) {
            $model->setAttributes($_POST['Atividade']);
            
            $model->valor_unitario = str_replace('R$', '', $model->valor_unitario);
            $pos = strrpos($model->valor_unitario, ",");
            if ($pos > 0) {
                $model->valor_unitario = str_replace('.', '', $model->valor_unitario);
                $model->valor_unitario = str_replace(',', '.', $model->valor_unitario);
            }

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
            $model = $this->loadModel($id, 'Atividade');
            $model->ativo = 0;
//            $this->loadModel($id, 'Usuario')->delete();
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Atividade');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin($emp) {
        $model = new Atividade('search');
        $model->unsetAttributes();

        if (isset($_GET['Atividade']))
        $model->setAttributes($_GET['Atividade']);

        $model->empreendimento = $emp;

        $this->render('admin', array(
            'model' => $model,
            'empreendimento' => $emp,
        ));
    }
    
    public function actionEmpreendimento() {
        $dataProvider = new CActiveDataProvider('Empreendimento');
        $this->render('empreendimento', array(
            'dataProvider' => $dataProvider,
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
