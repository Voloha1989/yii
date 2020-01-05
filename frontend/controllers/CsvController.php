<?php

namespace frontend\controllers;

use Yii;
use Exception;
use frontend\models\Author;
use frontend\models\Books;
use frontend\models\UploadForm;
use yii\web\Controller;
use yii\web\UploadedFile;

class CsvController extends Controller
{
    /**
     * @return string
     */
    public function actionUpload()
    {
        try {

            $model = new UploadForm();

            if (Yii::$app->request->isPost) {
                $model->file = UploadedFile::getInstance($model, 'file');

                if ($model->file && $model->validate()) {
                    $model->file->saveAs(Yii::getAlias("@frontend/web/csv/") . $model->file->baseName . '.' . $model->file->extension);
                }
            }

            if (($handle = fopen("../web/csv/" . $model->file->name, "r")) !== FALSE) {
                while (($date = fgetcsv($handle, 1000, ",")) !== FALSE) {

                    if ($date[0] === "#" || $date[1] === "Appellation" ||
                        $date[2] === "Author Name" || $date[3] === "Created At") {

                        continue;
                    }

                    $books = new Books();

                    $books->appellation = $date[1];
                    $author = Author::find()->where(['name' => $date[2]])->one();
                    $books->author_id = $author->id;
                    $books->created_at = $date[3];
                    $books->save();
                }

                fclose($handle);
            }

        } catch (Exception $e) {
            echo 'import failed: ', $e->getMessage(), "\n";
            die();
        }

        return $this->render('upload', ['model' => $model]);
    }
}
