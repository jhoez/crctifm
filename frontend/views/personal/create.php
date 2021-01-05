<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Perscomedor */

$this->title = 'Agregar personal';
$this->params['breadcrumbs'][] = ['label' => 'Personal comedor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pers-create">
	<p><?=Html::a('Personal comedor',['index'],['class'=>'btn btn-primary'])?></p>

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'personal' => $personal,
        'perscomedor' => $perscomedor,
    ]) ?>

</div>
