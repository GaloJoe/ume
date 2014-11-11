<?php

class EmpreendimentoController extends GxController {

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
            'model' => $this->loadModel($id, 'Empreendimento'),
        ));
    }

    public function actionCreate() {
        $model = new Empreendimento;

        if (isset($_POST['Empreendimento'])) {
            $model->setAttributes($_POST['Empreendimento']);
            $model->ativo = true;
            $model->comissao_adm_vendas = 0.0025;
            $model->comissao_corretor = 0.05;

            $images = CUploadedFile::getInstancesByName('images');
            $implantacaos = CUploadedFile::getInstancesByName('implantacaos');
            $implantacaofulls = CUploadedFile::getInstancesByName('implantacaofulls');

            // proceed if the images have been set
            if (isset($images)) {
                $logo_path = realpath(Yii::app()->basePath . '/../images/logo');
                foreach ($images as $image => $pic) {
                    $pic->saveAs($logo_path . '/' . $pic->name);
                    $model->logo = "images/logo/" . $pic->name;
                }
            }
            if (isset($implantacaos)) {
                $implantacao_path = realpath(Yii::app()->basePath . '/../images/implantacao');
                foreach ($implantacaos as $implantacao => $pic) {
                    $pic->saveAs($implantacao_path . '/' . $pic->name);
                    $model->implantacao = "images/implantacao/" . $pic->name;
                }
            }
            if (isset($implantacaofulls)) {
                $implantacaofull_path = realpath(Yii::app()->basePath . '/../images/implantacao');
                foreach ($implantacaofulls as $implantacaofull => $pic) {
                    $pic->saveAs($implantacaofull_path . '/' . $pic->name);
                    $model->logo = "images/implantacao/" . $pic->name;
                }
            }
            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end(); else
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Empreendimento');

        if (isset($_POST['Empreendimento'])) {
            $model->setAttributes($_POST['Empreendimento']);
            
            $images = CUploadedFile::getInstancesByName('images');
            $implantacaos = CUploadedFile::getInstancesByName('implantacaos');
            $implantacaofulls = CUploadedFile::getInstancesByName('implantacaofulls');
 
            // proceed if the images have been set
            if (isset($images)) {
                $logo_path = realpath(Yii::app()->basePath . '/../images/logo');
                foreach ($images as $image => $pic) {
                    $pic->saveAs($logo_path . '/' . $pic->name );
                    $model->logo = "images/logo/" . $pic->name;
                }
            }
            if (isset($implantacaos)) {
                $implantacao_path = realpath(Yii::app()->basePath . '/../images/implantacao');
                foreach ($implantacaos as $implantacao => $pic) {
                    $pic->saveAs($implantacao_path . '/' . $pic->name );
                    $model->implantacao = "images/implantacao/" . $pic->name;
                }
            }
            if (isset($implantacaofulls)) {
                $implantacaofull_path = realpath(Yii::app()->basePath . '/../images/implantacao');
                foreach ($implantacaofulls as $implantacaofull => $pic) {
                    $pic->saveAs($implantacaofull_path . '/' . $pic->name );
                    $model->implantacao_full = "images/implantacao/" . $pic->name;
                }
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
            $this->loadModel($id, 'Empreendimento')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Empreendimento');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Empreendimento('search');
        $model->unsetAttributes();

        if (isset($_GET['Empreendimento']))
            $model->setAttributes($_GET['Empreendimento']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
