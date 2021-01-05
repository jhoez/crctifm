<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Invitado;

/**
 * InvitadoSearch represents the model behind the search form of `frontend\models\Invitado`.
 */
class InvitadoSearch extends Invitado
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idinv', 'fkuser'], 'integer'],
            [['ci'],'integer'],
            [['nombcompleto', 'ente', 'created_at'], 'safe'],
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
        $query = Invitado::find();

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
            'idinv' => $this->idinv,
            'created_at' => $this->created_at,
            'fkuser' => $this->fkuser,
        ]);

        $query->andFilterWhere(['ilike', 'ci', $this->ci])
            ->andFilterWhere(['ilike', 'nombcompleto', $this->nombcompleto])
            ->andFilterWhere(['ilike', 'ente', $this->ente]);

        return $dataProvider;
    }
}
