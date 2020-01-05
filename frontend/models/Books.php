<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $appellation
 * @property string $text
 * @property int $author_id
 * @property int $hero_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Author $author
 */
class Books extends ActiveRecord
{
    public static function tableName()
    {
        return 'books';
    }

    public function rules()
    {
        return [
            [['appellation', 'author_id'], 'required'],
            [['text'], 'string'],
            [['author_id', 'hero_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['appellation'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appellation' => 'Appellation',
            'text' => 'Text',
            'author_id' => 'Author',
            'hero_id' => 'Hero',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'authorName' => 'Author Name',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }

    public function getHero()
    {
        return $this->hasOne(Hero::className(), ['id' => 'hero_id']);
    }

    public function getAuthorName()
    {

        return $this->getAuthor()->one()->name;
    }

    public function getHistory()
    {
        return $this->hasMany(BooksHistory::className(), ['book_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => function () {
                    return new Expression('NOW()');
                }],
        ];
    }
}
