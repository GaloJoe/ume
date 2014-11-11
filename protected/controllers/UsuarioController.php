<?php

class UsuarioController extends GxController {
    
    public function actionSearchContracts($emp=1) {
        Usuario::model()->listWithContracts($emp);
    }
    
    public function actionEmpreiteiros($emp=1) {
        $this->render('empreiteiros', array(
            'model' => Usuario::model(),
            'empreendimento' => $emp,
        ));
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Usuario'),
        ));
    }

    public function actionCreate() {
        $model = new Usuario;

        $imobiliaria = 0;
        if (isset($_GET['imobiliaria'])) {
            $imobiliaria = $_GET['imobiliaria'];
        }

        $action = 'create';

        if (isset($_POST['Usuario'])) {
            $model->setAttributes($_POST['Usuario']);

            if (trim($model->senha) != '') {
                $model->ativo = true;
//                $model->perfil = 'normal';
                $model->senha = $model->hashPassword($model->senha);

                if ($model->save()) {
//                    if (Yii::app()->getRequest()->getIsAjaxRequest())
//                        Yii::app()->end();
//                    else
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                $this->render('create', array('model' => $model, 'imobiliaria' => $imobiliaria, 'action' => $action));
            }
        } else {
            $model->senha = '';

            $this->render('create', array('model' => $model, 'imobiliaria' => $imobiliaria, 'action' => $action));
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Usuario');

        if (isset($_POST['Usuario'])) {
            $model->setAttributes($_POST['Usuario']);
//            $model->senha = $model->hashPassword($model->senha);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $imobiliaria = 0;
        if (isset($_GET['imobiliaria'])) {
            $imobiliaria = $_GET['imobiliaria'];
        }

        $action = 'update';

        $this->render('update', array(
            'model' => $model,
            'imobiliaria' => $imobiliaria,
            'action' => $action,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = $this->loadModel($id, 'Usuario');
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
        $criteria = new CDbCriteria();

        $criteria->condition = 't.ativo=1';
        $criteria->with = array('imobiliaria0' => array('condition' => 'imobiliaria0.ativo=1'));
//        $criteria->params = array(':ativo' => 1);
//        $criteria->params = array(':iativo' => 1);

        $dataProvider = new CActiveDataProvider('Usuario', array('criteria' => $criteria, 'sort' => array('defaultOrder' => 't.nome')));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionUpdatePassword() {
        $model = $this->loadModel(Yii::app()->user->id, 'Usuario');

        if (isset($_POST['Usuario'])) {
            $model->setAttributes($_POST['Usuario']);
            if ($model->novaSenha == $model->confirmarSenha) {
                if ($model->novaSenha != '') {
                    $model->senha = $model->hashPassword($model->novaSenha);

                    if ($model->save()) {
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                } else {
                    $this->render('updatePassword', array('model' => $model, 'erro' => 'Senha inválida'));
                }
            } else {
                $this->render('updatePassword', array('model' => $model, 'erro' => 'Senhas não coincidem'));
            }
        } else {
            $this->render('updatePassword', array('model' => $model, 'erro' => ''));
        }
    }

    public function actionAdmin() {
        $model = new Usuario('search');
        $model->unsetAttributes();

        if (isset($_GET['Usuario']))
            $model->setAttributes($_GET['Usuario']);

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
