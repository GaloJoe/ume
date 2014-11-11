<?php

Yii::import('application.models._base.BaseUsuario');

class Usuario extends BaseUsuario {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function validatePassword($password) {
        return CPasswordHelper::verifyPassword($password, $this->senha);
    }

    public function hashPassword($password) {
        return CPasswordHelper::hashPassword($password);
    }

    public function listProfiles() {
//        return array(array("Corretor")
        return null;
    }

    public function listWithContracts($emp) {
        $select = 'SELECT DISTINCT U.* FROM USUARIO U INNER JOIN HISTORICO_ATIVIDADE HA ON HA.EMPREITEIRO = U.ID';
        $select .= ' INNER JOIN ATIVIDADE A ON A.ID = HA.ATIVIDADE';
        $select .= ' INNER JOIN UNIDADE_MEDIDA UM ON UM.ID = A.UNIDADE_MEDIDA';
        $select .= ' INNER JOIN EMPREENDIMENTO E ON E.ID = UM.EMPREENDIMENTO';
        $select .= ' WHERE E.ID = :empreendimento';

        $list = Yii::app()->db->createCommand($select)->bindValue('empreendimento', $emp)->queryAll();

        $rs = array();
        foreach ($list as $item) {
            $rs[] = $item['id'];
        }

        $dataProvider = new CSqlDataProvider($select, array(
            'sort' => array(
                'attributes' => array(
                    'id', 'nome', 'email',
                ),
            ),
        ));

        return $dataProvider;
    }
    
    public function getEmpreiteiros() {
        $criteria = new CDbCriteria;
        
        $criteria->addCondition('upper(perfil) = "EMPREITEIRO" AND ativo = 1');
        
        return new CActiveDataProvider('Usuario', array(
            'criteria' => $criteria,
        ));
    }
    
    public function getValorAPagar() {
        $total = 0;

        $condition = ' ha.empreiteiro = ' . $this->id;
        $condition .= ' AND (recibo0.ativo = 1)';

        $criteria = new CDbCriteria();

        $criteria->alias = 'ha';
        $criteria->select = '*';
        
        $criteria->join .= ' INNER JOIN recibo as recibo0 ON recibo0.id = ha.recibo';

        $criteria->condition = $condition;

        $historicoAtividades = HistoricoAtividade::model()->findAll($criteria);

        foreach ($historicoAtividades as $historicoAtividade) {
            $total = $total + ($historicoAtividade->atividade0->valor_unitario - $historicoAtividade->atividade0->valor_unitario * ($historicoAtividade->retencao / 100));
        }
        
        //////////////////
        
        $condition .= ' AND (ha.empreiteiro = ' . $this->id . ')';
        $condition .= ' AND (recibo0.ativo = 1)';
        $condition .= ' AND (retencao0.ativo = 1)';

        $criteria = new CDbCriteria();

        $criteria->alias = 'retencao0';
        $criteria->distinct = true;
        $criteria->select = '*';

        $criteria->join .= ' INNER JOIN recibo as recibo0 ON recibo0.id = retencao0.recibo';
        $criteria->join .= ' INNER JOIN historico_atividade as ha ON ha.recibo = recibo0.id';

        $criteria->condition = $condition;

        $pagamentos = Retencao::model()->findAll($criteria);
        
        //////////////////
        
//        $pagamentos = Retencao::model()->findAll('recibo=:recibo AND t.ativo=1', array(':recibo' => $this->id));
        $valorPago = 0;
        foreach($pagamentos as $pagamento) {
            $valorPago += $pagamento->valor;
        }
        
        $total = $this->getValorTotal() - $total;
        
        return 'R$' . number_format($total - $valorPago, 2, ',', '.');;
    }
    
    public function getValorTotal() {
        $total = 0;

        $condition = ' ha.empreiteiro = ' . $this->id;
        $condition .= ' AND (recibo0.ativo = 1)';

        $criteria = new CDbCriteria();

        $criteria->alias = 'ha';
        $criteria->select = '*';
        
        $criteria->join .= ' INNER JOIN recibo as recibo0 ON recibo0.id = ha.recibo';

        $criteria->condition = $condition;
        
        $historicoAtividades = HistoricoAtividade::model()->findAll($criteria);

        foreach ($historicoAtividades as $historicoAtividade) {
            $total = $total + ($historicoAtividade->atividade0->valor_unitario);
        }

        return $total;
    }
    
    public function getPerfilFormatado() {
        if ($this->perfil == 'normal') {
            return "Corretor";
        } else if($this->perfil == 'master') {
            return "Administrador Geral";
        } else if($this->perfil == 'admin') {
            return "Administrador de Vendas";
        } else if($this->perfil == 'empreiteiro') {
            return "Empreiteiro";
        } else if($this->perfil == 'engenheiro') {
            return "Engenheiro";
        }
    }

}
