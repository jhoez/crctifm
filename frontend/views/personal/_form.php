<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Perscomedor */
/* @var $form yii\widgets\ActiveForm */
$fecha = date( "Y-m-d h:i:s",time() );
?>

<div class="pers-form">
	<div class="row clearfix">
		<div class="col-md-offset-4 col-md-4">
			<?php $form = ActiveForm::begin([
				'id'=>'formp',
			    //'enableAjaxValidation' => true,
			]); ?>
			<?= Html::activeHiddenInput($perscomedor,'created_at',['value'=>$fecha]);?>
			<div class="form-group">
				<?= $form->field($perscomedor, 'fkpers')->checkboxList(
					ArrayHelper::map($personal,'idpers','nombcompleto'),
					[
						'itemOptions'=>['style'=>"display:inline-block;"]
					]
				);?>
			</div>
			<div class="form-group">
				<?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
