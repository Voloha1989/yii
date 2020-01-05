<?php

namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "books_history".
 *
 * @property int $id
 * @property string $text
 * @property int $book_id
 * @property string $created_at
 *
 * @property Books $book
 */
class BooksHistory extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['book_id', 'created_at'], 'required'],
            [['book_id'], 'integer'],
            [['created_at'], 'safe'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'book_id' => 'Book ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Books::className(), ['id' => 'book_id']);
    }
}
