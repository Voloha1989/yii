<?php

namespace frontend\modules\api\controllers;

use Yii;
use frontend\models\Books;
use frontend\modules\api\forms\BookForm;
use frontend\modules\api\models\Book;
use frontend\modules\api\models\SearchBook;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\Response;

class BooksController extends ActiveController
{
    /** @var Book model */

    public $modelClass = Book::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['update']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    public function actionList()
    {
        return Book::find()->all();
    }

    public function actionUpdate($id)
    {
        $bookForm = new BookForm();

        $bookForm->load(Yii::$app->request->getBodyParams(), '');

        if ($bookForm->validate()) {

            $model = Books::findOne($id);

            $model->setAttributes($bookForm->getAttributes());

            if ($model->save()) {
                return $model;
            }
        }

        return null;
    }

    public function prepareDataProvider()
    {
        $bookForm = new BookForm();

        $bookForm->load(Yii::$app->request->queryParams, '');

        if ($bookForm->validate()) {

            $bookSearch = new SearchBook();

            return $bookSearch->search($bookForm->getAttributes());
        }

        return null;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
                'languages' => [
                    'en',
                    'ru',
                ],
            ],
        ]);
    }
}
