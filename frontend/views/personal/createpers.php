<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Perscomedor */

$this->title = 'Crear personal';
$this->params['breadcrumbs'][] = ['label' => 'Personal', 'url' => ['indexpers']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pers-create">
	<p><?=Html::a('Personal',['indexpers'],['class'=>'btn btn-primary'])?></p>

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formpers', [
		'personal' => $personal,
		'departamento'=>$departamento,
		'userpers'=>$userpers
    ]) ?>

</div>
