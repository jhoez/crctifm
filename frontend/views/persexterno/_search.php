<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\InvitadoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invitado-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idinv') ?>

    <?= $form->field($model, 'ci') ?>

    <?= $form->field($model, 'nombcompleto') ?>

    <?= $form->field($model, 'ente') ?>

    <?= $form->field($model, 'fkuser') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
