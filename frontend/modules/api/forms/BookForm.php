<?php

namespace frontend\modules\api\forms;

use yii\base\Model;

class BookForm extends Model
{
    public $appellation;
    public $author;
    public $hero;
    public $created_at;

    public function rules()
    {
        return [
            [['appellation', 'author', 'hero', 'created_at'], 'string'],
            [['appellation', 'author', 'hero', 'created_at'], 'safe'],
        ];
    }
}
