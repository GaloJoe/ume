<?php

Yii::import('application.models._base.BaseRetencao');

class Retencao extends BaseRetencao {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getEmpreiteiro() {
        return $this->recibo0->empreiteiro;
    }

}
