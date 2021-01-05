<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comedor.perscomedor".
 *
 * @property int $idperscom
 * @property int|null $fkpers
 * @property int|null $fkuser
 * @property int|null $fkdepart
 * @property string|null $created_at
 */
class Perscomedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comedor.perscomedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fkpers', 'fkuser', 'fkdepart'], 'default', 'value' => null],
            [['fkpers', 'fkuser', 'fkdepart'], 'integer'],
            [['created_at'], 'safe'],
            [['fkdepart'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['fkdepart' => 'iddepart']],
            [['fkpers'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::className(), 'targetAttribute' => ['fkpers' => 'idpers']],
            [['fkuser'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['fkuser' => 'iduser']],
            //['fkpers','validarpersonal']
        ];
    }

    /*
    public function validarpersonal($attribute,$params)
    {
        $comedor = Perscomedor::find()->where([
            'fkpers'=>$this->fkpers,
            'created_at'=>date('Y-m-d'),
        ])->one();
        if ($comedor !== null) {
            $this->addError($attribute,'');
        }
    }
    */

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idperscom' => 'Id',
            'fkpers' => 'Personal',
            'fkuser' => 'Usuario',
            'fkdepart' => 'Departamento',
            'created_at' => 'Fecha',
        ];
    }

    public function getdepartamento()
    {
        $departamento = Departamento::find()->where(['iddepart'=>$this->fkdepart])->one();
        return $departamento;
    }
    public function getdepart()
    {
        return $this->hasOne(Departamento::className(), ['iddepart'=>'fkdepart']);
    }

    public function getpersonal()
    {
        $personal = Personal::find()->where(['idpers'=>$this->fkpers])->one();
        return $personal;
    }
    public function getpers()
    {
        return $this->hasOne(Personal::className(), ['idpers'=>'fkpers']);
    }

    public function getusuario()
    {
        $usuario = Usuario::find()->where(['iduser'=>$this->fkuser])->one();
        return $usuario;
    }
}
