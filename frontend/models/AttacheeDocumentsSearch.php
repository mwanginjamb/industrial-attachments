<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AttacheeDocuments;

/**
 * AttacheeDocumentsSearch represents the model behind the search form of `app\models\AttacheeDocuments`.
 */
class AttacheeDocumentsSearch extends AttacheeDocuments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'attachee_id', 'document_type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['path'], 'safe'],
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
        $query = AttacheeDocuments::find();

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
            'id' => $this->id,
            'attachee_id' => $this->attachee_id,
            'document_type' => $this->document_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'path', $this->path]);

        return $dataProvider;
    }
}
