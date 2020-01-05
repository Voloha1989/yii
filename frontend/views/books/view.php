<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Books */

$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'model' => $model,
        'attributes' => [
            'id',
            'appellation',
            'text:ntext',
            'author_id',
            'hero_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <div class="text-right">

        <?php $form = ActiveForm::begin() ?>

        <?= Html::submitButton('Show hero', ['class' => 'btn btn-success']); ?>

        <?php ActiveForm::end(); ?>

    </div>

    <div id="hero_data"></div>
    <?php
    $js = "
    $('form').on('beforeSubmit', function(){
        $.ajax({
            url: '/frontend/web/books/ajax',
            type: 'GET',
            dataType: 'html',
            data: {id : {$model->id}},
            success: function(data){
                $('#hero_data').html(data);
            },
            error: function(){
                alert('Error!');
            }
        });
        return false;
    });
";
    $this->registerJs($js);
    ?>

</div>

    <div class="text-left">

        <?php
        $history = $model->history;
        if ($history != null && count($history) > 1) { ?>
        <h1><?= Html::encode("Book History") ?></h1>
        <?php
        }?>

        <?php
            foreach ($history as $chapter) {

                if($model->updated_at == $chapter->created_at
                    || $chapter->text == null) {
                    continue;
                }

                echo '<H4>' . $chapter->created_at . '</H4></<br>';
                echo '<dl>' . $chapter->text . '</dl></<br>';
            }
            echo '</dl>'; ?>
    </div>
