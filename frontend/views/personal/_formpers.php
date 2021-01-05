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
				<div class="form-group">
					<?= $form->field($personal, 'nombcompleto')->textInput();?>
				</div>

				<div class="form-group">
					<?= $form->field($personal, 'ci')->textInput();?>
				</div>

				<div class="form-group">
	            	<?= $form->field($personal,'sexo')->radioList(
	            		['M'=>'Masculino','F'=>'Femenino']
	            	)?>
	            </div>

				<div class="form-group">
	            	<?= $form->field($personal,'fkuser')->dropDownList(
	            		ArrayHelper::map($userpers, 'iduser', 'username'),
	            		['prompt' => '---- Seleccione ----','class' => 'form-control input-md']
	            	)?>
	            </div>

				<div class="form-group">
	            	<?= $form->field($personal,'fkdepart')->dropDownList(
	            		ArrayHelper::map($departamento, 'iddepart', 'nombdepart'),
	            		['prompt' => '---- Seleccione ----','class' => 'form-control input-md']
	            	)?>
	            </div>

				<div class="form-group">
					<?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
