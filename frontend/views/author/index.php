<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchAuthor */
/* @var $searchModel frontend\models\Author */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create author', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create book', ['books/create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create hero', ['hero/create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('My Heroes', ['hero/index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Library', ['books/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('List Authors and Books', ['list'], ['class' => 'btn btn-info']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'filter' => ArrayHelper::map(\frontend\models\Author::find()->all(), 'id', 'name')
            ],

            'name',
            'patronymic',
            'surname',
            'created_at',
            //'updated_at',
            'amount_books',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
