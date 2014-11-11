<?php

/**
 * This is the model base class for the table "usuario".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Usuario".
 *
 * Columns in table "usuario" available as properties of the model,
 * followed by relations of table "usuario" available as properties of the model.
 *
 * @property integer $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property integer $perfil
 * @property integer $corretor_chefe
 * @property integer $imobiliaria
 *
 * @property Imobiliaria $imobiliaria0
 */
abstract class BaseUsuario extends GxActiveRecord {
    
     public $novaSenha ;
     public $confirmarSenha ;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'usuario';
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Usuário|Usuários', $n);
    }

    public static function representingColumn() {
        return 'nome';
    }

    public function rules() {
        return array(
            array('nome, email, senha, telefone, perfil, ativo', 'required'),
            array('imobiliaria, corretor_chefe', 'numerical', 'integerOnly' => true),
            array('nome, email', 'length', 'max' => 60),
            array('senha', 'length', 'max' => 256),
            array('novaSenha', 'length', 'max' => 256),
            array('confirmarSenha', 'length', 'max' => 256),
            array('telefone', 'length', 'max' => 16),
            array('id, nome, email, senha, telefone, imobiliaria, perfil, corretor_chefe, ativo', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'historicos' => array(self::HAS_MANY, 'Historico', 'usuario'),
            'imobiliaria0' => array(self::BELONGS_TO, 'Imobiliaria', 'imobiliaria'),
        );
    }

    public function pivotModels() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'nome' => Yii::t('app', 'Nome'),
            'email' => Yii::t('app', 'E-mail'),
            'senha' => Yii::t('app', 'Senha'),
            'novaSenha' => Yii::t('app', 'Nova Senha'),
            'confirmarSenha' => Yii::t('app', 'Confirmar Senha'),
            'telefone' => Yii::t('app', 'Telefone'),
            'perfil' => Yii::t('app', 'Perfil'),
            'imobiliaria' => null,
            'imobiliaria0' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('nome', $this->nome, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('senha', $this->senha, true);
        $criteria->compare('telefone', $this->telefone, true);
        $criteria->compare('imobiliaria', $this->imobiliaria);
        $criteria->with = array('imobiliaria0' => array('condition' => '(imobiliaria0.ativo=1 OR t.imobiliaria IS Null)'));
        $criteria->compare('perfil', $this->perfil);
        $criteria->compare('t.ativo', 1);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'t.nome',
            ),
        ));
    }

}