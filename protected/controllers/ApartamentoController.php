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
        if ($reserva && $historico->status == 'Reservado')
            $historico->status = 'Reserva Cancelada';
        else if ($reserva)
            $historico->status = 'Contratação Cancelada';
        else if ($historico->status == 'Permutado')
            $historico->status = 'Permuta Cancelada';
        else
            $historico->status = 'Venda Cancelada';

        $historico->update(array('ativo', 'status', 'vendido', 'data_cancelamento'));

        $mailHelper = new MailHelper();
        $mailHelper->sendCancelMail($historico);

        if (isset($_GET['ap']))
            $this->redirect(array('view', 'id' => $_GET['ap']));
        else
            $this->redirect('index');
    }

    public function actionReserva($ap) {
        if (isset($_POST['Historico'])) {
            $apartment = Apartamento::model()->findByPk($ap);
            if ($apartment->isReserved()) {
                $model = new Historico;
                $model->apartamento = $ap;

                $this->render('reserva', array('model' => $model, 'erro' => 'Apartamento já está reservado.'));
                exit;
            }
            if ($apartment->isSold()) {
                $model = new Historico;
                $model->apartamento = $ap;

                $this->render('reserva', array('model' => $model, 'erro' => 'Apartamento já está vendido.'));
                exit;
            }
            $model = new Historico;
            $model->setAttributes($_POST['Historico']);
            $model->data = $this->getData();
            if (isset(Yii::app()->session['usuario']) && Yii::app()->session['usuario'] != 0)
                $model->usuario = Yii::app()->session['usuario'];
            else
                $model->usuario = Yii::app()->user->id;

            if (trim($model->cliente_cpf) == "" && trim($model->cliente_nome) == "") {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('reserva', array('model' => $model, 'erro' => 'Nome e CPF são obrigatórios.'));
                exit;
            }

            if (trim($model->cliente_nome) == "") {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('reserva', array('model' => $model, 'erro' => 'Nome obrigatório.'));
                exit;
            }

            if (trim($model->cliente_cpf) == "") {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('reserva', array('model' => $model, 'erro' => 'CPF obrigatório.'));
                exit;
            }
            $model->status = "Reservado";
            $model->ativo = 1;
            $model->vendido = 0;
            $model->corretor_pago = 0;
            $model->adm_vendas_pago = 0;
            $model->apartamento = $ap;
            $criteria = new CDbCriteria;
            $criteria->condition = 'cliente_cpf=:cliente_cpf';
            $criteria->params = array(':cliente_cpf' => $model->cliente_cpf);
            $historicos = Historico::model()->findAll($criteria); // $params não é necessario

            if (count($historicos) > 0) {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('reserva', array('model' => $model, 'erro' => 'Este cliente já efetuou uma reserva.'));
            }

            if ($model->save()) {
                unset(Yii::app()->session['usuario']);
                $mailHelper = new MailHelper();
                $mailHelper->sendReserveMail($model);
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('view', 'id' => $model->apartamento));
            }
        } else if (((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && Yii::app()->session['usuario'] != 0 ||
                isset($_GET['res'])) || (!Yii::app()->user->isMaster() && !Yii::app()->user->isAdmin())) {
            $model = new Historico;
            if (isset($_GET['ap']))
                $model->apartamento = $_GET['ap'];
            else
                $this->actionIndex();

            if (isset(Yii::app()->session['usuario']) && Yii::app()->session['usuario'] != 0)
                $model->usuario = Yii::app()->session['usuario'];
            else
                $model->usuario = Yii::app()->user->id;

            $countReserves = $this->getCountReserves($model);
            {
                $logedUser = Usuario::model()->findByPk(Yii::app()->user->id);
                $imobiliaria = $logedUser->imobiliaria0;
            }

            if ($countReserves < 10 || ($imobiliaria->id == 10 && $countReserves < 30) || Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) {
                $this->render('reserva', array('model' => $model, 'erroUsuario' => '', 'erro' => ''));
            } else {
                $this->render('view', array('model' => $this->loadModel($ap, 'Apartamento'), 'erroUsuario' => 'Limite de reservas atingido', 'erro' => ''));
            }
        } else {
            $this->render('view', array('model' => $this->loadModel($ap, 'Apartamento'), 'erroUsuario' => '', 'erro' => 'Selecione um corretor'));
        }
    }

    private function getCountReserves($historico) {
        $count = 0;

        $usuario = $historico->usuario0->id;
        $imobiliaria = $historico->usuario0->imobiliaria0->id;
        $empreendimento = $historico->apartamento0->bloco0->empreendimento0->id;
        $ativo = 1;
        $vendido = 0;

        $historicos = Historico::model()->with('usuario0')->findAll('usuario0.imobiliaria=:imobiliaria AND vendido=:vendido AND t.ativo=:ativo', array(':imobiliaria' => $imobiliaria, ':vendido' => $vendido, ':ativo' => $ativo));

        foreach ($historicos as $h) {
            $now = $this->getData();
            $days = (strtotime($now) - strtotime(date($h->data))) / 86400; // == <seconds between the two times>

            if ($days <= $h->apartamento0->bloco0->empreendimento0->dias_reserva)
                $count++;
        }

        return $count;
    }

    private function getData() {
        $tz_object = new DateTimeZone('Brazil/East');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d\ H:i:s');
    }

    public function actionPermuta($ap) {
        if (isset($_POST['Historico'])) {
            $model = new Historico;
            $model->setAttributes($_POST['Historico']);

            if (trim($model->cliente_cpf) == "" && trim($model->cliente_nome) == "") {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('permutar', array('model' => $model, 'erroUsuario' => '', 'erro' => 'Nome e CPF são obrigatórios.'));
                exit;
            }

            if (trim($model->cliente_nome) == "") {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('permutar', array('model' => $model, 'erroUsuario' => '', 'erro' => 'Nome é obrigatório.'));
                exit;
            }

            if (trim($model->cliente_cpf) == "") {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('permutar', array('model' => $model, 'erroUsuario' => '', 'erro' => 'CPF é obrigatório.'));
                exit;
            }

            $model->valor_financiado_construtora = 0.00;
            $model->valor_financiado_caixa = 0.00;
            $model->valor_entrada = 0.00;

            $model->valor_venda = 0.00;

            $model->valor_comissao_corretor = 0.00;
            $model->valor_pagamento_adm_vendas = 0.00;

            $model->data = $this->getData();
            $model->status = "Permutado";
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
                $historicos = Historico::model()->findAll($criteria); // $params não é necessario
                foreach ($historicos as $historico) {
                    $historico = Historico::model()->findByPk($historico->id);
                    $historico->ativo = 0;
                    $historico->status = 'Reserva Permutada';
                    $historico->update(array('ativo', 'status'));
                }
                $mailHelper = new MailHelper();
                $mailHelper->sendPermutaMail($model);
                if (Yii::app()->getRequest()->getIsAjaxRequest())
                    Yii::app()->end();
                else
                    $this->redirect(array('view', 'id' => $model->apartamento));
            }
        } else if (((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && Yii::app()->session['usuario'] != 0 ||
                isset($_GET['res'])) || (!Yii::app()->user->isMaster() && !Yii::app()->user->isAdmin())) {
            $model = new Historico;
            if (isset($_GET['ap']))
                $model->apartamento = $_GET['ap'];
            else
                $this->actionIndex();

            if (isset($_GET['res'])) {
                $historico = Historico::model()->findByPk($_GET['res']);
                $model->cliente_nome = $historico->cliente_nome;
                $model->cliente_cpf = $historico->cliente_cpf;
            }

            $this->render('permutar', array('model' => $model, 'erroUsuario' => '', 'erro' => ''));
        } else {
            $this->render('view', array('model' => $this->loadModel($ap, 'Apartamento'), 'erroUsuario' => '', 'erro' => 'Selecione um corretor'));
        }
    }

    public function actionSell($ap) {
        if (isset($_POST['Historico'])) {
            $model = new Historico;
            $model->setAttributes($_POST['Historico']);

            if (trim($model->cliente_cpf) == "" && trim($model->cliente_nome) == "") {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('sell', array('model' => $model, 'erroUsuario' => '', 'erro' => 'Nome e CPF são obrigatórios.'));
                exit;
            }

            if (trim($model->cliente_nome) == "") {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('sell', array('model' => $model, 'erroUsuario' => '', 'erro' => 'Nome obrigatório'));
                exit;
            }

            if (trim($model->cliente_cpf) == "") {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('sell', array('model' => $model, 'erroUsuario' => '', 'erro' => 'CPF obrigatório.'));
                exit;
            }

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

            $model->valor_comissao_corretor = ($model->valor_venda - 3000.0) * 0.05;
            $model->valor_pagamento_adm_vendas = ($model->valor_venda - 3000.0) * 0.0025;

            $totalValores = (float) ($model->valor_entrada + $model->valor_financiado_construtora + $model->valor_financiado_caixa);

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

                        $historico->ativo = 0;
                        $historico->status = 'Reserva vendida';
                        $historico->update(array('ativo', 'status'));

                        $model->usuario = $historico->usuario;
                    } else if (isset(Yii::app()->session['usuario']))
                        $model->usuario = Yii::app()->session['usuario'];
                    else
                        $model->usuario = Yii::app()->user->id;
                }
                if ($model->save()) {
                    unset(Yii::app()->session['usuario']);

                    $this->desativaHistoricos($model->apartamento, $model->id, 'Reserva Vendida');

                    $mailHelper = new MailHelper();
                    $mailHelper->sendSellMail($model);
                    if (Yii::app()->getRequest()->getIsAjaxRequest())
                        Yii::app()->end();
                    else
                        $this->redirect(array('view', 'id' => $model->apartamento));
                }
            } else {
                $model = new Historico;
                $model->apartamento = $ap;
                $this->render('sell', array('model' => $model, 'erroUsuario' => '', 'erro' => 'Os valores (entrada, financiado pela construtora e pela caixa) somados devem ser o valor do apartamento.'));
            }
        } else if (((Yii::app()->user->isMaster() || Yii::app()->user->isAdmin()) && Yii::app()->session['usuario'] != 0 ||
                isset($_GET['res'])) || (!Yii::app()->user->isMaster() && !Yii::app()->user->isAdmin())) {
            $model = new Historico;
            if (isset($_GET['ap']))
                $model->apartamento = $_GET['ap'];
            else
                $this->actionIndex();

            if (isset($_GET['res'])) {
                $historico = Historico::model()->findByPk($_GET['res']);
                $model->cliente_nome = $historico->cliente_nome;
                $model->cliente_cpf = $historico->cliente_cpf;
            }

            $this->render('sell', array('model' => $model, 'erroUsuario' => '', 'erro' => ''));
        } else {
            $this->render('view', array('model' => $this->loadModel($ap, 'Apartamento'), 'erroUsuario' => '', 'erro' => 'Selecione um corretor'));
        }
    }

    private function desativaHistoricos($ap, $id, $status) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'apartamento=:ap AND ativo=:ativo AND id<>:historico';
        $criteria->params = array(':ap' => $ap, ':ativo' => 1, ':historico' => $id);
        $historicos = Historico::model()->findAll($criteria); // $params não é necessario
        foreach ($historicos as $historico) {
            $historico = Historico::model()->findByPk($historico->id);
            $historico->ativo = 0;
//            $historico->status = $status;
            $historico->update(array('ativo'));
        }
    }

    public function actionContratacao($ap) {
        if (isset($_GET['res'])) {
            $model = new Historico;
            if (isset($_GET['ap']))
                $model->apartamento = $_GET['ap'];
            else
                $this->actionIndex();

            if (isset($_GET['res'])) {
                $historico = Historico::model()->findByPk($_GET['res']);

                $historico->ativo = 0;
                $historico->status = 'Reserva em contratação';
                $historico->update(array('ativo', 'status'));

                $model->cliente_nome = $historico->cliente_nome;
                $model->cliente_cpf = $historico->cliente_cpf;
                $model->usuario = $historico->usuario;
            }

            $model->em_contratacao = 1;
            $model->data = $this->getData();
            $model->status = 'Em Contratação';
            $model->ativo = 1;

            if ($model->save()) {
                $this->desativaHistoricos($model->apartamento, $model->id, 'Reserva Em Contratação');

                $mailHelper = new MailHelper();
                $mailHelper->sendEmContratacaoMail($model);

                $this->redirect(array('view', 'id' => $model->apartamento));
            }
        }

        $this->render('view', array('model' => $this->loadModel($ap, 'Apartamento'), 'erroUsuario' => '', 'erro' => ''));
    }

    public function actionCreate($bloco) {
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

        $model->disponivel = 0;

        $this->render('create', array('model' => $model, 'bloco' => $bloco));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id, 'Apartamento');
        if (isset($_POST['Apartamento'])) {
            $model->setAttributes($_POST['Apartamento']);

            $model->valor = str_replace('R$', '', $model->valor);
            $pos = strrpos($model->valor, ",");
            if ($pos > 0) {
                $model->valor = str_replace('.', '', $model->valor);
                $model->valor = str_replace(',', '.', $model->valor);
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

    public function actionRel($idEmpreendimento) {
        $model = new Apartamento('search');
        $model->unsetAttributes();
        if (isset($_GET['Apartamento']))
            $model->setAttributes($_GET['Apartamento']);

        $model->empreendimento = $idEmpreendimento;

        $this->render('rel', array(
            'model' => $model,
            'idEmpreendimento' => $idEmpreendimento,
        ));
    }

    public function actionIndexEmpreendimento() {
        $dataProvider = new CActiveDataProvider('Empreendimento');
        $this->render('indexEmpreendimento', array(
            'dataProvider' => $dataProvider,
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

    public function actionPagarComissaoCorretor($res, $ap) {
        $model = Historico::model()->findByPk($res);

        if (isset($_POST['Historico'])) {
            $valorPago = $model->valor_pago_corretor;

            $model->setAttributes($_POST['Historico']);
            $model->valor_pago_corretor = str_replace('R$', '', $model->valor_pago_corretor);
            $model->valor_pago_corretor = str_replace('.', '', $model->valor_pago_corretor);
            $model->valor_pago_corretor = str_replace(',', '.', $model->valor_pago_corretor);

            $novoValorPago = $model->valor_pago_corretor;
            $model->valor_pago_corretor += $valorPago;

            $model->data_pagamento_corretor = $this->getData();

            if ($model->valor_pago_corretor <= $model->valor_comissao_corretor) {
                if ($model->save()) {
                    $mailHelper = new MailHelper();
                    $mailHelper->sendValorComissaoCorretorMail($model, $novoValorPago);
                    $this->redirect(array('view', 'id' => $ap));
                }
            } else {
                $model->valor_pago_corretor -= $novoValorPago;
                $valorTotal = $model->valorComissaoCorretor();
                $this->render('comissaoCorretor', array('model' => $model, 'erroUsuario' => '', 'erro' => 'Valor pago excederá valor total da comissão do corretor (' . $valorTotal . ')'));
            }
        } else {
            $this->render('comissaoCorretor', array('model' => $model, 'erroUsuario' => '', 'erro' => ''));
        }
    }

    public function actionAprovarFinanciamento($res, $ap) {
        $model = Historico::model()->findByPk($res);

        if (isset($_POST['Historico'])) {
            $model->setAttributes($_POST['Historico']);
            
            $model->data_aprovacao_financiamento = Yii::app()->dateFormatter->format("yyyy-MM-dd", strtotime($model->data_aprovacao_financiamento));
            
            if ($model->save()) {
//                $mailHelper = new MailHelper();
//                $mailHelper->sendValorComissaoCorretorMail($model, $novoValorPago);
                $this->redirect(array('view', 'id' => $ap));
            }
        } else {
            $this->render('aprovarFinanciamento', array('model' => $model, 'erroUsuario' => '', 'erro' => ''));
        }
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
                $mailHelper = new MailHelper();
                $mailHelper->sendComissaoCorretorMail($historico);
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
                $mailHelper = new MailHelper();
                $mailHelper->sendComissaoCorretorMeiaMail($historico);
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
                $mailHelper = new MailHelper();
                $mailHelper->sendComissaoAdmMail($historico);
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
            $historico->valor_pago_corretor = 0;

            if ($historico->save()) {
                $mailHelper = new MailHelper();
                $mailHelper->sendCancelarComissaoCorretorMail($historico);
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
                $mailHelper = new MailHelper();
                $mailHelper->sendCancelComissaoAdmMail($historico);
                $this->redirect(array('view', 'id' => $ap));
            }
        }
    }

    private function loadHistorico() {
        return new Historico;
    }

    public function actionListAvailable($idEmpreendimento) {
        $result = Apartamento::model()->searchByStatus('Disponível', $idEmpreendimento);

        $this->render('relStatus', array(
            'apartamentos' => $result,
            'idEmpreendimento' => $idEmpreendimento,
        ));
    }

    public function actionListHiring($idEmpreendimento) {
        $result = Apartamento::model()->searchByStatus('Em Contratação', $idEmpreendimento);

        $this->render('relStatus', array(
            'apartamentos' => $result,
            'idEmpreendimento' => $idEmpreendimento,
        ));
    }

    public function actionListSold($idEmpreendimento) {
        $result = Apartamento::model()->searchByStatus('Vendido', $idEmpreendimento, false);
        $resultAprovados = Apartamento::model()->searchByStatus('Vendido', $idEmpreendimento, true);

        $this->render('relStatus', array(
            'apartamentos' => $result,
            'apartamentosAprovados' => $resultAprovados,
            'idEmpreendimento' => $idEmpreendimento,
        ));
    }

    public function actionApproved($idEmpreendimento) {
        $result = Apartamento::model()->searchByStatus('Vendido', $idEmpreendimento, true);

        $this->render('relStatus', array(
            'apartamentos' => $result,
            'idEmpreendimento' => $idEmpreendimento,
        ));
    }

    public function actionListReserved($idEmpreendimento) {
        $result = Apartamento::model()->searchByStatus('Reservado', $idEmpreendimento);

        $this->render('relStatus', array(
            'apartamentos' => $result,
            'idEmpreendimento' => $idEmpreendimento,
        ));
    }

    public function actionListExchanged($idEmpreendimento) {
        $result = Apartamento::model()->searchByStatus('Permutado', $idEmpreendimento);

        $this->render('relStatus', array(
            'apartamentos' => $result,
            'idEmpreendimento' => $idEmpreendimento,
        ));
    }

    public function actionByBloco($atividade) {
        $historicoAtividade = new HistoricoAtividade();
//        $andares = Andar::model()->findAll('bloco=:bloco', array(':bloco' => (int) $_POST['bloco']));
        $andares = Andar::model()->findAll(array('order' => 'posicao', 'condition' => 'bloco=:bloco', 'params' => array(':bloco' => (int) $_POST['bloco'])));
        foreach ($andares as $andar) {
            echo '<p>';
            echo $andar->descricao . '<br>';
            $data = Apartamento::model()->findAll('andar=:andar', array(':andar' => $andar->id));
            foreach ($data as $value => $ap) {
                $checked = '';
                if ($historicoAtividade->hasSaved($ap->id, $atividade)) {
                    $checked = 'checked disabled';
                }
                echo '<input type="checkbox" name="Apartamento[' . $ap->id . ']" ' . $checked . '>' . $ap->descricao . '&nbsp;&nbsp;&nbsp;';
            }
            echo '</p>';
        }
    }

}
