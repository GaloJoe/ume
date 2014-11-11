<?php

Yii::import('application.models._base.BaseRecibo');

class Recibo extends BaseRecibo {
    public $valor_recibo;
    public $valor_retido;
    public $valor_a_pagar;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCriteria($emp, $new = true) {
        $condition = $this->getCondition($this, $new, $emp);

        $criteria = new CDbCriteria();

        $criteria->alias = 'at';
        $criteria->distinct = true;
        $criteria->select = '*';
        $criteria->join .= ' LEFT JOIN historico_atividade as ha ON ha.atividade = at.id AND ha.ativo =1';
        $criteria->join .= ' LEFT JOIN unidade_medida as unidadeMedida0 ON unidadeMedida0.id = at.unidade_medida';
        $criteria->join .= ' LEFT JOIN empreendimento as empreendimento0 ON empreendimento0.id = unidadeMedida0.empreendimento';
        
        $criteria->condition = $condition;
        $criteria->order = 'at.unidade_medida, at.id';
        $criteria->together = true;

        return $criteria;
    }

    private function getCondition($recibo, $new, $emp) {
        $condition = 'at.ativo = 1 AND ha.empreiteiro=' . $recibo->empreiteiro;

        if ($recibo->data_inicial != '') {
            $data = $this->arrayToSqlDate($recibo->data_inicial);
            if ($data != null && $data != '') {
                $data = str_replace(' 00:00:00', '', $data);
                $condition.= ' AND ' . 'ha.data >= \'' . $data . ' 00:00:00\'';
            }
        }
        if ($recibo->data_final != '') {
            $data = $this->arrayToSqlDate($recibo->data_final);
            if ($data != null && $data != '') {
                $data = str_replace(' 00:00:00', '', $data);
                $condition.= ' AND ' . 'ha.data <= \'' . $data . ' 23:59:59\'';
            }
        }

        $condition .= ' AND ha.ativo = 1';
        if ($new) {
            $condition .= ' AND ha.recibo IS NULL';
        } else {
            $condition .= ' AND ha.recibo = ' . $this->id;
        }

        if ($emp == NULL) {
            $emp = 'NULL';
        }

        $condition .= ' AND (empreendimento0.id = ' . $emp . ' OR ' . $emp . ' IS NULL)';
        
        return $condition;
    }

    public function arrayToSqlDate($date) {
        if ($date != '') {
            $dateArray = explode('/', $date);
            if (count($dateArray) >= 2) {
                return $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
            } else {
                return $date;
            }
        }

        return null;
    }

    public function getTotalRecibo($emp, $new = true) {
        $total = 0;

        $condition = 'ha.empreiteiro=' . $this->empreiteiro;

        if ($this->data_inicial != '') {
            $data = $this->arrayToSqlDate($this->data_inicial);

            if ($data != null && $data != '') {
                $data = str_replace(' 00:00:00', '', $data);
                $condition.= ' AND ' . 'ha.data >= \'' . $data . ' 00:00:00\'';
            }
        }
        if ($this->data_final != '') {
            $data = $this->arrayToSqlDate($this->data_final);

            if ($data != null && $data != '') {
                $data = str_replace(' 00:00:00', '', $data);
                $condition.= ' AND ' . 'ha.data <= \'' . $data . ' 23:59:59\'';
            }
        }

        $condition .= ' AND ha.ativo = 1';

        if ($new) {
            $condition .= ' AND ha.recibo IS NULL';
        } else {
            $condition .= ' AND ha.recibo = ' . $this->id;
        }

        if ($emp == NULL) {
            $emp = 'NULL';
        }

        $condition .= ' AND (empreendimento0.id = ' . $emp . ' OR ' . $emp . ' IS NULL)';

        $criteria = new CDbCriteria();

        $criteria->alias = 'ha';
        $criteria->select = '*';

        $criteria->join .= ' LEFT OUTER JOIN atividade as atividade0 ON atividade0.id = ha.atividade';
        $criteria->join .= ' LEFT OUTER JOIN unidade_medida as unidadeMedida0 ON unidadeMedida0.id = atividade0.unidade_medida';
        $criteria->join .= ' LEFT OUTER JOIN empreendimento as empreendimento0 ON empreendimento0.id = unidadeMedida0.empreendimento';

        $criteria->condition = $condition;

        $historicoAtividades = HistoricoAtividade::model()->findAll($criteria);

        foreach ($historicoAtividades as $historicoAtividade) {
            $total = $total + ($historicoAtividade->atividade0->valor_unitario - $historicoAtividade->atividade0->valor_unitario * ($historicoAtividade->retencao / 100));
        }

        return $total;
    }
    
    public function getValorTotal() {
        $total = 0;

        $condition = ' ha.recibo = ' . $this->id;

        $criteria = new CDbCriteria();

        $criteria->alias = 'ha';
        $criteria->select = '*';

        $criteria->condition = $condition;

        $historicoAtividades = HistoricoAtividade::model()->findAll($criteria);

        foreach ($historicoAtividades as $historicoAtividade) {
            $total = $total + ($historicoAtividade->atividade0->valor_unitario);
        }

        return $total;
    }
    
    public function getValorRetido() {
        $total = 0;

        $condition = ' ha.recibo = ' . $this->id;

        $criteria = new CDbCriteria();

        $criteria->alias = 'ha';
        $criteria->select = '*';

        $criteria->condition = $condition;

        $historicoAtividades = HistoricoAtividade::model()->findAll($criteria);

        foreach ($historicoAtividades as $historicoAtividade) {
            $total = $total + ($historicoAtividade->atividade0->valor_unitario - $historicoAtividade->atividade0->valor_unitario * ($historicoAtividade->retencao / 100));
        }

        return $this->getValorTotal() - $total;
    }
    
    public function getValorAPagar() {
        $total = 0;

        $condition = ' ha.recibo = ' . $this->id;

        $criteria = new CDbCriteria();

        $criteria->alias = 'ha';
        $criteria->select = '*';

        $criteria->condition = $condition;

        $historicoAtividades = HistoricoAtividade::model()->findAll($criteria);

        foreach ($historicoAtividades as $historicoAtividade) {
            $total = $total + ($historicoAtividade->atividade0->valor_unitario - $historicoAtividade->atividade0->valor_unitario * ($historicoAtividade->retencao / 100));
        }
        
        $pagamentos = Retencao::model()->findAll('recibo=:recibo AND t.ativo=1', array(':recibo' => $this->id));
        $valorPago = 0;
        foreach($pagamentos as $pagamento) {
            $valorPago += $pagamento->valor;
        }
        
        $total = $this->getValorTotal() - $total;
        
        return $total - $valorPago;
    }

}
