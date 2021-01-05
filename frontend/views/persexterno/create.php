<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Invitado */

$this->title = 'Añadir Personal Externo';
$this->params['breadcrumbs'][] = ['label' => 'Personal externo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inv-create">
	<p>
        <?= Html::a('Personal externo', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'persexterno' => $persexterno,
    ]) ?>

</div>
