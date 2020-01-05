<?php

namespace frontend\modules\api\models;

use yii\base\Model;
use frontend\models\Books;
use frontend\models\Author;
use frontend\models\Hero;
use yii\data\ActiveDataProvider;

/**
 * SearchBook represents the model behind the search form of `frontend\models\Books`.
 */
class SearchBook extends Books
{
    public $author;
    public $hero;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appellation', 'author', 'hero', 'created_at'], 'safe'],
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
        $query = Book::find();

        $query->joinWith(['author']);
        $query->joinWith(['hero']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        $query->andFilterWhere([
            'books.id' => $this->id,
            'books.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'appellation', $this->appellation])
            ->andFilterWhere(['like', Author::tableName() . '.name', $this->author])
            ->andFilterWhere(['like', Hero::tableName() . '.name', $this->hero]);

        return $dataProvider;
    }
}
