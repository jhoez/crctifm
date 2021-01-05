<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comedor.departamento".
 *
 * @property int $iddepart
 * @property string|null $nombdepart
 */
class Departamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comedor.departamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombdepart'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iddepart' => 'Iddepart',
            'nombdepart' => 'Nombdepart',
        ];
    }
}
