<?php

use frontend\models\Author;
use frontend\models\Hero;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Books */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'appellation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author_id')->dropDownList(
        ArrayHelper::map(Author::find()->all(), 'id', 'name'),
        [
            'prompt' => '',
        ]
    ) ?>

    <?= $form->field($model, 'hero_id')->dropDownList(
        ArrayHelper::map(Hero::find()->all(), 'id', 'name'),
        [
            'prompt' => '',
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        <?= Html::a('Backward', ['author/index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
