<?php

namespace frontend\modules\api\models;

use frontend\models\Books;

class Book extends Books
{
    public function fields()
    {
        return [
            'id',
            'appellation',
            'author' => function(){
                return $this->author->name;
            },
            'hero' => function(){
                return $this->hero->name;
            },
            'created_at'
        ];
    }
}
