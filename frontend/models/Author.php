<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $name
 * @property string $patronymic
 * @property string $surname
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Books[] $books
 */
class Author extends ActiveRecord
{
    public $amount_books;

    public static function tableName()
    {
        return 'author';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'patronymic', 'surname'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'patronymic' => 'Patronymic',
            'surname' => 'Surname',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'amount_books' => 'Amount Books',
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Books::className(), ['author_id' => 'id']);
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
