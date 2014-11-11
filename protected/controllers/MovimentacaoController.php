<?php

class MovimentacaoController extends GxController {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Movimentacao'),
        ));
    }

    public function actionCreate($tm, $mat) {
        $erro = '';
        $existeErro = false;

        $material = 0;
        if ($mat != null) {
            $material = $mat;
        }

        if (isset($tm)) {
            $model = new Movimentacao;
            $model->tipo_movimentacao = $tm;

            $materialModel = Material::model()->findByPk($mat);

            if ($tm == TipoMovimentacaoEnum::ENTRADA) {
                $tipo = 'Entrada';
            } else {
                $tipo = 'Saída';
            }

            if (isset($_POST['Movimentacao'])) {
                $model->setAttributes($_POST['Movimentacao']);
                $model->data = $this->getData();
                $model->usuario = Yii::app()->user->id;

                if ($tm == TipoMovimentacaoEnum::ENTRADA) {
                    if ($materialModel->consumo < ($materialModel->getBought() + $model->quantidade)) {
                        $erro = 'Impossível comprar mais do que a quantidade Máxima do Material';
                        $existeErro = true;
                    }
                } else {
                    if ($materialModel->getBought() < ($materialModel->getUtilized() + $model->quantidade)) {
                        $erro = 'Impossível utilizar mais do que a quantidade Comprada';
                        $existeErro = true;
                    }
                }

                if (!$existeErro && $model->save()) {
                    if (Yii::app()->getRequest()->getIsAjaxRequest())
                        Yii::app()->end();
                    else
                        $this->redirect(array('material/view', 'id' => $material));
                }
            }

            $this->render('create', array('model' => $model, 'material' => $material, 'tipo' => $tipo, 'erroUsuario' => $erro));
        } else {
            $this->render('create', array('model' => $model, 'material' => $material, 'erroUsuario' => $erro));
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Movimentacao');


        if (isset($_POST['Movimentacao'])) {
            $model->setAttributes($_POST['Movimentacao']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id, $mat) {
//        if (Yii::app()->getRequest()->getIsPostRequest()) {
//            $this->loadModel($id, 'Movimentacao')->delete();
            $model = $this->loadModel($id, 'Movimentacao');
            $model->ativo = 0;
//            $this->loadModel($id, 'Usuario')->delete();
            if ($model->update(array('ativo'))) {
                $this->redirect(array('material/view', 'id' => $mat));
            }

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
//        } else
//            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Movimentacao');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Movimentacao('search');
        $model->unsetAttributes();

        if (isset($_GET['Movimentacao']))
            $model->setAttributes($_GET['Movimentacao']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    private function getData() {
        $tz_object = new DateTimeZone('Brazil/East');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d\ H:i:s');
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
