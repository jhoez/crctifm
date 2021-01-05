<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Inicio Session';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row clearfix">
		<div class="col-md-offset-3 col-md-6">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="form-group">
                <?= $form->field($loginform, 'username')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($loginform, 'password')->passwordInput() ?>
            </div>
            <div class="form-group">
                <?php $form->field($loginform, 'rememberMe')->checkbox(['checked'=>true]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary', 'name'=>'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
