<?php

class RetencaoController extends GxController {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Recibo'),
        ));
    }

    public function actionGenerateRecibo($id) {
        $this->render('recibo', array(
            'model' => $this->loadModel($id, 'Retencao'),
        ));
    }

    public function actionCreate($rec) {
        $model = new Retencao;
        $model->recibo = $rec;
        $erro = '';

        $recibo = Recibo::model()->findByPk($rec);

        $valorPagar = $recibo->getValorAPagar();

        if (isset($_POST['Retencao'])) {
            $model->setAttributes($_POST['Retencao']);

            $model->valor = str_replace('R$', '', $model->valor);
            $model->valor = str_replace('.', '', $model->valor);
            $model->valor = (float) str_replace(',', '.', $model->valor);

            if ($model->valor <= $valorPagar) {
                $model->usuario = Yii::app()->user->id;
                $model->ativo = 1;

                if ($model->save()) {
                    if (Yii::app()->getRequest()->getIsAjaxRequest())
                        Yii::app()->end();
                    else
                        $this->redirect(array('view', 'id' => $rec));
                }
            } else {
                $this->render('create', array('model' => $model, 'erro' => 'Valor não pode ser maior que valor a pagar!', 'valorPagar' => $valorPagar));
                exit;
            }
        }

        $this->render('create', array('model' => $model, 'erro' => $erro, 'valorPagar' => $valorPagar));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Retencao');


        if (isset($_POST['Retencao'])) {
            $model->setAttributes($_POST['Retencao']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id, $rec) {
        $model = $this->loadModel($id, 'Retencao');
        $model->ativo = 0;
        
        if ($model->update(array('ativo'))) {
            $this->redirect(array('retencao/view', 'id' => $rec));
        }

        if (!Yii::app()->getRequest()->getIsAjaxRequest())
            $this->redirect(array('admin'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Retencao');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin($usuario = null) {
        $emp = Yii::app()->session['empreendimento'];
        $model = new Recibo('search');
        $model->unsetAttributes();

        if (isset($_GET['Recibo']))
            $model->setAttributes($_GET['Recibo']);

        $model->empreendimento = $emp;
        if($usuario != null) {
            $model->empreiteiro = $usuario;
        }

        $this->render('admin', array(
            'model' => $model,
            'empreendimento' => $emp,
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
