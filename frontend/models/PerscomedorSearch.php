<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Perscomedor;

/**
 * SearchPerscomedor represents the model behind the search form of `frontend\models\Perscomedor`.
 */
class PerscomedorSearch extends Perscomedor
{
    //public $nombdepart;
    //public $nombcompleto;
    //public $ci;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idperscom', 'fkpers', 'fkuser', 'fkdepart'], 'integer'],
            //[['nombdepart'], 'string', 'max' => 255],
            //[['nombcompleto'], 'string', 'max' => 255],
            [['created_at'], 'safe'],
            //[['ci'], 'string', 'max' => 10],
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
        $query = Perscomedor::find();//->joinWith(['depart'])->joinWith(['pers']);

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
            'idperscom' => $this->idperscom,
            'fkpers' => $this->fkpers,
            'fkuser' => $this->fkuser,
            'fkdepart' => $this->fkdepart,
            'created_at' => $this->created_at,
        ]);

        /*$query->andFilterWhere(['ilike', 'nombdepart', $this->nombdepart])
                ->andFilterWhere(['ilike', 'nombcompleto', $this->nombcompleto])
                ->andFilterWhere(['ilike', 'ci', $this->ci]);*/

        return $dataProvider;
    }
}
