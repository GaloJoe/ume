<?php

class HistoricoAtividadeController extends GxController {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'HistoricoAtividade'),
        ));
    }

    public function actionCreate($a) {
        $model = new HistoricoAtividade;

        $atividade = Atividade::model()->findByPk($a);

        if (isset($_POST['UnidadeMedida'])) {
            $empreendimento = $_POST['UnidadeMedida']['empreendimento'];

            $model = new HistoricoAtividade;
            if ($this->save($model, $atividade, $empreendimento)) {
                $this->redirect(array('atividade/view', 'id' => $atividade->id));
            }
        } else if (isset($_POST['Apartamento'])) {
            $aps = $_POST['Apartamento'];
            $allSaved = true;
            foreach ($aps as $ap => $value) {
                $model = new HistoricoAtividade;
                if (!$this->save($model, $atividade, $ap)) {
                    $allSaved = false;
                    break;
                }
            }
            if ($allSaved) {
                $this->redirect(array('atividade/view', 'id' => $atividade->id));
            }
        } else if (isset($_POST['Andar'])) {
            $andares = $_POST['Andar'];
            $allSaved = true;
            foreach ($andares as $andar => $value) {
                $model = new HistoricoAtividade;
                if (!$this->save($model, $atividade, $andar)) {
                    $allSaved = false;
                    break;
                }
            }
            if ($allSaved) {
                $this->redirect(array('atividade/view', 'id' => $atividade->id));
            }
        } else if (isset($_POST['Bloco'])) {
            $blocos = $_POST['Bloco'];
            $allSaved = true;
            foreach ($blocos as $idBloco => $value) {
                if ($value == 1) {
                    $model = new HistoricoAtividade;
                    if (!$this->save($model, $atividade, $idBloco)) {
                        $allSaved = false;
                        break;
                    }
                }
            }
            if ($allSaved) {
                $this->redirect(array('atividade/view', 'id' => $atividade->id));
            }
        }

        $tabela = $atividade->unidadeMedida->tipoUnidadeMedida->tabela;
        $blocos = null;
        if ($tabela != TipoUnidadeMedidaEnum::EMPREENDIMENTO) {
            $blocos = Bloco::model()->findAllAttributes(null, true, 'empreendimento=' . $atividade->unidadeMedida->empreendimento);
        }

        $this->render('create', array('model' => $model, 'atividade' => $atividade, 'blocos' => $blocos, 'tipoUnidadeMedida' => $tabela));
    }

    private function save($model, $atividade, $referencia) {
        if ($model->hasSaved($referencia, $atividade->id)) {
            return true;
        }

        if (isset($_POST['HistoricoAtividade']) && isset($_POST['HistoricoAtividade']['empreiteiro'])) {
            $empreiteiro = $_POST['HistoricoAtividade']['empreiteiro'];
        }

        $retencao = 0;
        if (isset($_POST['HistoricoAtividade']) && isset($_POST['HistoricoAtividade']['retencao'])) {
            $retencao = $_POST['HistoricoAtividade']['retencao'];
            $retencao = str_replace('%', '', $retencao);
        }

        $model->ativo = 1;
        $model->atividade = $atividade->id;
        $model->referencia = $referencia;
        $model->data = $this->getData();
        $model->usuario = Yii::app()->user->id;
        $model->empreiteiro = $empreiteiro;
        $model->retencao = $retencao;

        if ($model->save()) {
            return true;
        }

        return false;
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'HistoricoAtividade');


        if (isset($_POST['HistoricoAtividade'])) {
            $model->setAttributes($_POST['HistoricoAtividade']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id, $at) {
        $model = $this->loadModel($id, 'HistoricoAtividade');
        $model->ativo = 0;
        if ($model->update(array('ativo'))) {
            $this->redirect(array('atividade/view', 'id' => $at));
        }

        if (!Yii::app()->getRequest()->getIsAjaxRequest())
            $this->redirect(array('admin'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('HistoricoAtividade');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new HistoricoAtividade('search');
        $model->unsetAttributes();

        if (isset($_GET['HistoricoAtividade']))
            $model->setAttributes($_GET['HistoricoAtividade']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionPesquisaRegistros($emp) {
        $dataProvider = new CActiveDataProvider('HistoricoAtividade', array(
            'criteria' => array(
                'condition' => 'empreiteiro=0',
            ),
        ));

        if (isset($_POST['Recibo'])) {
            $recibo = new Recibo();
            $recibo->setAttributes($_POST['Recibo']);

            if ($recibo->data_inicial == null || $recibo->data_inicial == '' || $recibo->data_final == null || $recibo->data_final == '') {
                $this->render('search', array('model' => new Recibo(), 'dataProvider' => $dataProvider, 'recibo' => null, 'total_recibo' => null, 'erro' => 'Data inicial e final são obrigatórias.', 'empreendimento' => $emp));
            } else if ($recibo->empreiteiro0 == null) {
                $this->render('search', array('model' => new Recibo(), 'dataProvider' => $dataProvider, 'recibo' => null, 'total_recibo' => null, 'erro' => 'Empreiteiro é obrigatório.', 'empreendimento' => $emp));
            } else {
                $criteria = $recibo->getCriteria($emp);
                
                $dataProvider = new CActiveDataProvider('Atividade', array(
                    'criteria' => $criteria,
                ));

                $recibo->data_inicial = $recibo->arrayToSqlDate($recibo->data_inicial);
                $recibo->data_final = $recibo->arrayToSqlDate($recibo->data_final);

                $total = $recibo->getTotalRecibo($emp);

                Yii::app()->session['recibo'] = $recibo;
                Yii::app()->session['totalRecibo'] = $total;

                $this->render('search', array('model' => new Recibo(), 'dataProvider' => $dataProvider, 'recibo' => $recibo, 'total_recibo' => $total, 'erro' => '', 'empreendimento' => $emp));
            }
        } else {
            $this->render('search', array('model' => new Recibo(), 'dataProvider' => $dataProvider, 'recibo' => null, 'total_recibo' => null, 'erro' => '', 'empreendimento' => $emp));
        }
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
