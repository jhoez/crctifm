<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="us-form">
    <div class="row clearfix">
        <div class="col-md-offset-4 col-md-4">
            <?php $form = ActiveForm::begin(); ?>
            <div class="form-group">
            	<?= $form->field($usuario, 'username')->textInput() ?>
            </div>
            <div class="form-group">
            	<?= $form->field($usuario, 'password')->passwordInput() ?>
            </div>
            <div class="form-group">
            	<?= $form->field($usuario, 'email')->textInput() ?>
            </div>
            <div class="form-group">
            	<?= $form->field($usuario,'fkdepart')->dropDownList(
            		ArrayHelper::map($departamento, 'iddepart', 'nombdepart'),
            		['prompt' => '---- Seleccione ----','class' => 'form-control input-md']
            	)?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
