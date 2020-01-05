<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchBooks represents the model behind the search form of `frontend\models\Books`.
 */
class SearchBooks extends Books
{
    public $authorName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'hero_id'], 'integer'],
            [['appellation', 'text', 'created_at', 'updated_at', 'authorName'], 'safe'],
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
        $query = Books::find();

        $query->joinWith(['author']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['authorName'] = [
            'asc' => [Author::tableName() . '.name' => SORT_ASC],
            'desc' => [Author::tableName() . '.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'books.id' => $this->id,
            'author_id' => $this->author_id,
            'hero_id' => $this->hero_id,
            'books.created_at' => $this->created_at,
            'books.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'appellation', $this->appellation])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', Author::tableName() . '.name', $this->authorName]);

        return $dataProvider;
    }
}
