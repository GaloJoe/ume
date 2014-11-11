<?php

class MaterialController extends GxController {

    public function actionView($id) {
        $material = $this->loadModel($id, 'Material');
        $chartData = $material->getChartData();

        $this->render('view', array(
            'model' => $material,
            'chartData' => $chartData,
        ));
    }

    public function actionCreate($cat) {
        $model = new Material;

        if (isset($_POST['Material'])) {
            $model->setAttributes($_POST['Material']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model, 'categoria' => $cat));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Material');


        if (isset($_POST['Material'])) {
            $model->setAttributes($_POST['Material']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id, 'Material');
        $model->ativo = 0;
        
        if ($model->update(array('ativo'))) {
            $this->redirect(array('material/view', 'id' => $id));
        }

        if (!Yii::app()->getRequest()->getIsAjaxRequest())
            $this->redirect(array('admin'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Material');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Material('search');
        $model->unsetAttributes();

        if (isset($_GET['Material']))
            $model->setAttributes($_GET['Material']);

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
