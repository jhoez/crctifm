<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Invitado */
/* @var $form yii\widgets\ActiveForm */
$fecha = date('Y-m-d');
?>

<div class="invitado-form">
	
	<div class="row clearfix">
		<div class="col-md-offset-4 col-md-4">
			<?php $form = ActiveForm::begin(); ?>
			<?= Html::activeHiddenInput($persexterno,'created_at',['value'=>$fecha]);?>
			<div class="form-group">
				<?= $form->field($persexterno, 'ci')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="form-group">
				<?= $form->field($persexterno, 'nombcompleto')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="form-group">
				<?= $form->field($persexterno, 'ente')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="form-group">
				<?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>

</div>
