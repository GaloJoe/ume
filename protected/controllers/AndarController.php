<?php

class AndarController extends GxController {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Andar'),
        ));
    }

    public function actionCreate() {
        $model = new Andar;


        if (isset($_POST['Andar'])) {
            $model->setAttributes($_POST['Andar']);

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
        $model = $this->loadModel($id, 'Andar');


        if (isset($_POST['Andar'])) {
            $model->setAttributes($_POST['Andar']);

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
            $this->loadModel($id, 'Andar')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Andar');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Andar('search');
        $model->unsetAttributes();

        if (isset($_GET['Andar']))
            $model->setAttributes($_GET['Andar']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionByBloco($atividade) {
        $historicoAtividade = new HistoricoAtividade();
//        $andares = Andar::model()->findAll('bloco=:bloco', array(':bloco' => (int) $_POST['bloco']));
        $andares = Andar::model()->findAll(array('order'=>'posicao', 'condition'=>'bloco=:bloco', 'params' => array(':bloco' => (int) $_POST['bloco'])));
        foreach($andares as $andar) {
            echo '<p>';
            $checked = '';
            if ($historicoAtividade->hasSaved($andar->id, $atividade)) {
                $checked = 'checked disabled';
            }
            echo '<input type="checkbox" name="Andar[' . $andar->id . ']" ' . $checked . '>'. $andar->descricao . '&nbsp;&nbsp;&nbsp;';
            echo '</p>'; 
        }
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
