<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SearchPerscomedor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perscomedor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idperscom') ?>

    <?= $form->field($model, 'fkpers') ?>

    <?= $form->field($model, 'fkuser') ?>

    <?= $form->field($model, 'fkdepart') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
