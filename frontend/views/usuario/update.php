<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Usuario */

$this->title = Html::encode($usuario->iduser);
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="us-update">
    <p>
        <?= Html::a('Usuarios', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'usuario' => $usuario,
        'departamento'=>$departamento,
    ]) ?>

</div>
