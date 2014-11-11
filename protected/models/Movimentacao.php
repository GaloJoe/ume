<?php

Yii::import('application.models._base.BaseMovimentacao');

class Movimentacao extends BaseMovimentacao {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getDataFormatada() {
        return $this->formatDate($this->data);
    }

    public function formatDate($data) {
        $datetime = new DateTime($data, new DateTimeZone('Brazil/East'));
        return $datetime->format('d\/m\/Y\ H:i:s');
    }
}
