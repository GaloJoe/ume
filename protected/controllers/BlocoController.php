<?php

class BlocoController extends GxController {
    
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
            'model' => $this->loadModel($id, 'Bloco'),
        ));
    }

    public function actionCreate() {
        $model = new Bloco;


        if (isset($_POST['Bloco'])) {
            $model->setAttributes($_POST['Bloco']);
            $model->ativo = true;

            if ($model->save()) {
                $idBloco = $model->id;
                $andares = $model->empreendimento0->andares;
                
                if($andares != null && $andares > 0) {
                    for($i = 1; $i <= $andares; $i++) {
                        $andar = new Andar;

                        $andar->posicao = $i;

                        if($i == 1) {
                            $andar->descricao = "Térreo";
                        } else {
                            $andar->descricao = $i . "° Andar";
                        }

                        $andar->bloco = $idBloco;
                        $andar->ativo = 1;
                        
                        $andar->save();
                    }
                }
                
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $model->disponivel = 0;

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Bloco');


        if (isset($_POST['Bloco'])) {
            $model->setAttributes($_POST['Bloco']);

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
            $this->loadModel($id, 'Bloco')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Bloco');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Bloco('search');
        $model->unsetAttributes();

        if (isset($_GET['Bloco']))
            $model->setAttributes($_GET['Bloco']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
