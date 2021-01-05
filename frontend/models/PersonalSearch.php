<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Personal;

/**
 * SearchPersonal represents the model behind the search form of `frontend\models\Personal`.
 */
class PersonalSearch extends Personal
{
    public $nombdepart;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombdepart'], 'string', 'max' => 255],
            [['idpers', 'fkuser', 'fkdepart'], 'integer'],
            [['ci', 'nombcompleto', 'sexo'], 'safe'],
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
        $query = Personal::find()->joinWith(['persdepartamento']);

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
            'idpers' => $this->idpers,
            'fkuser' => $this->fkuser,
            'fkdepart' => $this->fkdepart,
        ]);

        $query->andFilterWhere(['ilike', 'ci', $this->ci])
            ->andFilterWhere(['ilike', 'nombcompleto', $this->nombcompleto])
            ->andFilterWhere(['ilike', 'sexo', $this->sexo])
            ->andFilterWhere(['ilike', 'nombdepart', $this->nombdepart]);

        return $dataProvider;
    }
}
