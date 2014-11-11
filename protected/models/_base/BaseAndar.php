<?php

/**
 * This is the model base class for the table "andar".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Andar".
 *
 * Columns in table "andar" available as properties of the model,
 * followed by relations of table "andar" available as properties of the model.
 *
 * @property integer $id
 * @property string $descricao
 * @property integer $bloco
 * @property integer $posicao
 * @property integer $ativo
 *
 * @property Bloco $bloco0
 * @property Apartamento[] $apartamentos
 */
abstract class BaseAndar extends GxActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'andar';
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Andar|Andars', $n);
    }

    public static function representingColumn() {
        return 'descricao';
    }

    public function rules() {
        return array(
            array('descricao, bloco', 'required'),
            array('bloco, posicao, ativo', 'numerical', 'integerOnly' => true),
            array('descricao', 'length', 'max' => 255),
            array('posicao, ativo', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, descricao, bloco, posicao, ativo', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'bloco0' => array(self::BELONGS_TO, 'Bloco', 'bloco'),
            'apartamentos' => array(self::HAS_MANY, 'Apartamento', 'andar'),
        );
    }

    public function pivotModels() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'descricao' => Yii::t('app', 'Descricao'),
            'bloco' => null,
            'posicao' => Yii::t('app', 'Posicao'),
            'ativo' => Yii::t('app', 'Ativo'),
            'bloco0' => null,
            'apartamentos' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('descricao', $this->descricao, true);
        $criteria->compare('bloco', $this->bloco);
        $criteria->compare('posicao', $this->posicao);
        $criteria->compare('ativo', $this->ativo);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'posicao ASC',
            ),
        ));
    }

}