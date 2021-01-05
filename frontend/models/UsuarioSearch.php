<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Usuario;

/**
 * SearchUsuario represents the model behind the search form of `frontend\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{
    public $nombdepart;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iduser', 'status', 'fkdepart'], 'integer'],
            [['nombdepart'], 'string', 'max' => 255],
            [['username', 'auth_key', 'password', 'password_reset_token', 'email', 'created_at', 'updated_at', 'verification_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Usuario::find()->joinWith(['userdepart']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'iduser' => $this->iduser,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'fkdepart' => $this->fkdepart,
        ]);

        $query->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'auth_key', $this->auth_key])
            ->andFilterWhere(['ilike', 'password', $this->password])
            ->andFilterWhere(['ilike', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'verification_token', $this->verification_token])
            ->andFilterWhere(['ilike', 'nombdepart', $this->nombdepart]);

        return $dataProvider;
    }
}
