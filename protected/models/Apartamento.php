<?php

Yii::import('application.models._base.BaseApartamento');

class Apartamento extends BaseApartamento {

    private $historico;
    private $historicoModel;
    private $historicoEmContratacao;
    private $historicoEmContratacaoModel;
    private $historicoSold;
    private $historicoSoldModel;
    
    public $cliente_nome = '-';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function isSold() {
        $isSold = false;

        $criteria = new CDbCriteria;
        $criteria->condition = 'apartamento=:ap AND vendido=:vendido AND ativo=:ativo';
        $criteria->params = array(':ap' => $this->id, ':vendido' => 1, ':ativo' => 1);

        $historicos = Historico::model()->findAll($criteria); // $params não é necessario

        if (count($historicos) > 0) {
            $isSold = true;
            $this->historicoSold = $historicos[0]->id;
            $this->historicoSoldModel = $historicos[0];
        }

        return $isSold;
    }

    public function isPermutado() {
        $isSold = false;

        $criteria = new CDbCriteria;
        $criteria->condition = 'apartamento=:ap AND vendido=:vendido AND status=:status AND ativo=:ativo';
        $criteria->params = array(':ap' => $this->id, ':vendido' => 1, ':status' => 'Permutado', ':ativo' => 1);

        $historicos = Historico::model()->findAll($criteria); // $params não é necessario

        if (count($historicos) > 0) {
            $isSold = true;
            $this->historicoSold = $historicos[0]->id;
            $this->historicoSoldModel = $historicos[0];
        }

        return $isSold;
    }

    public function isEmContratacao() {
        $isEmContratacao = false;

        $criteria = new CDbCriteria;
        $criteria->condition = 'apartamento=:ap AND em_contratacao=:em_contratacao AND ativo=:ativo';
        $criteria->params = array(':ap' => $this->id, ':em_contratacao' => 1, ':ativo' => 1);

        $historicos = Historico::model()->findAll($criteria); // $params não é necessario

        if (count($historicos) > 0) {
            $isEmContratacao = true;
            $this->historicoEmContratacao = $historicos[0]->id;
            $this->historicoEmContratacaoModel = $historicos[0];
        }


        return $isEmContratacao;
    }

    public function isReserved($emContratacao = false) {
        $isReserved = false;

        $criteria = new CDbCriteria;
        $criteria->condition = 'apartamento=:ap AND ativo=:ativo';
        $criteria->params = array(':ap' => $this->id, ':ativo' => 1);

        $historicos = Historico::model()->findAll($criteria); // $params não é necessario

        foreach ($historicos as $historico) {
//            $now = date('Y-m-d');
            $now = $this->getData();
            $days = (strtotime($now) - strtotime(date($historico->data))) / 86400; // == <seconds between the two times>
            if ($days <= $this->bloco0->empreendimento0->dias_reserva) {
                $isReserved = true;
                $this->historico = $historico->id;
                $this->historicoModel = $historico;
                break;
            }
        }

        return $isReserved;
    }

    public function getBloco() {
        return str_replace("Bloco ", "", $this->bloco0);
    }

    public function getStatus() {
        if ($this->isPermutado()) {
            return "Permutado";
        } else if ($this->isSold()) {
            if($this->getSellModel()->data_aprovacao_financiamento != null) {
                return "Financiamento Aprovado";
            }
            return "Vendido";
        } else if ($this->isEmContratacao()) {
            return "Em Contratação";
        } else if ($this->isReserved()) {
            return "Reservado";
        } else {
            return "Disponível";
        }
    }

    public function getDataEfetiva() {
        if ($this->isSold()) {
            return $this->formatDate($this->historicoSoldModel->data);
        } else if ($this->isReserved()) {
            return $this->formatDate($this->historicoModel->data);
        } else {
            return "-";
        }
    }

    public function getDataEfetivaSemHoras() {
        if ($this->isSold()) {
            return $this->formatDateWithoutTime($this->historicoSoldModel->data);
        } else if ($this->isReserved()) {
            return $this->formatDateWithoutTime($this->historicoModel->data);
        } else {
            return "-";
        }
    }

    public function getCorretor() {
        if ($this->isSold()) {
            return $this->historicoSoldModel->usuario0->nome;
        } else if ($this->isReserved()) {
            return $this->historicoModel->usuario0->nome;
        } else {
            return "-";
        }
    }

    public function getCliente() {
        if ($this->isSold()) {
            return $this->historicoSoldModel->cliente_nome;
        } else if ($this->isReserved()) {
            return $this->historicoModel->cliente_nome;
        } else {
            return "-";
        }
    }

    public function getClienteCpf() {
        if ($this->isSold()) {
            return $this->historicoSoldModel->cliente_cpf;
        } else if ($this->isReserved()) {
            return $this->historicoModel->cliente_cpf;
        } else {
            return "-";
        }
    }

    public function getStatusComissaoCorretor() {
        if ($this->isSold())
            return $this->historicoSoldModel->statusCorretor();

        return "-";
    }

    public function valorComissaoCorretor() {
        if ($this->isSold())
            return $this->historicoSoldModel->valorComissaoCorretor();

        return "-";
    }

    public function valorAPagarCorretor() {
        if ($this->isSold())
            return $this->historicoSoldModel->valorAPagarCorretor();

        return "-";
    }

    public function getDataPagamentoCorretor() {
        if ($this->isSold())
            return $this->historicoSoldModel->dataPagamentoCorretor();

        return "-";
    }

    public function getDataPagamentoCorretorMeia() {
        if ($this->isSold())
            return $this->historicoSoldModel->dataPagamentoCorretorMeia();

        return "-";
    }

    public function getStatusComissaoAdm() {
        if ($this->isSold())
            return $this->historicoSoldModel->statusAdmVendas();

        return "-";
    }

    public function getDataPagamentoAdm() {
        if ($this->isSold())
            return $this->historicoSoldModel->dataPagamentoAdm();

        return "-";
    }

    public function getValorTotal() {
        return 'R$' . number_format($this->valor, 2, ',', '.');
    }

    public function getValorVenda() {
        if ($this->isSold())
            return 'R$' . number_format($this->historicoSoldModel->valor_venda, 2, ',', '.');
//            return $this->historicoSoldModel->valorVenda();

        return "-";
    }

    public function getValorVendaTeste() {
        return 'R$' . number_format($this->historicoSoldModel->valor_venda, 2, ',', '.');
    }

    public function getValorEntrada() {
        if ($this->isSold())
            return $this->historicoSoldModel->valorEntrada();

        return "-";
    }

    public function getValorConstrutora() {
        if ($this->isSold())
            return $this->historicoSoldModel->financiadoConstrutora();

        return "-";
    }

    public function getValorCaixa() {
        if ($this->isSold())
            return $this->historicoSoldModel->financiadoCaixa();

        return "-";
    }

    public function getValorCorretor() {
        if ($this->isSold())
            return $this->historicoSoldModel->valorComissaoCorretor();

        return "-";
    }

    public function getValorAdmVendas() {
        if ($this->isSold())
            return $this->historicoSoldModel->valorComissaoAdmVendas();

        return "-";
    }

    public function getEmContratacao() {
        return $this->historicoEmContratacao;
    }

    public function getReserve() {
        return $this->historico;
    }

    public function getSell() {
        return $this->historicoSold;
    }

    public function getEmContratacaoModel() {
        return $this->historicoEmContratacaoModel;
    }

    public function getReserveModel() {
        return $this->historicoModel;
    }

    public function getSellModel() {
        return $this->historicoSoldModel;
    }

    public function getCompradorHistorico($id) {
        $model = Historico::model();
        $model = $model->findByPk($id);

        return $model->cliente_nome;
    }

    public function getUsuarioHistorico($id) {
        $model = Historico::model();
        $model = $model->findByPk($id);

        $usuario = Usuario::model();
        $usuario = $usuario->findByPk($model->usuario);

        return $usuario;
    }

    public function getImobiliariaHistorico($id) {
        $model = Historico::model();
        $model = $model->findByPk($id);

        $usuario = Usuario::model();
        $usuario = $usuario->findByPk($model->usuario);

        $imobiliaria = Imobiliaria::model();
        $imobiliaria = $imobiliaria->findByPk($usuario->imobiliaria);

        return $imobiliaria;
    }

    public function getLeftDaysOfReserve($id) {
        $historico = Historico::model()->findByPk($id);

        $now = $this->getData();
        $leftSeconds = (strtotime($now) - strtotime(date($historico->data)));

        $secondsInAMinute = 60;
        $secondsInAnHour = 60 * $secondsInAMinute;
        $secondsInADay = 24 * $secondsInAnHour;

        $reservedDays = floor($leftSeconds / $secondsInADay);

        $leftDays = $this->bloco0->empreendimento0->dias_reserva - $reservedDays;

        return $leftDays;
    }

    public function corretorIsPaid($id) {
        $historico = Historico::model()->findByPk($id);
        if ($historico->corretor_pago) {
            return true;
        }

        return false;
    }

    public function corretorIsHalfPaid($id) {
        $historico = Historico::model()->findByPk($id);
        if ($historico->corretor_pago_meia) {
            return true;
        }

        return false;
    }

    public function admIsPaid($id) {
        $historico = Historico::model()->findByPk($id);
        if ($historico->adm_vendas_pago) {
            return true;
        }

        return false;
    }

    public function getLeftDays($id) {
        $historico = Historico::model()->findByPk($id);
        return $this->formatDate($historico->data);
    }

    public function getData() {
        $tz_object = new DateTimeZone('Brazil/East');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d\ H:i:s');
    }

    public function formatDate($data) {
        $datetime = new DateTime($data, new DateTimeZone('Brazil/East'));
        return $datetime->format('d\/m\/Y\ H:i:s');
    }

    public function formatDateWithoutTime($data) {
        $datetime = new DateTime($data, new DateTimeZone('Brazil/East'));
        return $datetime->format('d\/m\/Y');
    }

    public function searchTotalsByModulo() {
        $select = 'bloco0.modulo as modulo, SUM(t.valor_venda) as valor_venda, SUM(t.valor_entrada) as valor_entrada';
        $select .= ', SUM(CASE WHEN t.status = "Vendido" AND t.corretor_pago = 1 THEN t.valor_comissao_corretor WHEN t.status = "Vendido" AND t.corretor_pago_meia THEN (t.valor_comissao_corretor * 0.5) WHEN t.status = "Vendido" AND t.valor_pago_corretor IS NOT NULL THEN t.valor_pago_corretor ELSE 0 END) as valor_comissao_corretor';
        $select .= ', SUM(CASE WHEN t.status = "Vendido" AND t.adm_vendas_pago = 1 THEN t.valor_pagamento_adm_vendas ELSE 0 END) as valor_pagamento_adm_vendas';
        $select .= ', SUM(t.valor_financiado_construtora) as valor_financiado_construtora';
        $select .= ', SUM(t.valor_financiado_caixa) as valor_financiado_caixa';
        $select .= ', SUM(CASE WHEN t.status = "Reservado" AND t.ativo = 1 THEN 1 ELSE 0 END) as totalReservados';
        $select .= ', SUM(CASE WHEN t.em_contratacao = 1 AND t.ativo = 1 THEN 1 ELSE 0 END) as totalEmContratacao';
        $select .= ', SUM(CASE WHEN t.status = "Permutado" AND t.ativo = 1 THEN 1 ELSE 0 END) as totalPermutados';
        $select .= ', SUM(CASE WHEN t.status = "Vendido" AND t.ativo = 1 THEN 1 ELSE 0 END) as totalVendidos';
        $select .= ', SUM(CASE WHEN t.status = "Vendido" AND t.ativo = 1 AND t.data_aprovacao_financiamento IS NOT NULL THEN 1 ELSE 0 END) as totalFinanciamentoAprovado';

        $criteria = new CDbCriteria;
        $criteria->select = $select;
        $criteria->with = array('apartamento0', 'bloco0');
        
        $criteria->together = true;
        
        $criteria->compare('bloco0.empreendimento', $this->empreendimento, true);
        $criteria->compare('t.ativo', 1);

        $now = new CDbExpression('DATE_SUB(NOW(), INTERVAL 8 DAY)');
        $criteria->addCondition('t.data >= ' . $now . ' OR t.status <> "Reservado" ');

        $criteria->order = 'bloco0.descricao ASC';
        $criteria->group = 'bloco0.modulo';

        return new CActiveDataProvider('Historico', array(
            'criteria' => $criteria,
        ));
    }

    public function searchTotals() {
        $select = 'bloco0.descricao as bloco, SUM(t.valor_venda) as valor_venda, SUM(t.valor_entrada) as valor_entrada';
        $select .= ', SUM(CASE WHEN t.status = "Vendido" AND t.corretor_pago = 1 THEN t.valor_comissao_corretor WHEN t.status = "Vendido" AND t.corretor_pago_meia THEN (t.valor_comissao_corretor * 0.5) WHEN t.status = "Vendido" AND t.valor_pago_corretor IS NOT NULL THEN t.valor_pago_corretor ELSE 0 END) as valor_comissao_corretor';
        $select .= ', SUM(CASE WHEN t.status = "Vendido" AND t.adm_vendas_pago = 1 THEN t.valor_pagamento_adm_vendas ELSE 0 END) as valor_pagamento_adm_vendas';
        $select .= ', SUM(t.valor_financiado_construtora) as valor_financiado_construtora';
        $select .= ', SUM(t.valor_financiado_caixa) as valor_financiado_caixa';
        $select .= ', SUM(CASE WHEN t.status = "Reservado" AND t.ativo = 1 THEN 1 ELSE 0 END) as totalReservados';
        $select .= ', SUM(CASE WHEN t.em_contratacao = 1 AND t.ativo = 1 THEN 1 ELSE 0 END) as totalEmContratacao';
        $select .= ', SUM(CASE WHEN t.status = "Permutado" AND t.ativo = 1 THEN 1 ELSE 0 END) as totalPermutados';
        $select .= ', SUM(CASE WHEN t.status = "Vendido" AND t.ativo = 1 THEN 1 ELSE 0 END) as totalVendidos';
        $select .= ', SUM(CASE WHEN t.status = "Vendido" AND t.ativo = 1 AND t.data_aprovacao_financiamento IS NOT NULL THEN 1 ELSE 0 END) as totalFinanciamentoAprovado';

        $criteria = new CDbCriteria;
        $criteria->select = $select;
        $criteria->with = array('apartamento0', 'bloco0');
        
        $criteria->together = true;
        
        $criteria->compare('bloco0.empreendimento', $this->empreendimento, true);
        $criteria->compare('t.ativo', 1);

        $now = new CDbExpression('DATE_SUB(NOW(), INTERVAL 8 DAY)');
        $criteria->addCondition('t.data >= ' . $now . ' OR t.status <> "Reservado" ');

        $criteria->order = 'bloco0.descricao ASC';
        $criteria->group = 'bloco0.descricao';

        return new CActiveDataProvider('Historico', array(
            'criteria' => $criteria,
        ));
    }
    
    public function getTotal($field, $ids) {
        $ids = implode(",", $ids);

        $connection = Yii::app()->db;
        
        $sql = 'SELECT SUM(' . $field . ') FROM historico ';
        $sql .= 'INNER JOIN apartamento on apartamento.id = historico.apartamento ';
        $sql .= 'INNER JOIN bloco on bloco.id = apartamento.bloco ';
        $sql .= 'INNER JOIN empreendimento on empreendimento.id = bloco.empreendimento ';
        $sql .= 'WHERE historico.vendido = 1 AND historico.ativo = 1 AND empreendimento.id = '. $this->empreendimento;
        
        $command = $connection->createCommand($sql); 
        
        $amount = $command->queryScalar();
        return 'R$' . number_format($amount, 2, ',', '.');
    }

    public function getTotalComissaoCorretor() {
        $connection = Yii::app()->db;
        
        $sql = 'SELECT SUM(CASE WHEN corretor_pago = 1 THEN valor_comissao_corretor WHEN corretor_pago_meia THEN (valor_comissao_corretor * 0.5) WHEN valor_pago_corretor IS NOT NULL THEN valor_pago_corretor ELSE 0 END) FROM historico ';
        $sql .= 'INNER JOIN apartamento on apartamento.id = historico.apartamento ';
        $sql .= 'INNER JOIN bloco on bloco.id = apartamento.bloco ';
        $sql .= 'INNER JOIN empreendimento on empreendimento.id = bloco.empreendimento ';
        $sql .= 'WHERE historico.status = "Vendido" AND historico.ativo = 1 AND empreendimento.id = '. $this->empreendimento;
        
        $command = $connection->createCommand($sql);
        $amount = $command->queryScalar();
        return 'R$' . number_format($amount, 2, ',', '.');
    }

    public function getTotalComissaoAdm() {
        $connection = Yii::app()->db;
        
        $sql = 'SELECT SUM(valor_pagamento_adm_vendas) FROM historico ';
        $sql .= 'INNER JOIN apartamento on apartamento.id = historico.apartamento ';
        $sql .= 'INNER JOIN bloco on bloco.id = apartamento.bloco ';
        $sql .= 'INNER JOIN empreendimento on empreendimento.id = bloco.empreendimento ';
        $sql .= 'WHERE historico.status = "Vendido" AND historico.ativo = 1 AND historico.adm_vendas_pago = 1  AND empreendimento.id = '. $this->empreendimento;
        
        $command = $connection->createCommand($sql);
        
        $amount = $command->queryScalar();
        return 'R$' . number_format($amount, 2, ',', '.');
    }

    public function getTotalStatus($field, $financiamentoAprovado = false) {
        $connection = Yii::app()->db;
        
        $sql = 'SELECT COUNT(*) FROM historico ';
        $sql .= 'INNER JOIN apartamento on apartamento.id = historico.apartamento ';
        $sql .= 'INNER JOIN bloco on bloco.id = apartamento.bloco ';
        $sql .= 'INNER JOIN empreendimento on empreendimento.id = bloco.empreendimento ';
        $sql .= 'WHERE historico.status = "' . $field . '" AND historico.ativo = 1  AND empreendimento.id = '. $this->empreendimento;
        
        if($financiamentoAprovado) {
            $sql .= ' AND historico.data_aprovacao_financiamento IS NOT NULL';
        }
        
        $command = $connection->createCommand($sql);
        
        if ($field == 'Reservado')
            $sql .= ' AND data >= DATE_SUB(NOW(), INTERVAL 8 DAY)';
        
        $amount = $command->queryScalar();
        return $amount;
    }

    public function searchByStatus($status, $idEmpreendimento, $financiamentoAprovado=false) {
        if($status != 'Disponível') {
            $select = 'bloco0.descricao as bloco, apartamento0.numero as apartamento, cliente_nome, usuario0.nome as usuario, data, status';

            $criteria = new CDbCriteria;
            $criteria->select = $select;
            $criteria->with = array('usuario0', 'apartamento0', 'bloco0');
            $criteria->together = true;
            $criteria->compare('bloco0.empreendimento', $idEmpreendimento, true);
            $criteria->compare('t.ativo', 1);

            if($status == 'Reservado') {
                $now = new CDbExpression('DATE_SUB(NOW(), INTERVAL 8 DAY)');
                $criteria->addCondition('t.data >= ' . $now . ' AND t.status = "Reservado" ');
            } else {
                $criteria->addCondition('t.status = "' . $status . '" ');
            }
            
            if($financiamentoAprovado) {
                $criteria->addCondition('t.data_aprovacao_financiamento IS NOT NULL');
            }

            $criteria->order = 'bloco0.descricao, apartamento0.numero ASC';
    //        $criteria->group = 'bloco0.descricao';

            return new CActiveDataProvider('Historico', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 400,
                ),
            ));
        } else {
            $select = 'bloco0.descricao as bloco, numero';

            $criteria = new CDbCriteria;
            $criteria->select = $select;
            $criteria->with = array('bloco0');
            $criteria->together = true;
            $criteria->compare('t.ativo', 1);
            $criteria->compare('bloco0.empreendimento', $idEmpreendimento, true);

            $now = new CDbExpression('DATE_SUB(NOW(), INTERVAL 8 DAY)');
            $criteria->addCondition('t.id NOT IN (SELECT h.apartamento FROM historico h WHERE (h.status = "Vendido" OR h.status = "Permutado" or h.status = "Em Contratação" OR (h.data >= ' . $now . ' AND h.status = "Reservado")) and h.ativo = 1)');

//            if($status == 'Reservado') {
//                $criteria->addCondition('t.data >= ' . $now . ' AND t.status = "Reservado" ');
//            } else {
//                $criteria->addCondition('t.status = "' . $status . '" ');
//            }

            $criteria->order = 'bloco0.descricao, numero ASC';
    //        $criteria->group = 'bloco0.descricao';

            return new CActiveDataProvider('Apartamento', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 400,
                ),
            ));
        }
    }
    
    public function getApartamento() {
//        print_r($this);exit;
        return $this->numero;
    }

}
