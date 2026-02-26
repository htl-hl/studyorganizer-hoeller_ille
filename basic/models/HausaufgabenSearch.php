<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hausaufgaben;

/**
 * HausaufgabenSearch represents the model behind the search form of `app\models\Hausaufgaben`.
 */
class HausaufgabenSearch extends Hausaufgaben
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['HU_ID', 'U_ID', 'L_ID'], 'integer'],
            [['Titel', 'Beschreibung', 'Faelligkeitsdatum', 'Status', 'F_Name'], 'safe'],
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
        $query = Hausaufgaben::find();

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
            'HU_ID' => $this->HU_ID,
            'Faelligkeitsdatum' => $this->Faelligkeitsdatum,
            'U_ID' => $this->U_ID,
            'L_ID' => $this->L_ID,
        ]);

        $query->andFilterWhere(['like', 'Titel', $this->Titel])
            ->andFilterWhere(['like', 'Beschreibung', $this->Beschreibung])
            ->andFilterWhere(['like', 'Status', $this->Status])
            ->andFilterWhere(['like', 'F_Name', $this->F_Name]);

        return $dataProvider;
    }
}
