<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * SearchAuthor represents the model behind the search form of `frontend\models\author`.
 */
class SearchAuthor extends Author
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'patronymic', 'surname', 'created_at', 'updated_at', 'amount_books'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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

        $subQuery = Author::find()
            ->select(['{{%author}}.*', 'amount_books' => new Expression('COUNT({{%books}}.id)')])
            ->joinWith(['books'])
            ->groupBy('{{%author}}.id');

        $query = Author::find()->from($subQuery);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['amount_books'] = [
            'asc' => ['amount_books' => SORT_ASC],
            'desc' => ['amount_books' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['amount_books' => $this->amount_books]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic])
            ->andFilterWhere(['like', 'surname', $this->surname]);

        return $dataProvider;
    }
}
