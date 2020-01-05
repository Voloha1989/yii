<?php

use kartik\dynagrid\DynaGrid;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchBooks */
/* @var $dataProvider yii\data\ActiveDataProvider */
/**
 * @var \frontend\models\UploadForm $uploadForm
 */

?>
<div class="books-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $columns = [
        ['class' => 'kartik\grid\SerialColumn', 'order' => DynaGrid::ORDER_FIX_LEFT],

        //'id',
        'appellation',
        //'text:ntext',
        //'author_id',
        'authorName',
        'created_at',
        //'updated_at',

        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'order' => DynaGrid::ORDER_FIX_RIGHT
        ],
        ['class' => 'kartik\grid\CheckboxColumn', 'order' => DynaGrid::ORDER_FIX_RIGHT],
    ];
    ?>

    <?php
    $form = ActiveForm::begin([
        'action' => Url::to(['/csv/upload'])
    ]);

    echo $form->field($uploadForm, 'file')->fileInput();

    ?>
    <input type="submit" class="btn btn-primary" value="import">
    <?
    ActiveForm::end();
    ?>

    <?php
    echo DynaGrid::widget([
        'columns' => $columns,
        'storage' => DynaGrid::TYPE_COOKIE,
        'theme' => 'panel-danger',
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
            'panel' => [
                'heading' => '<h3 class="panel-title">  Books',
                'before'=>'{dynagrid}'/* . Html::a('import', '/csv/upload', ['class'=>'btn btn-primary'])*/,
            ],
        ],
        'options' => ['id' => 'dynagrid-1']
    ]); ?>

</div>
