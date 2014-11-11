<?php

Yii::import('application.models._base.BaseMaterial');

class Material extends BaseMaterial {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getChartData() {
        $consumo = (float) $this->consumo;
        $entrada = (float) $this->getBought();
        $saida = (float) $this->getUtilized();
        
        $labelComprada = 'Comprada (' . $this->getBoughtPercent() . '% do total)';
        $labelUtilizada = 'Utilizada (' . $this->getUtilizedPercent() . '% do total)';
        
        $chartData = array(
            array('Quantidade', 'Máxima', $labelComprada, $labelUtilizada),
            array('Quantidade', $consumo, $entrada, $saida),
        );
        
        return $chartData;
    }

    public function getBoughtPercent() {
        $percent = ($this->getBought() * 100)/$this->consumo;
        return number_format((float)$percent, 1, '.', '');
    }

    public function getUtilizedPercent() {
        $percent = ($this->getUtilized() * 100)/$this->consumo;
        return number_format((float)$percent, 1, '.', '');
    }

    public function getBought() {
        return $this->getTotal(TipoMovimentacaoEnum::ENTRADA);
    }

    public function getUtilized() {
        return $this->getTotal(TipoMovimentacaoEnum::SAIDA);
    }
    
    private function getTotal($movimentationType) {
        $connection = Yii::app()->db;
        $sql = 'SELECT SUM(quantidade) FROM movimentacao where MATERIAL = ' . $this->id . ' and TIPO_MOVIMENTACAO = ' . $movimentationType . ' and ATIVO = 1';
        $command = $connection->createCommand($sql);
        $amount = $command->queryScalar();
        return $amount;
    }

    public function isFully() {
        if($this->getBought() == $this->consumo) {
            return true;
        } else {
            return false;
        }
    }

    public function isUtilized() {
        if($this->getBought() == $this->getUtilized()) {
            return true;
        } else {
            return false;
        }
    }
}
