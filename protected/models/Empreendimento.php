<?php

Yii::import('application.models._base.BaseEmpreendimento');

class Empreendimento extends BaseEmpreendimento
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}