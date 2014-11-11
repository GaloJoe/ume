<?php

Yii::import('application.models._base.BaseHistoricoAtividade');

class HistoricoAtividade extends BaseHistoricoAtividade {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function hasSaved($referencia, $atividade) {
        $historicoAtividades = HistoricoAtividade::model()->findAllAttributes(null, true, "referencia = " . $referencia . " AND atividade = " . $atividade . " AND ativo = 1");
        
        if ($historicoAtividades != null && count($historicoAtividades) > 0) {
            
            foreach ($historicoAtividades as $ha) {
                $historicoAtividade = HistoricoAtividade::model()->findByPk($ha->id);
            
                if ($historicoAtividade->empreiteiro0->ativo == 1)
                    return true;  
            }
        }
        return false;  
    }
    
    public function getDataFormatada() {
        return date("d/m/Y H:i:s", strtotime($this->data));
    }
    
    public function getDescricao($ref, $um) {
        $descricao = '';
        
        if(strtoupper($um) == strtoupper(TipoUnidadeMedidaEnum::ANDAR)) {
            $andar = Andar::model()->findByPk($ref);
            $descricao = $andar->descricao . ' ' . $andar->bloco0;
        } else if(strtoupper($um) == strtoupper(TipoUnidadeMedidaEnum::BLOCO)) {
            $bloco = Bloco::model()->findByPk($ref);
            $descricao = $bloco->descricao;
        } else if(strtoupper($um) == strtoupper(TipoUnidadeMedidaEnum::APARTAMENTO)) {
            $apartamento = Apartamento::model()->findByPk($ref);
            $descricao = $apartamento->descricao . ' ' . $apartamento->bloco0;
        } else if(strtoupper($um) == strtoupper(TipoUnidadeMedidaEnum::EMPREENDIMENTO)) {
            $empreendimento = Empreendimento::model()->findByPk($ref);
            $descricao = $empreendimento->nome;
        }
        
        return $descricao;
    }
}
