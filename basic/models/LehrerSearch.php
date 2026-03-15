<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lehrer;

/**
 * LehrerSearch represents the model behind the search form of `app\models\Lehrer`.
 */
class LehrerSearch extends Lehrer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['L_ID'], 'integer'],
            [['Vorname', 'Nachname', 'Kuerzel', 'Status'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Lehrer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'L_ID' => $this->L_ID,
        ]);

        $query->andFilterWhere(['like', 'Vorname', $this->Vorname])
            ->andFilterWhere(['like', 'Nachname', $this->Nachname])
            ->andFilterWhere(['like', 'Kuerzel', $this->Kuerzel])
            ->andFilterWhere(['like', 'Status', $this->Status]);

        return $dataProvider;
    }
}
