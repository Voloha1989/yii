<?php

namespace frontend\controllers;

use Yii;
use frontend\models\BooksHistory;
use frontend\models\UploadForm;
use frontend\models\Books;
use frontend\models\SearchBooks;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\DetailView;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Books models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchBooks();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $uploadForm = new UploadForm();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadForm' => $uploadForm,
        ]);
    }

    /**
     * Displays a single Books model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Books();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveBookHistory($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->saveBookHistory($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function saveBookHistory($model) {

        $bookHistory = new BooksHistory();
        $bookHistory->book_id = $model->id;
        $bookHistory->text = $model->text;
        $bookHistory->created_at = $model->updated_at;
        $bookHistory->save();
    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAjax($id)
    {
        $model = $this->findModel($id);

        $hero = $model->hero;

        if (Yii::$app->request->isAjax) {

            if ($hero == null) {
                return "Hero not found";
            } else {
//                $hero = ("id: " . $hero->id . "\n"
//                    . "name: " . $hero->name . "\n"
//                    . "description: " . $hero->description . "\n"
//                    . "image: " . $hero->image . "\n"
//                    . "created_at: " . $hero->created_at . "\n");
//                return $hero;
                return DetailView::widget(['model' => $hero]);
            }
        }

        return $this->render('view', [
            'hero' => $hero,
        ]);
    }
}
