<?php

class ReciboController extends GxController {

    public function actionGenerateRecibo($emp = null, $id = null) {
        if (isset(Yii::app()->session['recibo']) || $id != null) {
            $new = true;

            if ($id != null) {
                $recibo = Recibo::model()->findByPk($id);
                $new = false;
            } else {
                $recibo = Yii::app()->session['recibo'];
                
                $recibo->empreendimento = $emp;
                $recibo->usuario = Yii::app()->user->id;
                $recibo->ativo = 1;
                
                $recibo->save();
            }

            $total = $recibo->getTotalRecibo($emp, $new);
            
            $criteria = $recibo->getCriteria($emp, $new);
            $atividades = Atividade::model()->findAll($criteria);

            $this->setReciboToAtividades($recibo, $atividades);

            $this->render('recibo', array('model' => $recibo, 'atividades' => $atividades, 'total_recibo' => $total));
        }
    }

    private function setReciboToAtividades($model, $atividades) {
        foreach ($atividades as $atividade) {
            foreach ($atividade->historicoAtividades as $historicoAtividade) {
                if ($historicoAtividade->empreiteiro0->id == $model->empreiteiro && $historicoAtividade->ativo == 1) {
                    if (($model->data_inicial == null || $model->data_inicial == '' || strtotime($historicoAtividade->data) >= strtotime($model->data_inicial . ' 00:00:00')) &&
                            ($model->data_final == null || $model->data_final == '' || strtotime($historicoAtividade->data) <= strtotime($model->data_final . ' 23:59:59')) ||
                            ($historicoAtividade->recibo != null)) {
                        //Atualiza o histórico atividade, setando o id do recibo p/ ele
                        if ($historicoAtividade->recibo == null) {
                            $historicoAtividade->recibo = $model->id;
                            $historicoAtividade->update(array('recibo'));
                        }
                    }
                }
            }
        }
    }

    public function actionView($id) {
//        $this->render('view', array(
//            'model' => $this->loadModel($id, 'Recibo'),
//        ));
        $this->actionGenerateRecibo(null, $id);
    }

    public function actionCreate() {
        $model = new Recibo;

        if (isset($_POST['Recibo'])) {
            $model->setAttributes($_POST['Recibo']);

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
        $model = $this->loadModel($id, 'Recibo');


        if (isset($_POST['Recibo'])) {
            $model->setAttributes($_POST['Recibo']);

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
            $model = $this->loadModel($id, 'Recibo');

            $historicosAtividade = HistoricoAtividade::model()->findAllAttributes(null, true, 'recibo = ' . $model->id);
            foreach ($historicosAtividade as $historicoAtividade) {
                $historicoAtividade->recibo = null;
                $historicoAtividade->update(array('recibo'));
            }

            $model->ativo = 0;
            $model->update(array('ativo'));

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Recibo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $emp = Yii::app()->session['empreendimento'];
        $model = new Recibo('search');
        $model->unsetAttributes();

        if (isset($_GET['Recibo']))
            $model->setAttributes($_GET['Recibo']);
        
        $model->empreendimento = $emp;

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
