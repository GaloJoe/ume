<?php

class HistoricoController extends GxController {
    
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
            'model' => $this->loadModel($id, 'Historico'),
        ));
    }
    
    public function actionCreate() {
        $model = new Historico;

        if(isset($_GET['ap']))
            $model->apartamento = $_GET['ap'];
        else
            $this->actionIndex();
        
        $model->data = date('Y-m-d');
        $model->usuario = Yii::app()->user->id;
        $model->status = "Reservado";
        $model->ativo = 1;

        if ($model->save()) {
            if (Yii::app()->getRequest()->getIsAjaxRequest())
                Yii::app()->end();
            else
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Historico');


        if (isset($_POST['Historico'])) {
            $model->setAttributes($_POST['Historico']);

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
            $this->loadModel($id, 'Historico')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $criteria = new CDbCriteria;

        $criteria->condition = "vendido=1 AND ativo=1";
        
        $dataProvider = new CActiveDataProvider('Historico', array('criteria'=>$criteria));
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
    
    public function actionAdmin($idEmpreendimento) {
        $model = new Historico('search');
        $model->unsetAttributes();
        
        if(!Yii::app()->user->isMaster() && !Yii::app()->user->isAdmin()) {
            $usuario = new Usuario();
            $usuario = Usuario::model()->findByPk(Yii::app()->user->id);
            if($usuario->corretor_chefe == 1) {
                $model->imobiliaria = $usuario->imobiliaria0->id;
            } else {
                $model->usuario = $usuario->id;
            }
        }
        
        if (isset($_GET['Historico']))
            $model->setAttributes($_GET['Historico']);
        
        $model->empreendimento = $idEmpreendimento;

        $this->render('admin', array(
            'model' => $model,
        ));
        
    }

}
