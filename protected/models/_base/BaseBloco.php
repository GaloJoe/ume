<?php

/**
 * This is the model base class for the table "bloco".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Bloco".
 *
 * Columns in table "bloco" available as properties of the model,
 * followed by relations of table "bloco" available as properties of the model.
 *
 * @property integer $id
 * @property string $descricao
 * @property integer $ativo
 * @property integer $empreendimento
 * @property integer $modulo
 * @property integer $disponivel
 *
 * @property Apartamento[] $apartamentos
 * @property Empreendimento $empreendimento0
 * @property Modulo $modulo0
 * 
 */
abstract class BaseBloco extends GxActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'bloco';
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Bloco|Blocos', $n);
    }

    public static function representingColumn() {
        return 'descricao';
    }

    public function rules() {
        return array(
            array('descricao, ativo, empreendimento, modulo, disponivel', 'required'),
            array('empreendimento, modulo, disponivel', 'numerical', 'integerOnly' => true),
            array('descricao', 'length', 'max' => 100),
            array('id, descricao, ativo, empreendimento, modulo, disponivel', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'apartamentos' => array(self::HAS_MANY, 'Apartamento', 'bloco'),
            'empreendimento0' => array(self::BELONGS_TO, 'Empreendimento', 'empreendimento'),
            'modulo0' => array(self::BELONGS_TO, 'Modulo', 'modulo'),
        );
    }

    public function pivotModels() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'descricao' => Yii::t('app', 'Descrição'),
            'ativo' => Yii::t('app', 'Ativo'),
            'empreendimento' => null,
            'modulo' => null,
            'disponivel' => null,
            'apartamentos' => null,
            'empreendimento0' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('descricao', $this->descricao, true);
        $criteria->compare('ativo', $this->ativo);
        $criteria->compare('empreendimento', $this->empreendimento);
        $criteria->compare('modulo', $this->modulo);
        $criteria->compare('disponivel', $this->disponivel);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'descricao ASC',
            ),
        ));
    }

}
