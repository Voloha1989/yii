<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $authors array
 */

?>

<div class="text-center">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    foreach($authors as $author) {
        echo '<h2>' . $author->id . ') ' . '<em>',$author->name . '</em>','</h2>';
        echo '<dl>';
        foreach ($author->books as $book) {
            echo '<dl>' . $book->appellation . '</dl>';
        }
        echo '</dl>';
    } ?>

</div>
