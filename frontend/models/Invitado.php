<?php

namespace frontend\models;

use Yii;

/**
* This is the model class for table "comedor.invitado".
*
* @property int $idinv
* @property string|null $ci
* @property string $nombcompleto
* @property string $ente
* @property string|null $created_at
* @property int|null $fkuser
 */
class Invitado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comedor.invitado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombcompleto','ente'],'required','message'=>'Este campo no puede estar vacio!!'],
            [['fkuser'], 'default', 'value' => null],
            [['fkuser'], 'integer'],
            [['created_at'], 'safe'],
            [['ci'], 'integer','message'=>'La cedula de indentidad debe ser Numerica y no mayor a 10 digitos!!'],
            [['nombcompleto', 'ente'], 'string', 'max' => 255],
            [['fkuser'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['fkuser' => 'iduser']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idinv' => 'Id',
            'ci' => 'Cedula',
            'nombcompleto' => 'Nombre',
            'ente' => 'Ente',
            'created_at' => 'Fecha',
            'fkuser' => 'Usuario',
        ];
    }

    public function getUsuar()
    {
        return Usuario::find()->where(['iduser'=>$this->fkuser])->one();
    }

    public function getusuario()
    {
        return $this->hasOne(Usuario::className(),['iduser'=>'fkuser']);
    }
}
