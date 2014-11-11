<?php

class ApartamentoController extends GxController {

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
        unset(Yii::app()->session['usuario']);
        Yii::app()->session['ap'] = $id;
        $this->render('view', array(
            'model' => $this->loadModel($id, 'Apartamento'),
            'historico' => $this->loadHistorico(),
            'erroUsuario' => '',
            'erro' => ''
        ));
    }

    public function actionCancel() {
        $historico = new Historico;
        $reserva = true;

        if (isset($_GET['res']))
            $historico->id = $_GET['res'];
        else if (isset($_GET['sell'])) {
            $historico->id = $_GET['sell'];
            $reserva = false;
        } else
            $this->actionIndex();

        $historico = Historico::model()->findByPk($historico->id);
        $historico->ativo = 0;
        $historico->vendido = 0;
        $historico->data_cancelamento = $this->getData();

        if ($reserva)
            $historico->status = 'Reserva Cancelada';
        else
            $historico->status = 'Venda Cancelada';

        $historico->update(array('ativo', 'status', 'vendido', 'data_cancelamento'));

        if (isset($_GET['ap']))
            $this->redirect(array('view', 'id' => $_GET['ap']));
        else
            $this->redirect('index');
    }

    public function actionReserva($ap) {
        if (((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && Yii::app()->session['usuario'] != 0) ||
                (!Yii::app()->user->isMaster() && !Yii::app()->user->isAdmin())) {
            $model = new Historico();

            if (isset($ap))
                $model->apartamento = $ap;
            else
                $this->actionIndex();

            $model->data = $this->getData();
            if (isset(Yii::app()->session['usuario']) && Yii::app()->session['usuario'] != 0)
                $model->usuario = Yii::app()->session['usuario'];
            else
                $model->usuario = Yii::app()->user->id;
            $model->status = "Reservado";
            $model->ativo = 1;
            $model->vendido = 0;
            $model->corretor_pago = 0;
            $model->adm_vendas_pago = 0;
            
            $countReserves = $this->getCountReserves($model);

            if($countReserves < 5) {
                if ($model->save()) {
                    unset(Yii::app()->session['usuario']);

                    $mailHelper = new MailHelper();
                    $mailHelper->sendReserveMail($model);

                    if (Yii::app()->getRequest()->getIsAjaxRequest())
                        Yii::app()->end();
                    else
                        $this->redirect(array('view', 'id' => $model->apartamento));
                }
            } else {
                $this->render('view', array('model' => $this->loadModel($ap, 'Apartamento'), 'erroUsuario' => 'Limite de reservas pela imobiliária atingido'));
            }
        } else
            $this->render('view', array('model' => $this->loadModel($ap, 'Apartamento'), 'erroUsuario' => '', 'erro' => 'Selecione um corretor'));
    }
    
    private function getCountReserves($historico) {
        $count = 0;
        
        $usuario = $historico->usuario0->id;
        $empreendimento = $historico->apartamento0->bloco0->empreendimento0->id;
        $ativo = 1;
        $vendido = 0;
        
        $data = Historico::model()->findAll('usuario=:usuario AND vendido=:vendido AND ativo=:ativo', array(':usuario' => $usuario, ':vendido' => $vendido ,':ativo' => $ativo));
        foreach ($data as $h) {
            $dt = new DateTime($h->data);
            $date = strtotime($dt->format('Y-m-d'));
            
            $reserve = strtotime(date('Y-m-d'));
            if($reserve == $date) {
                $count++;
            }
        }
        
        return $count;
    }

    private function getData() {
        $tz_object = new DateTimeZone('Brazil/East');
        //date_default_timezone_set('Brazil/East'); 
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d\ H:i:s');
    }

    public function actionSell($ap) {
        if (isset($_POST['Historico'])) {
            $model = new Historico;
            $model->setAttributes($_POST['Historico']);

            $model->valor_financiado_construtora = str_replace('R$', '', $model->valor_financiado_construtora);
            $model->valor_financiado_construtora = str_replace('.', '', $model->valor_financiado_construtora);
            $model->valor_financiado_construtora = str_replace(',', '.', $model->valor_financiado_construtora);

            $model->valor_financiado_caixa = str_replace('R$', '', $model->valor_financiado_caixa);
            $model->valor_financiado_caixa = str_replace('.', '', $model->valor_financiado_caixa);
            $model->valor_financiado_caixa = str_replace(',', '.', $model->valor_financiado_caixa);

            $model->valor_entrada = str_replace('R$', '', $model->valor_entrada);
            $model->valor_entrada = str_replace('.', '', $model->valor_entrada);
            $model->valor_entrada = str_replace(',', '.', $model->valor_entrada);

            $apartamento = Apartamento::model()->findByPk($ap);
            $model->valor_venda = $apartamento->valor;
            
            $model->valor_comissao_corretor = $model->valor_venda * 0.05;
            $model->valor_pagamento_adm_vendas = $model->valor_venda * 0.0025;

            $totalValores = (float)($model->valor_entrada + $model->valor_financiado_construtora + $model->valor_financiado_caixa);
            if ($totalValores == $model->valor_venda) {
                $model->data = $this->getData();
                $model->status = "Vendido";
                $model->ativo = 1;
                $model->vendido = 1;
                $model->corretor_pago = 0;
                $model->adm_vendas_pago = 0;
                $model->apartamento = $ap;

                if (((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && Yii::app()->session['usuario'] != 0 ||
                        isset($_GET['res'])) || (!Yii::app()->user->isMaster() && !Yii::app()->user->isAdmin())) {
                    if (isset($_GET['res'])) {
                        $idHistorico = $_GET['res'];
                        $historico = Historico::model()->findByPk($idHistorico); // $params não é necessario
                        $model->usuario = $historico->usuario;
                    } else if (isset(Yii::app()->session['usuario']))
                        $model->usuario = Yii::app()->session['usuario'];
                    else
                        $model->usuario = Yii::app()->user->id;
                }

                if ($model->save()) {
                    unset(Yii::app()->session['usuario']);

                    $criteria = new CDbCriteria;
                    $criteria->condition = 'apartamento=:ap AND ativo=:ativo AND id<>:historico';
                    $criteria->params = array(':ap' => $model->apartamento, ':ativo' => 1, ':historico' => $model->id);
                    
                    $mailHelper = new MailHelper();
                    $mailHelper->sendSellMail($model);

                    $historicos = Historico::model()->findAll($criteria); // $params não é necessario

                    foreach ($historicos as $historico) {
                        $historico = Historico::model()->findByPk($historico->id);
                        $historico->ativo = 0;
                        $historico->status = 'Reserva Cancelada';
                        $historico->update(array('ativo', 'status'));
                    }
                    if (Yii::app()->getRequest()->getIsAjaxRequest())
                        Yii::app()->end();
                    else
                        $this->redirect(array('view', 'id' => $model->apartamento));
                }
            } else {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('sell', array('model' => $model, 'erro' => 'Os valores (entrada, financiado pela construtora e pela caixa) somados devem ser o valor do apartamento.'));
            }
        } else if (((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && Yii::app()->session['usuario'] != 0 ||
                isset($_GET['res'])) || (!Yii::app()->user->isMaster() && !Yii::app()->user->isAdmin())) {
            $model = new Historico;

            if (isset($_GET['ap']))
                $model->apartamento = $_GET['ap'];
            else
                $this->actionIndex();

            $this->render('sell', array('model' => $model, 'erroUsuario' => '', 'erro' => ''));
        } else {
            $this->render('view', array('model' => $this->loadModel($ap, 'Apartamento'), 'erroUsuario' => '', 'erro' => 'Selecione um corretor'));
        }
    }

    public function actionCreate() {
        $model = new Apartamento;

        if (isset($_POST['Apartamento'])) {
            $model->setAttributes($_POST['Apartamento']);
            $model->ativo = true;

            $model->valor = str_replace('R$', '', $model->valor);
            $model->valor = str_replace('.', '', $model->valor);
            $model->valor = str_replace(',', '.', $model->valor);

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
        $model = $this->loadModel($id, 'Apartamento');

        if (isset($_POST['Apartamento'])) {
            $model->setAttributes($_POST['Apartamento']);

            $model->valor = str_replace('R$', '', $model->valor);
            $model->valor = str_replace('.', '', $model->valor);
            $model->valor = str_replace(',', '.', $model->valor);

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
            $this->loadModel($id, 'Apartamento')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(array('admin'));
        } else
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Apartamento');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Apartamento('search');
        $model->unsetAttributes();

        if (isset($_GET['Apartamento']))
            $model->setAttributes($_GET['Apartamento']);

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionRel() {
        $model = new Apartamento('search');
        $model->unsetAttributes();

        if (isset($_GET['Apartamento']))
            $model->setAttributes($_GET['Apartamento']);

        $this->render('rel', array(
            'model' => $model,
        ));
    }

    public function actionDetail($id) {
        $this->render('detail', array(
            'model' => $this->loadModel($id, 'Apartamento'),
        ));
    }

    public function actionUsuariosByImobiliaria() {
        $data = Usuario::model()->findAll('imobiliaria=:imobiliaria', array(':imobiliaria' => (int) $_POST['imobiliaria']));

        $data = CHtml::listData($data, 'id', 'nome');
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('Selecionar corretor'), true);
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

    public function actionSetUsuario() {
        Yii::app()->session['usuario'] = $_POST['usuario'];
    }

    public function actionConfirmarComissaoCorretor() {
        $historico = Historico::model();

        if (isset($_GET['res']) && isset($_GET['ap'])) {
            $id = $_GET['res'];
            $ap = $_GET['ap'];

            $historico = Historico::model()->findByPk($id);
            $historico->corretor_pago = 1;
            $historico->data_pagamento_corretor = $this->getData();

            if ($historico->save()) {
                $this->redirect(array('view', 'id' => $ap));
            }
        }
    }

    public function actionConfirmarComissaoCorretorMeia() {
        $historico = Historico::model();

        if (isset($_GET['res']) && isset($_GET['ap'])) {
            $id = $_GET['res'];
            $ap = $_GET['ap'];

            $historico = Historico::model()->findByPk($id);
            $historico->corretor_pago_meia = 1;
            $historico->data_pagamento_corretor_meia = $this->getData();

            if ($historico->save()) {
                $this->redirect(array('view', 'id' => $ap));
            }
        }
    }

    public function actionConfirmarComissaoAdm() {
        $historico = Historico::model();

        if (isset($_GET['res']) && isset($_GET['ap'])) {
            $id = $_GET['res'];
            $ap = $_GET['ap'];

            $historico = Historico::model()->findByPk($id);
            $historico->adm_vendas_pago = 1;
            $historico->data_pagamento_adm_vendas = $this->getData();

            if ($historico->save()) {
                $this->redirect(array('view', 'id' => $ap));
            }
        }
    }

    public function actionCancelarComissaoCorretor() {
        $historico = Historico::model();

        if (isset($_GET['res']) && isset($_GET['ap'])) {
            $id = $_GET['res'];
            $ap = $_GET['ap'];

            $historico = Historico::model()->findByPk($id);
            $historico->corretor_pago = 0;
            $historico->corretor_pago_meia = 0;

            if ($historico->save()) {
                $this->redirect(array('view', 'id' => $ap));
            }
        }
    }

    public function actionCancelarComissaoAdm() {
        $historico = Historico::model();

        if (isset($_GET['res']) && isset($_GET['ap'])) {
            $id = $_GET['res'];
            $ap = $_GET['ap'];

            $historico = Historico::model()->findByPk($id);
            $historico->adm_vendas_pago = 0;

            if ($historico->save()) {
                $this->redirect(array('view', 'id' => $ap));
            }
        }
    }

    private function loadHistorico() {
        return new Historico;
    }

}